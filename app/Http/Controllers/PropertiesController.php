<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Person;
use App\PropertyType;
use App\PersonProperty;
use Illuminate\Support\Facades\DB;
class PropertiesController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $person_id = $request->id;

        //dd($request->lot_number);

        if($person_id == null && $request->lot_number == ""){
            $properties = Property::paginate(10);

            $person = null;
        }
        else{
            $person = Person::find($person_id);
            //dd($request->lot_number);
            $properties = Property::SearchByLotNumber($request->lot_number)->paginate(10);
            //$properties = $person->properties()->paginate(10);;

            //dd($properties->count());
        }

        //dd($properties);
        return view("Properties.index", compact('properties','person'));
    }


    public function GetPropertiesByLotNumber($lot_number){
        DB:Table('properties')
        ->join('property_types','property_types.id','=','properties.property_type_id')
        ->join('person_property','person_property.property_id','=','properties.id')
        ->join('persons','person.id','=','person_property.person_id')
        ->select(
            'property_types.name as property_type_name',
            'properties.lot_number',
            'persons.name as person_name'
        )
        ->where('properties.lot_number','=',$lot_number)
        ->get();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create($personId)
     {
        $propertyTypes = PropertyType::pluck('name','id');
         return view("Properties.create",compact('propertyTypes','personId'));
     }

     public function store(Request $request){
         //dd($request);
            $property = new Property($request->all());
            DB::beginTransaction();
            try{
                    $property->save();
                    if ($request->personId != 0)
                    { 
                        $personProperty = new PersonProperty();
                        $personProperty->person_id = $request->personId; 
                        $personProperty->property_id = $property->id;
                        $personProperty->owner = false;
                        $personProperty->save();
                        //$person= Person::find($request->personId);
                        //$person->properties()->save($property);
                    }

                 //$property->tags()->sync($request->tags);
                 flash('Propiedad Creada.', 'info')->important();
            }
            catch(Exception $ex)
            {
                 DB::rollBack();
                 flash('Propiedad no fue Creada.', 'info')->important();
            }
            DB::commit();
            return redirect()->route('Properties.index');
         }




     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {

         $property = Property::find($id);
         $data = [
             'property' => $property,
         ];
         return view('Properties.edit',$data);
     }
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, $id)
     {
         $properties = Property::find($id);
         $properties->fill($request->all());
         $properties->save();
         flash("Grabado correctamente")->success();
         return redirect()->route('Properties.index');
     }






}

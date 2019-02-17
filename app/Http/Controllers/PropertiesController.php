<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;
use App\Property;
use App\Person;
use App\PropertyType;
use App\PersonProperty;
use App\Payment;
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
        $lot_number=$request->lot_number;
        $lot_number_search = $request->lot_number_search;
        $properties = null;
        $propertiesPerson = null;

//dd($request);

        if($person_id == null && $lot_number == null ){
            $properties = Property::orderBy('lot_number', 'asc')->paginate(10);
            $person = null;
        }
        else if($person_id != null && $lot_number == null){
            $person = Person::find($person_id);
            $propertiesPerson = $person->properties()->orderBy('lot_number', 'asc')->paginate(10);
        }
        else if ($person_id == null && $lot_number != null) {
            $properties = Property::SearchByLotNumber($request->lot_number)->paginate(10);
            $person = null;
        }
        else if ($person_id != null && $lot_number != null) {
            $properties = Property::SearchByLotNumber($request->lot_number)->paginate(10);
            $person = Person::find($person_id);
        }

//dd($propertiesPerson);

        if($properties == null){
          flash('No hay Propiedades Registradas.', 'info');
        }

        dd($person_id);

        return view("Properties.index", compact('properties','propertiesPerson','person','person_id','lot_number'));
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

     public function store(PropertyRequest $request){
         //dd($request);
            $property = new Property($request->all());

            if ($property->address ==null){
              $property->address="";
            }
            DB::beginTransaction();
            try{
                    $property->save();
                    if ($request->personId != 0)
                    {
                        $personProperty = new PersonProperty();
                        $personProperty->person_id = $request->personId;
                        $personProperty->property_id = $property->id;
                        $personProperty->date_from = $request->date_from;
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
     public function edit($propertyId,$personId)
     {
         $propertyTypes = PropertyType::pluck('name','id');
         $property = Property::find($propertyId);
         if( $personId != 0 ){
             $personProperty = PersonProperty::where('property_id', $propertyId)
                                ->where('person_id',$personId)
                                ->take(1)
                                ->get();
         }else{
             $personProperty = null;
         }

         $data = [
             'property' => $property,
             'personId' => $personId,
             'personProperty' => $personProperty,
             'propertyTypes' => $propertyTypes,
         ];
         //dd($data);
         return view('Properties.edit',$data);
     }
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(PropertyRequest $request, $id)
     {
         $properties = Property::find($id);
         $properties->fill($request->all());

         $properties->save();
         if($request->personPropertyId != null){
             $personProperty = PersonProperty::find($request->personPropertyId);
             $personProperty->date_from = $request->date_from;
             $personProperty->date_to = $request->date_to;
             $personProperty->save();
         }



         flash("Grabado correctamente")->success();
         return redirect()->route('Properties.index');
     }

     public function destroy($id)
     {
         $property = Property::find($id);//orderBy('id','desc');
         if ($property->payments()->count() > 0){
             flash('La propiedad tiene pagos asociados. No puede ser eliminada', 'danger')->important();
         }
         else{
             $personProperties = PersonProperty::Where('property_id','=',$id)->get();//orderBy('id','desc');
             //dd($personProperties);
             foreach ($personProperties as $personProperty) {
                 $personProperty->delete();
             }
             $property->delete();
             flash('Se ha eliminado correctamente.', 'danger')->important();
         }
         return redirect()->route('Properties.index');
     }


     // public function select($propertyId, $personId){
     //
     //   $property = Property::find($propertyId);
     //   //$property->fill($request->all());
     //   //$properties->save();
     //   if($propertyId != null){
     //       $personProperty = PersonProperty::find($personId);
     //       $personProperty->date_from = $request->date_from;
     //       $personProperty->date_to = $request->date_to;
     //       $personProperty->save();
     //   }
     //
     //
     //   return redirect()->route('Properties.index');
     // }


}

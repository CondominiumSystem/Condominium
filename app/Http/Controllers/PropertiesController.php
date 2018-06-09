<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Person;
use App\PropertyType;
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

        if($person_id == null){
            $properties = Property::paginate(10);
            $person = null;
        }
        else{
            $person = Person::find($person_id);
            $properties = $person->properties()->paginate(10);
        }

        //dd($properties);
        return view("Properties.index", compact('properties','person'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
        $propertyTypes = PropertyType::pluck('name','id');
         //
         return view("Properties.create",compact('propertyTypes'));
     }

     public function store(Request $request){

             $property = new Property($request->all());
             DB::beginTransaction();
             try{
                 $property ->save();

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

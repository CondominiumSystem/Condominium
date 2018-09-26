<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\PersonType;
class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $persons = Person::Search($request->name,$request->document_number)->paginate(10);
        $person_types=PersonType::pluck('name','id');

        return view("Persons.index", compact('persons','person_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $person_types=PersonType::pluck('name','id');

        return view("Persons.create",compact('person_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Person($request->all());
        $person->user_id = \Auth::user()->id;
        $person->save();
        return redirect()->route('Persons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $person_types=PersonType::pluck('name','id');
        $persons = Person::find($id);
        $data = [
            'person' => $persons,
            'person_types'=>$person_types,
        ];
        return view('Persons.edit',$data);
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
        $person = Person::find($id);
        //$customer->name = $request->name;
        $person->fill($request->all());
        $person->save();
        flash("Grabado correctamente")->success();
        return redirect()->route('Persons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Person::find($id);//orderBy('id','desc');
        $property->delete();
        flash('Se ha eliminado correctamente.', 'danger')->important();
        return redirect()->route('Persons.index');
    }


}

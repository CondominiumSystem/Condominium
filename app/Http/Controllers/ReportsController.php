<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Period;
use App\PersonType;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View("Reports.persons");
    }

    public function getPaymentsIndex(Request $request){

        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');

        return view("Reports.payments",compact('years','person_types'));
    }

    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function paymentsData(Request $request){


        //$person_types_id,$year)

        $payments = DB::table('payments')
            ->join('person_property', 'person_property.id', '=', 'payments.property_id')
            ->join('persons','persons.id','=','person_property.person_id')
            ->join('properties','properties.id','=','person_property.id')
            ->join('periods','periods.id','=','payments.period_id')
            ->join('person_types','person_types.id','=','persons.person_type_id')
            ->select(
                'persons.name as person_name',
                'person_types.name as person_type_name',
                'properties.lot_number',
                'payments.value',
                'periods.year',
                'periods.month_name');
            //->where('periods.year', '=',$year)
            //->where('person_types', '=',$person_types_id );
            return Datatables::of($payments)->make(true);

           }

}

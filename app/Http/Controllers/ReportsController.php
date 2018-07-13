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

    public function getPaymentsIndex(Request $request){
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return view("Reports.payments",compact('years','person_types'));
    }


    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }


    public function paymentsData(Request $request){
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


    public function getPortfolioReceivableIndex(Request $request){
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return view("Reports.
        ",compact('years','person_types'));
    }


}

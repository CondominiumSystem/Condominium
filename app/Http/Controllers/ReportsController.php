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
//Presenta la vista payments de datos con los combos de años y periodos
    public function getPaymentsIndex(Request $request){
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return view("Reports.payments",compact('years','person_types'));
    }


    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }

//Obtiene los datos para el reporte
    public function paymentsData(Request $request){
        $payments = DB::table('payments')
            ->join('person_property', 'person_property.property_id', '=', 'payments.property_id')
            ->join('persons','persons.id','=','person_property.person_id')
            ->join('properties','properties.id','=','person_property.property_id')
            ->join('periods','periods.id','=','payments.period_id')
            ->join('person_types','person_types.id','=','persons.person_type_id')
            ->select(
                'persons.name as person_name',
                'person_types.name as person_type_name',
                'properties.lot_number',
                'payments.value',
                'periods.year',
                'periods.month_name');
            //    ->orderColumn('periods.year', 'properties.lot_number $1');
            //->where('periods.year', '=',$year)
            //->where('person_types', '=',$person_types_id );
            //return Datatables::of($payments)->make(true);


            return Datatables::of($payments)
            ->filter(function ($query) use ($request) {
                if ($request->has('year')) {
                    if($request->get('year') != ""){
                        $query->where('periods.year', '=', "{$request->get('year')}");
                    }
                }

                if ($request->has('person_type_id')) {
                    if($request->get('person_type_id') != ""){
                        $query->where('person_types.id', '=', "{$request->get('person_type_id')}");
                    }
                }
            })
            ->make(true);
    }


    public function getPortfolioReceivableIndex(Request $request){
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return view("Reports.portfolioReceivable",compact('years','person_types'));
    }

    public function portfolioReceivableData(Request $request){
        $strConsulta='select
                person_name,
                person_type_name,
                lot_number,
                value,
                payment_value,
                year,
                month_name, month_id from paymentsview';
                $payments = DB::select($strConsulta);

        $validYear = ($request->has('year') && $request->get('year') != "" );
        $validPersonType = ($request->has('person_type_id') && $request->get('person_type_id') != "" );
        $year = $request->get('year');
        $personType = $request->get('person_type_id');

        if( $validYear || $validPersonType ){
            $strConsulta .= ' where';
            if ($validYear && !$validPersonType) {
                $strConsulta = $strConsulta . ' year = ' . $year;
            }
            if (!$validYear && $validPersonType) {
                $strConsulta = $strConsulta . ' person_type_id = ' . $personType;
            }
            if ($validYear && $validPersonType) {
                $strConsulta = $strConsulta . ' year = ' . $year;
                $strConsulta = $strConsulta . ' and person_type_id = ' . $personType;
            }
            $payments = DB::select($strConsulta);
        }


        //$payments = DB::select($strConsulta,[$request->get('year')]);

        return Datatables::of($payments)->make(true);
    }


}

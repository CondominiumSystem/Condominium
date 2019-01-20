<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\DataTables\PortfolioReceivableDataTable;
use App\DataTables\PaymentsDataTable;
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

    /**
     * getIndex
     */
    public function totalPayments(PaymentsDataTable $dataTable)
    {
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return $dataTable->render('Reports.totalPayments',compact('years','person_types'));
    }

    /**
     * getIndex
     */
    public function totalPorfolioReceivable(PortfolioReceivableDataTable $dataTable)
    {
        $years = $this->GetPeriods();
        $person_types=PersonType::pluck('name','id');
        return $dataTable->render('Reports.totalPorfolioReceivable',compact('years','person_types'));
    }

    public function GetPeriods(){
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
            lot_number,
            year,
            person_name,
            max(person_type_name) as person_type_name,
            max(date_from) as date_from,
            max(date_to) as date_to,
            sum(IF(month_id = 1, payment_value, 0)) AS ENE,
            sum(IF(month_id = 2, payment_value, 0)) AS FEB,
            sum(IF(month_id = 3, payment_value, 0)) AS MAR,
            sum(IF(month_id = 4, payment_value, 0)) AS ABR,
            sum(IF(month_id = 5, payment_value, 0)) AS MAY,
            sum(IF(month_id = 6, payment_value, 0)) AS JUN,
            sum(IF(month_id = 7, payment_value, 0)) AS JUL,
            sum(IF(month_id = 8, payment_value, 0)) AS AGO,
            sum(IF(month_id = 9, payment_value, 0)) AS SEP,
            sum(IF(month_id = 10, payment_value, 0)) AS OCT,
            sum(IF(month_id = 11, payment_value, 0)) AS NOV,
            sum(IF(month_id = 12, payment_value, 0)) AS DIC,
            SUM(payment_value) AS TOTAL,
            SUM(value) AS DEUDA
            from paymentsview';

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
        }

        $strConsulta = $strConsulta . ' group by lot_number,person_name, year';
        $strConsulta = $strConsulta . ' order by lot_number,person_name, year';

        $payments = DB::select($strConsulta);

        return Datatables::of($payments)->make(true);
    }
}

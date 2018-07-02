<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Period;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request )
     {
//        dd($request->document_number);

        if($request->document_number != null){
             dd($request->document_number);
        }
        else
        {
            if($request->lot_number != null){
                //dd($request->lot_number);
               $properties= $this->GetPropertiesByLotNumber($request->lot_number);
               //Obtenemos los pagos
               $payments=$this->GetPaymentsByPropertyId(10,2018);
//               dd($payments);
            }
            else
            {
                $properties=null;
                $payments = null;
            }
        }

         $persons = Person::Search($request->name,$request->document_number)->paginate(4);
        return View("Payments.index",compact('persons','properties','payments'));
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

    /**
     * @param  $lot_number [Número de Lote]
     */
    public function GetPropertiesByLotNumber($lot_number){

        $result_list=DB::Table('properties')
        ->join('property_types','property_types.id','=','properties.property_type_id')
        ->join('person_property','person_property.property_id','=','properties.id')
        ->join('persons','persons.id','=','person_property.person_id')
        ->select(
            'property_types.name as property_type_name',
            'properties.lot_number',
            'persons.name as person_name'
        )
        ->where('properties.lot_number','=',$lot_number)
        ->get();
        //dd($Mylist);
        return $result_list;
    }

    public function GetPaymentsByPropertyId($property_id,$year){
        //Pagos realizados
        $payments=DB::Table('payments')
        ->rightjoin('periods','periods.id','=','payments.period_id')
        ->select(
            'periods.month_id',
            'periods.month_name',
            'payments.value'
        )
        ->where('periods.year','=',$year)
        ->where('payments.property_id','=',$property_id)
        ->get();


        //Valor a pagar por periodo
        $result_value=DB::Table('properties')
        ->join('aliquot_values','aliquot_values.property_type_id','=','properties.property_type_id')
        ->select('aliquot_values.value')
        ->where('properties.id','=',$property_id)
        ->first();

        //dd($result_value->value);

        //Todos los periodos
        $periods= Period::where('year',2018)->orderBy('id')->get();

        $result = [];
        foreach ($periods as $period) {
            array_push($result,[
                'period_id' => $period->id,
                'month_id' => $period->month_id,
                'month_name' => $period->month_name,
                'quota' => $result_value->value,
                'is_payment' => false,
            ]);
        }

        //Actualizamos pagos realizados
        foreach ($payments as $payment) {
            $result[$payment->month_id - 1]["is_payment"] = true;
        }

        return $result;
    }

}

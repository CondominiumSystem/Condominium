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
        $selected_period = $request->period_id;


        if($request->document_number != null){
             $properties= $this->GetPropertiesByDocumentNumber($request->document_number);
             $payments = null;
        }
        else
        {
            if($request->lot_number != null){
                //dd($request->lot_number);
               $properties= $this->GetPropertiesByLotNumber($request->lot_number);
               //Obtenemos los pagos
               $payments=$this->GetPaymentsByPropertyId(10,$selected_period);
            }
            else
            {
                $properties=null;
                $payments = null;
            }
        }

        $periods = $this->GetPeriods();
        $lot_number = $request->lot_number;
        $persons = Person::Search($request->name,$request->document_number)->paginate(4);
        return View(
            "Payments.index",
            compact(
                'persons',
                'properties',
                'payments',
                'periods',
                'selected_period',
                'lot_number'
            ));
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
        dd($request);
        //$person = new Person($request->all());
        //$person->user_id = \Auth::user()->id;
        //$person->save();
        //return redirect()->route('Persons.index');
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

    public function GetPropertiesByDocumentNumber($document_number)
    {
        $result = DB::Table('persons')
        ->join('person_property','person_property.person_id','=','persons.id')
        ->join('properties','properties.id','=','person_property.property_id')
        ->join('property_types','property_types.id','=','properties.property_type_id')
        ->select(
            'property_types.name as property_type_name',
            'properties.lot_number',
            'persons.name as person_name'
        )
        ->where('persons.document_number','=',$document_number)
        ->get();

        return $result;
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
            array_push($result,(object)[
                'period_id' => $period->id,
                'month_id' => $period->month_id,
                'month_name' => $period->month_name,
                'quota' => $result_value->value,
                'is_payment' => false,
            ]);
        }

        //Actualizamos pagos realizados
        foreach ($payments as $payment) {
            $result[$payment->month_id - 1]->is_payment = true;
        }
        return (object)$result;
    }

    /*
    * Listado de periodos vigentes
    */
    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }

}

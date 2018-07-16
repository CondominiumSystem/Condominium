<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Period;
use App\Payment;
use App\PersonProperty;
use Carbon\Carbon;
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
               $properties= $this->GetPropertiesByLotNumber($request->lot_number);
               if($properties->count() == 1 ){
                   //Obtenemos los pagos
                   $payments=$this->GetPaymentsByPropertyId(
                       $properties->first()->id,
                       $selected_period,
                       $properties->first()->person_id
                   );
               }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $result_value=DB::Table('properties')
        ->join('aliquot_values','aliquot_values.property_type_id','=','properties.property_type_id')
        ->select('aliquot_values.value')
        ->where('properties.id','=',$request->property_id)
        ->first();

        //dd($result_value->value);

        $periods = $request->active;

        foreach ($periods as $period) {
            $payment = new Payment();

            $payment->property_id = $request->property_id;
            $payment->user_id = 1;
            $payment->transaction_id = 1;
            $payment->transaction_parent_id = 0;
            $payment->value = $result_value->value;
            $payment->active = true;
            $payment->period_id = $period;

            $payment->save();
        }


        //$person = new Person($request->all());
        //$person->user_id = \Auth::user()->id;
        //$person->save();
        return redirect()->route('Payments.index');
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
            'properties.id',
            'persons.name as person_name',
            'persons.id as person_id',
            'person_property.date_from',
            'person_property.date_to'
        )
        ->where('properties.lot_number','=',$lot_number)
        ->get();
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
            'properties.id',
            'persons.name as person_name',
            'persons.id as person_id',
            'person_property.date_from',
            'person_property.date_to'
        )
        ->where('persons.document_number','=',$document_number)
        ->get();

        return $result;
    }


    public function GetPaymentsByPropertyId($property_id,$year,$person_id){
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

        $personProperty = PersonProperty::Where('property_id',$property_id)
        ->where('person_id',$person_id)
        ->orderBy('id','desc')
        ->first();

        //Todos los periodos
        $periods= Period::Where('year','=',$year);
        $periods = $periods->Where('year','>=',Carbon::parse($personProperty->date_from)->year);

        if($personProperty->date_from != null){
            $periods = $periods->Where('year','<=',Carbon::parse($personProperty->date_to)->year);
            $periods = $periods->Where('month_id','<=',Carbon::parse($personProperty->date_to)->month);
        }

        $periods = $periods->orderBy('id')->get();

        //dd($periods);

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

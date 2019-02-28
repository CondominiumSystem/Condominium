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
        // $selected_period = $request->period_id;
        // dd($selected_period);

        if($request->document_number != null){
             $properties= $this->GetPropertiesByDocumentNumber($request->document_number);
             //dd($properties);
             $payments = null;
             if($properties == null || $properties->count() == 0){
                 flash("No se encontraron registros ")->warning();
             }else {
               foreach ($properties as $property) {
                // dd($property);
                 //if($property->date_to == null){
                   $payments=$this->GetPaymentsByPropertyId(
                       $property->id,
                       $property->person_id
                   );
                // }
               }
               flash("Hay varias propiedades ")->warning();
             }
        }
        else
        {
            if($request->lot_number != null){
               $properties= $this->GetPropertiesByLotNumber($request->lot_number);
               if($properties->count() >= 1 ){
                   //Obtenemos los pagos
                   //enviar la propiedad viegente

                   $payments=$this->GetPaymentsByPropertyId(
                       $properties->first()->id,
                    //   $selected_period,
                       $properties->first()->person_id
                   );
               }
               else{
                   flash("No se encotraron registros")->success();
                   $properties=null;
                   $payments = null;
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
        $persons = Person::Search($request->name,$request->document_number,0)->paginate(4);
        return View(
            "Payments.index",
            compact(
                'persons',
                'properties',
                'payments',
                'periods',
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
        $result_value=DB::Table('properties')
        ->join('aliquot_values','aliquot_values.property_type_id','=','properties.property_type_id')
        ->select('aliquot_values.value')
        ->where('properties.id','=',$request->property_id)
        ->first();
        $transaction_id = time();

        $periods = $request->active;
        foreach ($periods as $period) {
            $payment = new Payment();
            $payment->property_id = $request->property_id;
            $payment->user_id = \Auth::user()->id;
            $payment->transaction_id = $transaction_id;
            $payment->transaction_parent_id = 0;
            $payment->value = $result_value->value;
            $payment->active = true;
            $payment->period_id = $period;
            $payment->save();
        }
        flash("Pago Grabado correctamente. Transacción: ".$transaction_id)->success();
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

    public function GetPaymentsByPropertyId($property_id,$person_id){

      $strConsulta='select
          lot_number, month_name, month_id,value,payment_value,
          year, period_id
          from paymentsview';

      if( $person_id > 0 && $property_id > 0 ){
          $strConsulta .= ' where';

          if ($person_id > 0) {
              $strConsulta = $strConsulta . ' person_id = ' . $person_id;
          }
          if ($property_id > 0) {
              $strConsulta = $strConsulta . ' and property_id = ' . $property_id;
          }
      }

      // $strConsulta = $strConsulta . ' group by lot_number,person_name, year';
      // $strConsulta = $strConsulta . ' order by lot_number,person_name, year';

      $payments = DB::select($strConsulta);

      return $payments;
    }

/*
    public function GetPaymentsByPropertyId($property_id,$person_id){
        //Pagos realizados
        $payments=DB::Table('payments')
        ->rightjoin('periods','periods.id','=','payments.period_id')
        ->select(
            'periods.month_id',
            'periods.month_name',
            'payments.value'
        )
        //->where('periods.year','=',$year)
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
        $periods = $periods->Where('month_id','>=',Carbon::parse($personProperty->date_from)->month);

        $periods = $periods->orderBy('id')->get();

        $result = [];
        foreach ($periods as $period) {
            $tempDate = Carbon::parse($period->year . "/" . $period->month_id . "/1")->addMonths(1)->subDay();

            $isPayment = false;
            //Actualizamos pagos realizados
            foreach ($payments as $payment) {
                if($payment->month_id == $period->month_id){
                    $isPayment = true;
                }
            }

            if($personProperty->date_to != null && Carbon::parse($personProperty->date_to) < $tempDate )
            {
                break;
            }
            else {
                array_push($result,(object)[
                    'period_id' => $period->id,
                    'month_id' => $period->month_id,
                    'month_name' => $period->month_name,
                    'quota' => $result_value->value,
                    'is_payment' => $isPayment,
                ]);
            }
        }

        return (object)$result;
    }
*/

    /*
    * Listado de periodos vigentes
    */
    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }

}

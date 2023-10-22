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
       $lot_number = $request->lot_number;
       $document_number = $request->document_number;
       $name = $request->person_name;
        // $selected_period = $request->period_id;
        $properties = null;
        $payments = null;
        if($lot_number != null || $document_number != null || $name != null ){
            $properties= $this->GetProperties($lot_number,$document_number, $name);
            $payments = null;
            if($properties == null || $properties->count() == 0){
                flash("No se encontraron registros ")->warning();
            }
            else
            {
              if($properties->count() ==1){
                $payments=$this->GetPaymentsByPropertyId(
                    $properties->first()->id,
                    $properties->first()->person_id
                );
              }
              else{
                flash("Hay varias propiedades ")->warning();
              }
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

     public function createCondonation($propertyId){
       dd($propertyId);
       //Con el propertyId vamos a buscar los PAGOS
       // con las siguientes condiciones:
       // 1. La fecha desde debe ser igual 01/01/2010
       // 2. Debe tener fecha hasta que termine fin de mes por ejemplo 31/12/2015
       // 3. El tipo de propiedad debe ser terreno
       // Los prosesos  que se va a realizar son:
       // 1. Con el propertyId Consultamos todos los PAGOS
       // 2. Sacamos la fecha minima y maxima de los PAGOS
       // 3. Contamos el numero de cuaotas pendientes
       // 4. Consultamos del propitario y numero de lote
       return View("Payments.condonation");
     }


     public function storeCondonation(Request $request){

       return View("Payments.index");
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $result_value=DB::Table('properties')
        // ->join('aliquot_values','aliquot_values.property_type_id','=','properties.property_type_id')
        // ->select('aliquot_values.value')
        // ->where('properties.id','=',$request->property_id)
        // ->first();
        $transaction_id = time();

        $periods = $request->active;

        //dd($periods);
        foreach ($periods as $period) {
            list($periodo_id,$valor_cuata) = (explode("-", $period));
            //dd($periodo_id);
            $payment = new Payment();
            $payment->property_id = $request->property_id;
            $payment->user_id = \Auth::user()->id;
            $payment->transaction_id = $transaction_id;
            $payment->transaction_parent_id = 0;
            $payment->value = $valor_cuata;//$result_value->value;
            $payment->active = true;
            $payment->period_id = $periodo_id;
            //dd($payment);
            $payment->save();
        }
        flash("Pago Grabado correctamente. Transacción: ".$transaction_id)->success();
        return redirect()->route('Payments.index');
    }


    /**
     * @param  $lot_number [Número de Lote]
     */
    public function GetProperties($lot_number, $document_number, $name){

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
        ->when($lot_number, function ($query) use ($lot_number) {
                    return $query->where('properties.lot_number', $lot_number);
        })
        ->when($document_number, function ($query) use ($document_number) {
                    return $query->where('persons.document_number', $document_number);
        })
        ->when($name, function ($query) use ($name) {
                    return $query->where('persons.name','like', "%".$name."%");
        })
        //->where('properties.lot_number','=',$lot_number)
        ->get();

        return $result_list;
    }

    public function GetPaymentsByPropertyId($property_id,$person_id){

      $strConsulta='select
          lot_number, month_name, month_id,value,payment_value,
          year, period_id
          from paymentsview';

      if( $person_id > 0 && $property_id > 0 ){
          $strConsulta .= ' where payment_value is null ';

          if ($person_id > 0) {
              $strConsulta = $strConsulta . ' and person_id = ' . $person_id;
          }
          if ($property_id > 0) {
              $strConsulta = $strConsulta . ' and property_id = ' . $property_id;
          }
      }

      $payments = DB::select($strConsulta);

      return $payments;
    }

    /*
    * Listado de periodos vigentes
    */
    function GetPeriods(){
        return Period::distinct()->pluck('year','year');
    }



}

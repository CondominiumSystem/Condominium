<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PropertyType;
use App\AliquotValue;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class AliquotValuesController extends Controller
{
    //
    public function index()
    {
      $alicuotValues =  AliquotValue::all();
      $alicuotValues->each(function($alicuotValue){
          $alicuotValue->propertyType;
      });
      return view("AliquotValues.index",compact('alicuotValues'));
    }

    public function create(){
      $propertyTypes = PropertyType::pluck('name','id');
      return view("AliquotValues.create",compact('propertyTypes'));
    }

    public function store(Request $request)
    {

      $validatedData = $request->validate([
          'property_type_id' => 'required',
          'value' => 'required|max:255',
          'start_date' => 'required'
      ]);

      $aliquotValueFind = AliquotValue::where('property_type_id', $request->property_type_id)
      ->where('end_date',null)->first();

      $start_date = Carbon::create($request->date_from);

      $start_date = $start_date->subDay($start_date->day - 1);
      //Grabar nueva
      $aliquotValue = new AliquotValue();
      $aliquotValue->start_date = $start_date;
      $aliquotValue->property_type_id = $request->property_type_id;
      $aliquotValue->value = $request->value;
      $aliquotValue->save();

      if($aliquotValueFind->count() > 0 ){
        if($aliquotValueFind->start_date < $start_date){

            //Actualizamos anterior
            $end_date = $start_date->subDay(1);

            $aliquotValuePrevius = AliquotValue::find($aliquotValueFind->id);
            $aliquotValuePrevius->end_date = $end_date;
            $aliquotValuePrevius->save();
        }
      }



      flash("Grabado correctamente")->success();

      return redirect()->route('AliquotValues.index');
    }

    public function GetAliquotValueByPropertyTypeId($propertyTypeId)
    {
        $getstamps = DB::table('timestamps')
                        ->where('videoid', '=', $video)
                        ->orderByRaw('LENGTH(timestamp_time)', 'ASC')
                        ->orderBy('timestamp_time', 'asc')
                        ->get();

        return response()->json(array('success' => true, 'getstamps' => $getstamps));
    }



}

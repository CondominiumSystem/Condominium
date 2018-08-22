<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;


class CeciController extends Controller
{
    public function getIndex(UsersDataTable $dataTable)
    {
        //dd($dataTable);
        return $dataTable->render('Ceci.getIndex');
    }

    public function getTutorial()
    {
        return view('Ceci.getTutorial');
    }
}

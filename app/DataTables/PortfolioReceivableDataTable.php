<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Period;
use App\PersonType;

class PortfolioReceivableDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query);
            //->addColumn('action', 'usersdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $year = $this->request()->get('year');
        $personTypeId = $this->request()->get('person_type_id');

        $query = DB::table('portfolio_receivable_view')
        ->select(
          'lot_number','year','person_type_name','person_name','date_from','date_to',
          'ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC','TOTAL');

        if ($year) {
            $query = $query->where('year', '=', $year);
        }
        if ($personTypeId) {
            $query = $query->where('person_type_id', '=', $personTypeId);
        }
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns( //$this->getColumns()
                [
                    // ['data' => 'person_name', 'name' => 'persons.name', 'title' => 'Nombre Residente'],
                    // ['data' => 'person_type_name', 'name' => 'person_types.name', 'title' => 'Tipo Residente'],
                    // ['data' => 'lot_number', 'name' => 'properties.lot_number', 'title' => 'Lote'],
                    // ['data' => 'value', 'name' => 'payments.value', 'title' => 'Valor'],
                    // ['data' => 'year', 'name' => 'periods.year', 'title' => 'Año'],
                    // ['data' => 'month_name', 'name' => 'periods.month_name', 'title' => 'Mes'],

                    ['data' => 'lot_number', 'name' => 'lot_number', 'title' => 'Lote'],
                    ['data' => 'year', 'name' => 'year', 'title' => 'Año'],
                    ['data' => 'person_name', 'name' => 'person_name', 'title' => 'Nombre Persona'],
                    ['data' => 'date_from', 'name' => 'date_from', 'title' => 'Desde'],
                    ['data' => 'date_to', 'name' => 'date_to', 'title' => 'Hasta'],
                    ['data' => 'ENE', 'name' => 'ENE', 'title' => 'ENE'],
                    ['data' => 'FEB', 'name' => 'FEB', 'title' => 'FEB'],
                    ['data' => 'MAR', 'name' => 'MAR', 'title' => 'MAR'],
                    ['data' => 'ABR', 'name' => 'ABR', 'title' => 'ABR'],
                    ['data' => 'MAY', 'name' => 'MAY', 'title' => 'MAY'],
                    ['data' => 'JUN', 'name' => 'JUN', 'title' => 'JUN'],
                    ['data' => 'JUL', 'name' => 'JUL', 'title' => 'JUL'],
                    ['data' => 'AGO', 'name' => 'AGO', 'title' => 'AGO'],
                    ['data' => 'SEP', 'name' => 'SEP', 'title' => 'SEP'],
                    ['data' => 'OCT', 'name' => 'OCT', 'title' => 'OCT'],
                    ['data' => 'NOV', 'name' => 'NOV', 'title' => 'NOV'],
                    ['data' => 'DIC', 'name' => 'DIC', 'title' => 'DIC'],
                    ['data' => 'TOTAL', 'name' => 'TOTAL', 'title' => 'TOTAL'],
                ]
            )
            ->minifiedAjax()
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // 'person_name',
            // 'person_type_name',
            // 'lot_number',
            // 'value',
            // 'year',
            // 'month_name'

            'lot_number',
            'year',
            'person_name',
            'date_from',
            'date_to',
            'ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC',
            'TOTAL',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PortfolioReceivable_' . date('YmdHis');
    }
}

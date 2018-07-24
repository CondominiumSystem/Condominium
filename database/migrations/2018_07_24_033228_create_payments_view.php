<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
      CREATE VIEW payments_views AS
          select
          periods.year,
          properties.lot_number,
          periods.month_name,
          persons.name as person_name,
          person_types.name as person_type,
          property_types.name as property_type, aliquot_values.value,
          person_property.date_from, person_property.date_to,
          DATE(CONCAT(periods.year,'-',periods.month_id,'-','01'))  as desde,
          DATE_SUB(DATE_ADD(DATE(CONCAT(periods.year,'-',periods.month_id,'-','01')), INTERVAL 1 MONTH),INTERVAL 1 DAY)  as hasta,
          IFNULL(payments.value,0) as payment_value
          from periods
          join person_property
          join properties on properties.id =person_property.property_id
          join persons on persons.id = person_property.person_id
          JOIN person_types on person_types.id = persons.person_type_id
          join property_types on property_types.id =properties.property_type_id
          join aliquot_values on aliquot_values.id = properties.property_type_id
          left join payments on payments.period_id = periods.id and payments.property_id = properties.id
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS payments_views');
    }
}

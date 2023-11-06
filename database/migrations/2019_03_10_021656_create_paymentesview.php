<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentesview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("
      CREATE VIEW paymentsview AS
      select
      periods.year AS year,
      properties.lot_number AS lot_number,
      `periods`.`month_name` AS `month_name`,
      `periods`.`month_id` AS `month_id`,
      `persons`.`name` AS `person_name`,
      `person_types`.`name` AS `person_type_name`,
      `property_types`.`name` AS `property_type`,
      (case
      	when ((aliquot_values.value - ifnull(payments.value,0)) > 0)
      	then (aliquot_values.value - ifnull(payments.value,0))
      	else NULL
      	end) AS value,
      `person_property`.`date_from` AS `date_from`,`person_property`.`date_to` AS `date_to`,
      `person_types`.`id` AS `person_type_id`,
      cast(concat(periods.year,'-',periods.month_id,'-','01') as date) AS desde,
      ((cast(concat(periods.year,'-',periods.month_id,'-','01') as date) + interval 1 month) - interval 1 day) AS hasta,
      payments.value AS `payment_value`,
      persons.id AS person_id,
      properties.id AS property_id,
      periods.id AS period_id
      from (((((((`periods` join `person_property`)
      join `properties` on((`properties`.`id` = `person_property`.`property_id`)))
      join `persons` on((`persons`.`id` = `person_property`.`person_id`)))
      join `person_types` on((`person_types`.`id` = `persons`.`person_type_id`)))
      join `property_types` on((`property_types`.`id` = `properties`.`property_type_id`)))
      join aliquot_values ON(
      (
      	aliquot_values.property_type_id = properties.property_type_id
      	AND cast(concat(periods.year,'-',periods.month_id,'-','01') as DATE) BETWEEN aliquot_values.start_date AND ifnull(aliquot_values.end_date,ADDDATE(NOW(), INTERVAL 1 YEAR))
      )))
      left join `payments` on(((`payments`.`period_id` = `periods`.`id`) and (`payments`.`property_id` = `properties`.`id`))))
      where
      (
      (cast(concat(periods.year,'-',periods.month_id,'-','01') as date) >= person_property.date_from) and
      (cast(concat(periods.year,'-',periods.month_id,'-','01') as date) <= ifnull(person_property.date_to,now()))
      )
      order by periods.year,properties.lot_number,periods.month_id
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS paymentsview');
    }
}

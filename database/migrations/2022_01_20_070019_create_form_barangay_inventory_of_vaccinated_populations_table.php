<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormBarangayInventoryOfVaccinatedPopulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_barangay_inventory_of_vaccinated_populations', function (Blueprint $table) {
            $table->id();
            $table->integer('total_no_of_population');
            $table->integer('total_no_of_unvaccinated_individuals');
            $table->integer('percentage_of_unvaccinated_indivisuals');
            $table->integer('total_no_of_partially_vaccinated_individuals');
            $table->integer('percentage_of_partially_vaccinated_individuals');
            $table->integer('total_no_of_fully_vaccinated_individuals');
            $table->integer('percentage_of_fully_vaccinated_individuals');
            $table->integer('total_no_of_individuals_with_booster_shot');
            $table->integer('percentage_of_individuals_with_booster_shot');
            $table->string('month');
            $table->year('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_barangay_inventory_of_vaccinated_populations');
    }
}

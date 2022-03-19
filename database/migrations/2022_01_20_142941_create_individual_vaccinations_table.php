<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_vaccinations', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->integer('unvaccinated');
            $table->integer('partially_vaccinated');
            $table->integer('fully_vaccinated');
            $table->integer('with_bootster_shot');
            $table->integer('brand_primary_series')->nullable();
            $table->integer('brand_booster_shot')->nullable();
            $table->date('date_of_vaccination_1st_dose')->nullable();
            $table->date('date_of_vaccination_2nd_dose')->nullable();
            $table->date('date_of_vaccination_booster_shot')->nullable();
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
        Schema::dropIfExists('individual_vaccinations');
    }
}

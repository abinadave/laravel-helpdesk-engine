<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnBrgyEncoding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_barangay_inventory_of_vaccinated_populations', function (Blueprint $table) {
            $table->integer('percentage_of_unvaccinated_indivisuals')->nullable()->change();
            $table->integer('percentage_of_partially_vaccinated_individuals')->nullable()->change();
            $table->integer('percentage_of_fully_vaccinated_individuals')->nullable()->change();
            $table->integer('percentage_of_individuals_with_booster_shot')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

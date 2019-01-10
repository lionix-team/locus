<?php

use App\Models\FuelType;
use App\Models\Place;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceFuelTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_fuel_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_id');
            $table->index('place_id');
            $table->foreign('place_id')
                ->references('id')->on((new Place())->getTable())
                ->onDelete('cascade');
            $table->unsignedInteger('fuel_type_id');
            $table->index('fuel_type_id');
            $table->foreign('fuel_type_id')
                ->references('id')->on((new FuelType())->getTable())
                ->onDelete('cascade');
            $table->float('price');
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
        Schema::dropIfExists('place_fuel_type');
    }
}

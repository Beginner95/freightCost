<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteToWeightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_weight', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('price', 8, 2);
            $table->string('distance', 100)->nullable();
            $table->bigInteger('route_id')->unsigned();
            $table->bigInteger('weight_id')->unsigned();
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('weight_id')->references('id')->on('weights')->onDelete('cascade');
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
        Schema::dropIfExists('routes_weights');
    }
}

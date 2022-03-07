<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPointTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_point_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('event_team_id');
            $table->integer('match')->default(0);
            $table->integer('win')->default(0);
            $table->integer('lose')->default(0);
            $table->float('nrr')->default(0);
            $table->float('points')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_point_tables');
    }
}

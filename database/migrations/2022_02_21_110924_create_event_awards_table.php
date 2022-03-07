<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_awards', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            // $table->string('award_type')->comment('team,player')->default('player');
            $table->string('slug');
            $table->string('title');
            // $table->integer('event_awardable_id');
            // $table->string('event_awardable_type');
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
        Schema::dropIfExists('event_awards');
    }
}

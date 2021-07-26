<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugin_data', function (Blueprint $table) {
            $table->unsignedBigInteger('plugin_id');
            $table->foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
            $table->enum('type', ['config', 'string']);
            $table->string('name');
            $table->string('display_name')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->text('contents')->nullable();
            $table->primary(['plugin_id', 'name', 'type']);
        });

        Schema::create('game_plugin_data', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('plugin_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('plugin_id')->references('id')->on('plugins');
            $table->enum('type', ['config', 'string']);
            $table->string('name');
            $table->text('contents')->nullable();
            $table->primary(['game_id', 'plugin_id', 'name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugin_data');
        Schema::dropIfExists('game_plugin_data');
    }
}

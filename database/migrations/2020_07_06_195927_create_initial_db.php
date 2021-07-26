<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 32)->nullable()->unique()->index();
            $table->string('title', 30)->nullable()->index();
            $table->string('short_description', 70)->default(null)->nullable();
            $table->string('description', 1000)->default(null)->nullable();
            $table->smallInteger('status')->index()->default(0);

            // Belongs to user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // TODO: Enable plugin_releases instead of this
            $table->string('main', 128)
                ->nullable()->unique()->default(null);
            $table->string('version', 16)->default("0.0.0");
            $table->string('plugin_source')->unique()->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

//        Schema::create('plugin_releases', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->enum('type', ['dev', 'alpha', 'beta', 'release']);
//            $table->enum('status', ['waiting_for_approval', 'approved', 'rejected', 'rejected_buggy', 'rejected_virus']);
//            $table->integer('size');
//            $table->integer('installs');
//            $table->string('file')->unique();
//            $table->string('main', 128)->unique();
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->timestamps();
//            $table->softDeletes('deleted_at', 0);
//        });

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title', 170)->default('Untitled Game');
            $table->string('description')->default(null)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            // TODO: Enable game_releases instead of this
            $table->string('release_file')->unique()->nullable()->default(null);
            $table->enum('status', ['nothing', 'building', 'release', 'error'])->default('nothing');
            $table->string('version')->default('0.0.1');

            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });

//        Schema::create('game_releases', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->enum('type', ['release']);
//            $table->integer('size');
//            $table->string('file')->unique();
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->timestamps();
//            $table->softDeletes('deleted_at', 0);
//        });

        // Pivot table
        Schema::create('game_plugin', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('plugin_id');
            $table->boolean('enabled')->default(true);
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('plugin_id')->references('id')->on('plugins');
            $table->primary(['game_id', 'plugin_id']);
        });

        Schema::create('plugin_configurations', function (Blueprint $table) {
            $table->unsignedBigInteger('plugin_id');
            $table->foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
            $table->string('file_name', 259)->index();
            $table->json('contents');
            $table->primary(['plugin_id', 'file_name']);
        });

        // Pivot Table
        Schema::create('game_plugin_config', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('plugin_id');
            $table->string('file_name', 259);
            $table->json('contents');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('plugin_id')->references('id')->on('plugins');
            $table->primary(['game_id', 'plugin_id', 'file_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Model::unguard();
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('plugins');
        Schema::dropIfExists('plugin_releases');
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_releases');
        Schema::dropIfExists('game_plugin');
        Schema::dropIfExists('plugin_configurations');
        Schema::dropIfExists('game_plugin_config');
        Model::reguard();
        Schema::enableForeignKeyConstraints();
    }
}

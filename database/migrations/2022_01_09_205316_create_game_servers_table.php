<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_servers', function (Blueprint $table) {
            $table->id();
            $table->text('uuid');
            $table->text('access_key');
            $table->tinyText('access_key_index');
            $table->text('ip_address');
            $table->tinyText('ip_address_index');
            $table->bigInteger('port')->default(64989);
            $table->bigInteger('maximum_place_jobs');
            $table->bigInteger('maximum_thumbnail_jobs');
            $table->boolean('is_set_up')->default(false);
            $table->boolean('has_vnc')->default(true);
            $table->text('vnc_port')->nullable();
            $table->text('vnc_password')->nullable();
            $table->text('friendly_name')->nullable();
            $table->string('utc_offset')->nullable();
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
        Schema::dropIfExists('game_servers');
    }
};

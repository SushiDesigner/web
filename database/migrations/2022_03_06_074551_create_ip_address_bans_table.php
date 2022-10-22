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
        Schema::create('ip_address_bans', function (Blueprint $table) {
            $table->id();
            $table->text('ip_address');
            $table->tinyText('ip_address_index');
            $table->text('criterium');
            $table->bigInteger('moderator_id');
            $table->bigInteger('pardoner_id')->nullable();
            $table->string('internal_reason', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('has_been_pardoned')->default(false);
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
        Schema::dropIfExists('ip_address_bans');
    }
};

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
        Schema::create('bans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('moderator_id');
            $table->string('user_id');
            $table->string('internal_reason');
            $table->string('moderator_note');
            $table->text('offensive_item')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->boolean('is_appealable')->default(true);
            $table->boolean('is_poison_ban')->default(false);
            $table->string('patient_zero')->nullable();
            $table->boolean('is_warning')->default(false);
            $table->boolean('has_been_pardoned')->default(false);
            $table->string('pardon_internal_reason')->nullable();
            $table->string('pardoner_id')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bans');
    }
};

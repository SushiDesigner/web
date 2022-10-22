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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->unique();
            $table->packed('past_usernames')->nullable();
            $table->string('blurb', 1000)->default('');
            $table->text('email')->nullable();
            $table->tinyText('email_index')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('last_ip_address')->nullable();
            $table->tinyText('last_ip_address_index')->nullable();
            $table->text('register_ip_address')->nullable();
            $table->tinyText('register_ip_address_index')->nullable();
            $table->bigInteger('current_ban_id')->nullable();
            $table->packed('activity');
            $table->packed('permissions');
            $table->boolean('superadmin')->default(false);
            $table->text('discord_id')->nullable();
            $table->tinyText('discord_id_index')->nullable();
            $table->timestamp('discord_linked_at')->nullable();
            $table->boolean('two_factor_confirmed')->after('two_factor_recovery_codes')->default(false);
            $table->bigInteger('current_status_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

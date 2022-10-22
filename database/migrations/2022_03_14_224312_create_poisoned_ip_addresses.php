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
        Schema::create('poisoned_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->text('ip_address');
            $table->tinyText('ip_address_index');
            $table->bigInteger('tied_to');
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
        Schema::dropIfExists('poisoned_ip_addresses');
    }
};

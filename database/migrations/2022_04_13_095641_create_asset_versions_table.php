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
        Schema::create('asset_versions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id');
            $table->bigInteger('version');
            $table->string('cdn_thumbnail_icon_hash')->nullable();
            $table->string('cdn_thumbnail_widescreen_hash')->nullable();
            $table->string('cdn_file_hash');
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
        Schema::dropIfExists('asset_versions');
    }
};

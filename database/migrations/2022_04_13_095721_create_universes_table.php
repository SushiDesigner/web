<?php

use App\Enums\CreatorType;
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
        Schema::create('universes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('creator_id');
            $table->bigInteger('creator_type')->default(CreatorType::User->value);
            $table->bigInteger('start_place_id')->nullable();
            $table->string('name')->default('My Game');
            $table->bigInteger('version');

            $table->packed('privileges');
            /**
             * { "owner": user_id, "allowed_editors": [user_id1, user_id2, user_id3, group_id1] }
             * "owner" can transfer to anyone
             * "owner" has full privileges
             */

            $table->integer('privacy')->default(0); // 0: Public. 1: Private for owner only. 2: Private, but all friends of owner is allowed
            $table->boolean('unlisted')->default(false);
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
        Schema::dropIfExists('universes');
    }
};

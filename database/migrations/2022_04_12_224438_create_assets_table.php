<?php

use App\Enums\CreatorType;
use App\Enums\AssetModeration;
use App\Enums\AssetGenre;
use App\Enums\PlaceAccess;
use App\Enums\ChatStyle;
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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 1000);
            $table->bigInteger('type');
            $table->bigInteger('genre')->default(AssetGenre::All->value);
            $table->bigInteger('version_id')->default(1);
            $table->bigInteger('image_id')->nullable();
            $table->bigInteger('creator_id');
            $table->bigInteger('creator_type')->default(CreatorType::User->value);
            $table->bigInteger('moderation')->default(AssetModeration::Pending->value);
            $table->boolean('is_for_sale')->default(false);
            $table->boolean('is_public_domain')->default(true);
            $table->boolean('comments_enabled')->default(true);
            $table->bigInteger('price')->default(0);
            $table->bigInteger('gear_attributes')->default(0);
            $table->bigInteger('sales')->default(0);
            $table->bigInteger('favorites')->default(0);
            $table->bigInteger('upvotes')->default(0);
            $table->bigInteger('downvotes')->default(0);

            $table->bigInteger('universe_id')->nullable();
            $table->bigInteger('max_players')->default(16)->nullable();
            $table->bigInteger('client_version')->nullable();
            $table->bigInteger('access')->default(PlaceAccess::Everyone->value)->nullable();
            $table->bigInteger('chat_style')->default(ChatStyle::Classic->value)->nullable();
            $table->boolean('is_start_place')->default(false)->nullable();
            $table->boolean('is_boosters_club_only')->default(false)->nullable();
            $table->bigInteger('visits')->default(0)->nullable();
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
        Schema::dropIfExists('assets');
    }
};

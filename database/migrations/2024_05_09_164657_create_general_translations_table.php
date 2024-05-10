<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('general_id');
            $table->string('name', 50);
            $table->string('address', 50);
            $table->string('title',255)->nullable(true);
            $table->string('content', 255)->nullable(true);
            $table->string('meta_title', 255)->nullable(true);
            $table->string('meta_description', 255)->nullable(true);
            $table->string('meta_keyword', 255)->nullable(true);
            $table->string('locale', 10)->nullable(true);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_translations');
    }
}

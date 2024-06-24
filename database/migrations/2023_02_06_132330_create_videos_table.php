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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('category_id')->default(0);
            $table->string('image_cover', 40)->nullable();
            $table->string('thumb')->nullable();
            $table->string('file_name')->nullable();
            $table->string('track_id')->nullable();
            $table->string('title', 40)->nullable();
            $table->date('upload_date')->nullable();
            $table->string('resolution', 40)->nullable();
            $table->string('extensions')->default('[]');
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->decimal('price', 28, 8)->default(0);
            $table->integer('total_like')->unsigned()->default(0);
            $table->unsignedTinyInteger('is_free')->default(1);
            $table->unsignedTinyInteger('is_featured')->default(0);
            $table->unsignedTinyInteger('attribution')->default(0);

            $table->integer('total_view')->default(0);
            $table->integer('total_downloads')->unsigned()->default(0);
            $table->unsignedTinyInteger('is_active')->default('1');
            $table->unsignedTinyInteger('status')->default(0);
            $table->text('reason')->nullable();
            $table->integer('admin_id')->unsigned()->default(0);
            $table->integer('reviewer_id')->unsigned()->default(0);


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
        Schema::dropIfExists('videos');
    }
};

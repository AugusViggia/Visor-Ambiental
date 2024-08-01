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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->uuid('resource_id')->index();
            $table->string('title');
            $table->string('institution');
            $table->string('source');
            $table->string('url');
            $table->foreignId('geometry_id')
                ->constrained('geometries');
            $table->double('altitude')
                ->nullable();
            $table->foreignId('category_id')
                ->constrained('categories');
            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('subcategories');
            $table->foreignId('ecoregion_id')
                ->constrained('ecoregions');
            $table->point('location');
            $table->unsignedBigInteger('taxa')
                ->nullable();
            $table->date('date')
                ->nullable();
            $table->string('description')->nullable();
            $table->foreignId('user_id')
                ->constrained('users');
            $table->foreignId('approved_by')
                ->nullable()->constrained('users');
            $table->foreignId('rejected_by')
                ->nullable()->constrained('users');
            $table->foreignId('denounced_by')
                ->nullable()->constrained('users');
            $table->string('reason')
                ->nullable();
            $table->foreignId('status_id')
                ->constrained('status');
            $table->string('hash', 64)
                ->unique();
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
        Schema::dropIfExists('points');
    }
};

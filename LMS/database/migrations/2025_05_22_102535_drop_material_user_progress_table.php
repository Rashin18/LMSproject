<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class DropMaterialUserProgressTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('material_user_progress');
    }

    public function down()
    {
        // If rollback is needed
        Schema::create('material_user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->boolean('is_watched')->default(false);
            $table->unsignedInteger('progress')->default(0);
            $table->timestamps();
        });
    }
}

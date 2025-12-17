<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pvs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year');
            $table->string('level', 100);
            $table->string('department', 200);
            $table->string('group')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pvs');
    }
};

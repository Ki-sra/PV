<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('student_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pv_id')->constrained('pvs')->onDelete('cascade');
            $table->string('student_identifier');
            $table->string('file_path');
            $table->enum('copy_type', ['control','efm'])->default('control');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_copies');
    }
};

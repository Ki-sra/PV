<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pv_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pv_id')->constrained('pvs')->onDelete('cascade');
            $table->string('file_path');
            $table->string('name')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pv_documents');
    }
};

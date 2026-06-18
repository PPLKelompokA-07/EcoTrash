<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('database_files', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->unique();
            $table->string('mime_type');
            $table->timestamps();
        });
        
        // Add MEDIUMBLOB for 'data' column
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE database_files ADD data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('database_files');
    }
};

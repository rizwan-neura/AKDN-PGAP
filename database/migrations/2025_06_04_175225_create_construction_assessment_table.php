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
        Schema::create('construction_assessment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('indicator_id');
            $table->unsignedBigInteger('compliances_id');
            $table->decimal('score', 4, 2); 
            $table->string('file_name')->nullable();; 
            $table->string('file_path')->nullable();; 
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->index('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->index('indicator_id');
            $table->foreign('indicator_id')->references('id')->on('construction_indicators')->onDelete('cascade');
            $table->index('compliances_id');
            $table->foreign('compliances_id')->references('id')->on('construction_compliances_scores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_assessment');
    }
};

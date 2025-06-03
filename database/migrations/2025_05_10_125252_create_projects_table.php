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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->unsignedBigInteger('phase_id')->nullable();
            $table->string('assessment_req', 100)->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->date('date_gpa')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('country_code')->nullable();
            $table->unsignedBigInteger('region_code')->nullable();
            $table->string('location', 100)->nullable();
            $table->decimal('coordinates', 10, 6)->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('sub_type_id')->nullable();
            $table->decimal('construction_cost', 8, 2)->nullable();
            $table->string('requirements', 100)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->index('phase_id');
            $table->foreign('phase_id')->references('id')->on('project_phases')->onDelete('cascade');
            $table->index('organization_id');
            $table->foreign('organization_id')->references('id')->on('organization')->onDelete('cascade');
            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('building_types')->onDelete('cascade');
            $table->index('sub_type_id');
            $table->foreign('sub_type_id')->references('id')->on('building_sub_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

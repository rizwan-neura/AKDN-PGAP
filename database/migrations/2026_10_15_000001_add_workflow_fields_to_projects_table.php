<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            foreach (['planning', 'design', 'construction'] as $phase) {
                $table->string($phase . '_workflow_status', 40)->default('draft');
                $table->text($phase . '_workflow_comment')->nullable();
                $table->unsignedBigInteger($phase . '_workflow_updated_by')->nullable();
                $table->timestamp($phase . '_workflow_updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            foreach (['planning', 'design', 'construction'] as $phase) {
                $table->dropColumn([
                    $phase . '_workflow_status',
                    $phase . '_workflow_comment',
                    $phase . '_workflow_updated_by',
                    $phase . '_workflow_updated_at',
                ]);
            }
        });
    }
};

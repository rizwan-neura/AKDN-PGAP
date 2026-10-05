<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'organization_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('organization_id')
                    ->nullable()
                    ->after('email')
                    ->constrained('organizations')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status', 20)
                    ->default('Active')
                    ->after('organization_id');
            });
        }

        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('code', 50)->unique();
                $table->unsignedTinyInteger('workflow_level')->nullable()->index();
                $table->text('description')->nullable();
                $table->boolean('is_system')->default(false);
                $table->boolean('can_manage_users')->default(false);
                $table->boolean('can_assign_super_admin')->default(false);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            $now = now();

            DB::table('roles')->insert([
                [
                    'id' => 1,
                    'name' => 'Super Admin',
                    'code' => 'super_admin',
                    'workflow_level' => null,
                    'description' => 'System administration with full user-management access.',
                    'is_system' => true,
                    'can_manage_users' => true,
                    'can_assign_super_admin' => true,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 2,
                    'name' => 'Admin',
                    'code' => 'admin',
                    'workflow_level' => null,
                    'description' => 'System administration for normal accounts; cannot assign or manage Super Admin access.',
                    'is_system' => true,
                    'can_manage_users' => true,
                    'can_assign_super_admin' => false,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 3,
                    'name' => 'Agency Country Focal Point (ACFP)',
                    'code' => 'acfp',
                    'workflow_level' => 1,
                    'description' => 'Level-01 country/agency focal point responsible for first PGAP environmental self-assessment data entry.',
                    'is_system' => false,
                    'can_manage_users' => false,
                    'can_assign_super_admin' => false,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 4,
                    'name' => 'Agency Focal Point (Global)',
                    'code' => 'global_afp',
                    'workflow_level' => 2,
                    'description' => 'Level-02 global Agency Focal Point responsible for reviewing the ACFP environmental self-assessment.',
                    'is_system' => false,
                    'can_manage_users' => false,
                    'can_assign_super_admin' => false,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 5,
                    'name' => 'Construction Standards & Advisory Committee (CSA) - Level 03',
                    'code' => 'csa_level_03',
                    'workflow_level' => 3,
                    'description' => 'Level-03 CSA technical review by the designated review members.',
                    'is_system' => false,
                    'can_manage_users' => false,
                    'can_assign_super_admin' => false,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'id' => 6,
                    'name' => 'Construction Standards & Advisory Committee (CSA) - Level 04',
                    'code' => 'csa_level_04',
                    'workflow_level' => 4,
                    'description' => 'Level-04 CSA review/decision role for all authorized CSA members.',
                    'is_system' => false,
                    'can_manage_users' => false,
                    'can_assign_super_admin' => false,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        if (! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')
                    ->default(3)
                    ->after('organization_id')
                    ->constrained('roles')
                    ->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('role_id');
            });
        }

        Schema::dropIfExists('roles');

        if (Schema::hasColumn('users', 'organization_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('organization_id');
            });
        }

        if (Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};

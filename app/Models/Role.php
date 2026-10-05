<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const SUPER_ADMIN_ID = 1;
    public const ADMIN_ID = 2;
    public const ACFP_ID = 3;
    public const GLOBAL_AFP_ID = 4;
    public const CSA_LEVEL_03_ID = 5;
    public const CSA_LEVEL_04_ID = 6;

    public const CODE_SUPER_ADMIN = 'super_admin';
    public const CODE_ADMIN = 'admin';
    public const CODE_ACFP = 'acfp';
    public const CODE_GLOBAL_AFP = 'global_afp';
    public const CODE_CSA_LEVEL_03 = 'csa_level_03';
    public const CODE_CSA_LEVEL_04 = 'csa_level_04';

    protected $fillable = [
        'name',
        'code',
        'workflow_level',
        'description',
        'is_system',
        'can_manage_users',
        'can_assign_super_admin',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'workflow_level' => 'integer',
            'is_system' => 'boolean',
            'can_manage_users' => 'boolean',
            'can_assign_super_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->code === self::CODE_SUPER_ADMIN;
    }

    public function isAdminRole(): bool
    {
        return in_array($this->code, [
            self::CODE_SUPER_ADMIN,
            self::CODE_ADMIN,
        ], true);
    }

    public function isWorkflowRole(): bool
    {
        return $this->workflow_level !== null;
    }
}

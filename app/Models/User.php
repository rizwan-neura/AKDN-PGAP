<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const STATUSES = [
        'Active',
        'Inactive',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'organization_id',
        'role_id',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function getWorkflowLevelAttribute(): ?int
    {
        return $this->role?->workflow_level;
    }

    public function isActive(): bool
    {
        return strtolower(trim((string) $this->status)) === 'active';
    }

    public function isAdmin(): bool
    {
        return $this->role?->isAdminRole() ?? false;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->isSuperAdmin() ?? false;
    }

    public function isWorkflowRole(): bool
    {
        return $this->role?->isWorkflowRole() ?? false;
    }

    public function hasWorkflowLevel(int $level): bool
    {
        return $this->workflow_level === $level;
    }
}

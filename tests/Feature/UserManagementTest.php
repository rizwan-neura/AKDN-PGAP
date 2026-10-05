<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_table_contains_expected_pgAP_roles(): void
    {
        $this->assertDatabaseHas('roles', [
            'id' => Role::ACFP_ID,
            'code' => Role::CODE_ACFP,
            'workflow_level' => 1,
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => Role::GLOBAL_AFP_ID,
            'code' => Role::CODE_GLOBAL_AFP,
            'workflow_level' => 2,
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => Role::CSA_LEVEL_03_ID,
            'code' => Role::CODE_CSA_LEVEL_03,
            'workflow_level' => 3,
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => Role::CSA_LEVEL_04_ID,
            'code' => Role::CODE_CSA_LEVEL_04,
            'workflow_level' => 4,
        ]);
    }

    public function test_user_belongs_to_role_by_role_id(): void
    {
        $user = User::factory()->create([
            'role_id' => Role::GLOBAL_AFP_ID,
        ]);

        $this->assertSame(Role::GLOBAL_AFP_ID, $user->role_id);
        $this->assertSame(Role::CODE_GLOBAL_AFP, $user->role->code);
        $this->assertSame(2, $user->workflow_level);
    }

    public function test_regular_user_cannot_open_user_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_open_user_management(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertOk();
    }

    public function test_admin_can_create_a_standard_user(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $admin = User::factory()->admin()->create([
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($admin)
            ->post(route('users.store'), [
                'form_context' => 'add',
                'first_name' => 'Test',
                'last_name' => 'Focal Point',
                'username' => 'test.focal',
                'email' => 'focal@example.com',
                'organization_id' => $organization->id,
                'role_id' => Role::ACFP_ID,
                'status' => 'Active',
                'password' => 'password123',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'username' => 'test.focal',
            'email' => 'focal@example.com',
            'role_id' => Role::ACFP_ID,
            'status' => 'Active',
        ]);
    }

    public function test_admin_can_update_a_standard_user_without_resetting_password(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $admin = User::factory()->admin()->create([
            'organization_id' => $organization->id,
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id,
            'role_id' => Role::ACFP_ID,
        ]);

        $passwordHash = $user->password;

        $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'form_context' => 'edit',
                'editing_user_id' => $user->id,
                'first_name' => 'Updated',
                'last_name' => 'Person',
                'username' => $user->username,
                'email' => $user->email,
                'organization_id' => $organization->id,
                'role_id' => Role::GLOBAL_AFP_ID,
                'status' => 'Active',
                'password' => '',
            ])
            ->assertRedirect(route('users.index'));

        $user->refresh();

        $this->assertSame('Updated', $user->first_name);
        $this->assertSame('Person', $user->last_name);
        $this->assertSame(Role::GLOBAL_AFP_ID, $user->role_id);
        $this->assertSame($passwordHash, $user->password);
    }

    public function test_admin_can_delete_a_standard_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_cannot_assign_super_admin_role(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $admin = User::factory()->admin()->create([
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($admin)
            ->from(route('users.index'))
            ->post(route('users.store'), [
                'form_context' => 'add',
                'first_name' => 'Second',
                'last_name' => 'Admin',
                'username' => 'second.admin',
                'email' => 'second.admin@example.com',
                'organization_id' => $organization->id,
                'role_id' => Role::SUPER_ADMIN_ID,
                'status' => 'Active',
                'password' => 'password123',
            ])
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('users', [
            'email' => 'second.admin@example.com',
        ]);
    }

    public function test_admin_cannot_modify_a_super_admin(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $admin = User::factory()->admin()->create([
            'organization_id' => $organization->id,
        ]);

        $superAdmin = User::factory()->superAdmin()->create([
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($admin)
            ->from(route('users.index'))
            ->put(route('users.update', $superAdmin), [
                'form_context' => 'edit',
                'editing_user_id' => $superAdmin->id,
                'first_name' => $superAdmin->first_name,
                'last_name' => $superAdmin->last_name,
                'username' => $superAdmin->username,
                'email' => $superAdmin->email,
                'organization_id' => $organization->id,
                'role_id' => Role::ADMIN_ID,
                'status' => 'Active',
                'password' => '',
            ])
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertSame(Role::SUPER_ADMIN_ID, $superAdmin->fresh()->role_id);
    }

    public function test_super_admin_can_assign_super_admin_role(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $superAdmin = User::factory()->superAdmin()->create([
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($superAdmin)
            ->post(route('users.store'), [
                'form_context' => 'add',
                'first_name' => 'Second',
                'last_name' => 'Super',
                'username' => 'second.super',
                'email' => 'second.super@example.com',
                'organization_id' => $organization->id,
                'role_id' => Role::SUPER_ADMIN_ID,
                'status' => 'Active',
                'password' => 'password123',
            ])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'second.super@example.com',
            'role_id' => Role::SUPER_ADMIN_ID,
        ]);
    }

    public function test_user_cannot_delete_own_account_from_user_management(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete(route('users.destroy', $admin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    public function test_last_active_super_admin_cannot_demote_themselves(): void
    {
        $organization = Organization::create([
            'organization_name' => 'AKDN',
        ]);

        $superAdmin = User::factory()->superAdmin()->create([
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($superAdmin)
            ->from(route('users.index'))
            ->put(route('users.update', $superAdmin), [
                'form_context' => 'edit',
                'editing_user_id' => $superAdmin->id,
                'first_name' => $superAdmin->first_name,
                'last_name' => $superAdmin->last_name,
                'username' => $superAdmin->username,
                'email' => $superAdmin->email,
                'organization_id' => $organization->id,
                'role_id' => Role::ADMIN_ID,
                'status' => 'Active',
                'password' => '',
            ])
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertSame(Role::SUPER_ADMIN_ID, $superAdmin->fresh()->role_id);
    }

    public function test_last_active_super_admin_cannot_be_deleted(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        User::factory()->admin()->create();

        $this->actingAs($superAdmin)
            ->delete(route('users.destroy', $superAdmin))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $superAdmin->id,
        ]);
    }
}

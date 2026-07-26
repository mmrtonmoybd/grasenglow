<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

it('redirects guests away from Filament', function () {
    $this->get('/admin')->assertRedirect();
});

it('prevents users without an admin role from accessing Filament', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

it('allows an authorized administrator to access the panel', function () {
    $user = User::factory()->create();
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $user->assignRole($role);

    $this->actingAs($user)->get('/admin')->assertSuccessful();
});

it('enforces resource permissions for restricted administrators', function () {
    $user = User::factory()->create();
    $role = Role::query()->create(['name' => 'panel_user', 'guard_name' => 'web']);
    $viewAny = Permission::query()->create(['name' => 'ViewAny:Product', 'guard_name' => 'web']);
    $view = Permission::query()->create(['name' => 'View:Product', 'guard_name' => 'web']);
    $role->givePermissionTo([$viewAny, $view]);
    $user->assignRole($role);
    $product = Product::factory()->create();

    $this->actingAs($user)->get(ProductResource::getUrl('index'))->assertSuccessful();
    $this->actingAs($user)->get(ProductResource::getUrl('edit', ['record' => $product]))->assertForbidden();
});

it('enforces settings page permissions', function () {
    $user = User::factory()->create();
    $role = Role::query()->create(['name' => 'panel_user', 'guard_name' => 'web']);
    $user->assignRole($role);

    $this->actingAs($user)->get('/admin/site-settings')->assertForbidden();

    $permission = Permission::query()->create(['name' => 'View:SiteSettings', 'guard_name' => 'web']);
    $role->givePermissionTo($permission);

    $this->actingAs($user)->get('/admin/site-settings')->assertSuccessful();
});

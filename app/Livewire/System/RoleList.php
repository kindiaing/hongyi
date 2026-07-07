<?php

namespace App\Livewire\System;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class RoleList extends Component
{
    use WithPagination;

    public ?int $editingRoleId = null;
    public array $selectedPermissions = [];
    public array $rolePermissions = [];

    public function mount(): void
    {
        $this->loadRolePermissions();
    }

    public function loadRolePermissions(): void
    {
        $this->rolePermissions = [];
        foreach (Role::all() as $role) {
            $this->rolePermissions[$role->id] = $role->permissions->pluck('name')->toArray();
        }
    }

    public function startEdit(int $roleId): void
    {
        $this->editingRoleId = $roleId;
        $role = Role::find($roleId);
        $this->selectedPermissions = $role ? $role->permissions->pluck('name')->toArray() : [];
    }

    public function cancelEdit(): void
    {
        $this->editingRoleId = null;
        $this->selectedPermissions = [];
    }

    public function savePermissions(): void
    {
        $role = Role::find($this->editingRoleId);
        if (!$role) {
            $this->dispatch('notify', type: 'error', message: '角色不存在');
            return;
        }

        if ($role->name === 'super_admin') {
            $this->dispatch('notify', type: 'error', message: '超级管理员权限不可修改');
            $this->cancelEdit();
            return;
        }

        $oldData = ['role_name' => $role->display_name, 'permissions' => $role->permissions->pluck('name')->toArray()];
        $role->syncPermissions($this->selectedPermissions);
        $role->load('permissions');
        $newData = ['role_name' => $role->display_name, 'permissions' => $role->permissions->pluck('name')->toArray()];
        $this->loadRolePermissions();
        $this->cancelEdit();
        $this->dispatch('notify', type: 'success', message: "角色「{$role->display_name}」权限已更新");
        AuditLogService::update('system_role', '配置角色权限', "配置角色权限：{$role->display_name}", $oldData, $newData);
    }

    public function render()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::orderBy('group')->orderBy('id')->get()->groupBy('group');

        return view('livewire.system.role-list', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}

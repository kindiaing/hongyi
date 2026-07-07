<?php

namespace App\Livewire\System;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class UserList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $role = '';
    #[Url] public string $type = ''; // system / address
    #[Url] public string $status = '';

    public function resetFilters(): void
    {
        $this->search = '';
        $this->role = '';
        $this->type = '';
        $this->status = '';
        $this->resetPage();
    }

    public function deleteUser(int $id): void
    {
        $user = User::find($id);
        if ($user && $user->id !== auth()->id()) {
            $data = $user->toArray();
            $user->delete();
            $this->dispatch('notify', type: 'success', message: '用户已删除');
            AuditLogService::delete('system_user', '删除用户', "删除用户：{$data['name']}", $data);
        } elseif ($user?->id === auth()->id()) {
            $this->dispatch('notify', type: 'error', message: '不能删除当前登录用户');
        }
    }

    public function toggleStatus(int $id): void
    {
        $user = User::find($id);
        if (!$user) {
            $this->dispatch('notify', type: 'error', message: '用户不存在');
            return;
        }
        // Only super_admin can toggle status
        if (!auth()->user()->hasRole('super_admin')) {
            $this->dispatch('notify', type: 'error', message: '无权操作');
            return;
        }
        $oldData = $user->toArray();
        $user->status = $user->status === 1 ? 0 : 1;
        $user->save();
        $this->dispatch('notify', type: 'success', message: '状态已更新');
        AuditLogService::update('system_user', '切换用户状态', "切换用户状态：{$user->name}", $oldData, $user->toArray());
    }

    public function render()
    {
        $q = User::query()->with('roles', 'vendor', 'serviceUnit');
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('department', 'like', "%{$this->search}%");
            });
        }
        if ($this->role) {
            $q->whereHas('roles', fn($qq) => $qq->where('name', $this->role));
        }
        if ($this->type === 'system') {
            $q->where('is_system_user', true);
        } elseif ($this->type === 'address') {
            $q->where('is_system_user', false);
        }
        if ($this->status !== '') {
            $q->where('status', (int) $this->status);
        }

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('viewer')) {
                // viewer can only see active system users
                $q->where('is_system_user', true)->where('status', 1);
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                // vendor users can see users in same vendor
                $q->where('vendor_id', $user->vendor_id);
            } elseif ($user->hasRole('service_unit')) {
                $q->where('service_unit_id', $user->service_unit_id);
            } elseif ($user->hasRole('project_manager')) {
                // project manager can only see themselves and their vendor users
                $q->where(function ($qq) use ($user) {
                    $qq->where('id', $user->id)
                       ->orWhere('vendor_id', $user->vendor_id);
                });
            }
        }

        return view('livewire.system.user-list', [
            'users' => $q->latest()->paginate(15),
            'roles' => Role::pluck('name'),
        ]);
    }
}

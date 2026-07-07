<?php

namespace App\Livewire\System;

use App\Models\User;
use App\Models\Vendor;
use App\Models\ServiceUnit;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class UserForm extends Component
{
    public ?int $userId = null;
    public array $form = [];
    public array $selectedRoles = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        $rules = [
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'form.phone' => 'nullable|string|max:20',
            'form.vendor_id' => 'nullable|integer|exists:vendors,id',
            'form.service_unit_id' => 'nullable|integer|exists:service_units,id',
            'form.department' => 'nullable|string|max:255',
            'form.is_system_user' => 'nullable|boolean',
            'form.can_view_word' => 'nullable|boolean',
            'form.can_view_pdf' => 'nullable|boolean',
            'selectedRoles' => 'nullable|array',
        ];
        if (!$this->isEditing) {
            $rules['form.password'] = ['required', Password::defaults()];
        } else {
            $rules['form.password'] = ['nullable', Password::defaults()];
        }
        return $rules;
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->userId = $id;
            $this->isEditing = true;
            $user = User::findOrFail($id);
            $this->form = [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'vendor_id' => $user->vendor_id,
                'service_unit_id' => $user->service_unit_id,
                'department' => $user->department,
                'is_system_user' => $user->is_system_user,
                'can_view_word' => $user->can_view_word,
                'can_view_pdf' => $user->can_view_pdf,
            ];
            $this->selectedRoles = $user->roles->pluck('name')->toArray();
        } else {
            $this->form = ['is_system_user' => true, 'can_view_word' => false, 'can_view_pdf' => false];
            $this->selectedRoles = [];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = [
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'phone' => $this->form['phone'] ?? null,
            'vendor_id' => $this->form['vendor_id'] ?? null,
            'service_unit_id' => $this->form['service_unit_id'] ?? null,
            'department' => $this->form['department'] ?? null,
            'is_system_user' => $this->form['is_system_user'] ?? true,
            'can_view_word' => $this->form['can_view_word'] ?? false,
            'can_view_pdf' => $this->form['can_view_pdf'] ?? false,
        ];
        if (!empty($this->form['password'])) {
            $data['password'] = Hash::make($this->form['password']);
        }
        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $oldData = $user->toArray();
            $user->update($data);
            $user->syncRoles($this->selectedRoles);
            $this->dispatch('notify', type: 'success', message: '用户已更新');
            AuditLogService::update('system_user', '编辑用户', "编辑用户：{$user->name}", $oldData, $user->toArray());
        } else {
            $data['password'] = Hash::make($this->form['password']);
            $user = User::create($data);
            $user->syncRoles($this->selectedRoles);
            $this->dispatch('notify', type: 'success', message: '用户已创建');
            AuditLogService::create('system_user', '创建用户', "创建用户：{$user->name}", $user->toArray());
        }
        $this->redirect(route('system.users.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.system.user-form', [
            'roles' => Role::all(),
            'vendors' => Vendor::orderBy('name')->get(),
            'serviceUnits' => ServiceUnit::orderBy('name')->get(),
        ]);
    }
}

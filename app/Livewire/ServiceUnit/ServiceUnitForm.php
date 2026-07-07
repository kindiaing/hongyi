<?php

namespace App\Livewire\ServiceUnit;

use App\Models\ServiceUnit;
use App\Models\ServiceUnitContact;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class ServiceUnitForm extends Component
{
    public ?int $serviceUnitId = null;
    public array $form = [];
    public array $contacts = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|max:255',
            'form.short_name' => 'nullable|string|max:100',
            'form.address' => 'nullable|string|max:500',
            'form.status' => 'required|integer|in:0,1',
            'form.remark' => 'nullable|string',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'required_with:contacts.*.phone|string|max:100',
            'contacts.*.phone' => 'nullable|string|max:20',
            'contacts.*.position' => 'nullable|string|max:100',
            'contacts.*.email' => 'nullable|email|max:255',
            'contacts.*.address' => 'nullable|string|max:500',
            'contacts.*.user_id' => 'nullable|integer|exists:users,id',
            'contacts.*.is_primary' => 'nullable|boolean',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->serviceUnitId = $id;
            $this->isEditing = true;
            $unit = ServiceUnit::findOrFail($id);
            $this->form = [
                'name' => $unit->name,
                'short_name' => $unit->short_name,
                'address' => $unit->address,
                'status' => $unit->status,
                'remark' => $unit->remark,
            ];
            $this->contacts = $unit->contacts->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone,
                'position' => $c->position,
                'email' => $c->email,
                'address' => $c->address,
                'user_id' => $c->user_id,
                'is_primary' => $c->is_primary,
            ])->toArray();
            if (empty($this->contacts)) {
                // Migrate old single contact if exists
                if ($unit->contact_name) {
                    $this->contacts[] = [
                        'name' => $unit->contact_name,
                        'phone' => $unit->contact_phone,
                        'email' => $unit->contact_email,
                        'position' => '',
                        'address' => '',
                        'user_id' => null,
                        'is_primary' => true,
                    ];
                }
            }
        } else {
            $this->form = ['status' => 1];
            $this->contacts = [];
        }
    }

    public function addContact(): void
    {
        $this->contacts[] = [
            'name' => '',
            'phone' => '',
            'position' => '',
            'email' => '',
            'address' => '',
            'user_id' => null,
            'is_primary' => false,
        ];
    }

    public function removeContact(int $index): void
    {
        if (isset($this->contacts[$index])) {
            // If has id, mark for deletion later (or delete now if editing)
            if ($this->isEditing && !empty($this->contacts[$index]['id'])) {
                ServiceUnitContact::find($this->contacts[$index]['id'])?->delete();
            }
            unset($this->contacts[$index]);
            $this->contacts = array_values($this->contacts);
        }
    }

    public function setPrimary(int $index): void
    {
        foreach ($this->contacts as $i => $contact) {
            $this->contacts[$i]['is_primary'] = ($i === $index);
        }
    }

    public function save(): void
    {
        $this->validate();
        if ($this->isEditing) {
            $unit = ServiceUnit::findOrFail($this->serviceUnitId);
            $oldData = $unit->toArray();
            $unit->update($this->form);
            $this->saveContacts($unit);
            $this->dispatch('notify', type: 'success', message: '服务单位已更新');
            AuditLogService::update('service_unit', '编辑服务单位', "编辑服务单位：{$unit->name}", $oldData, $unit->toArray());
        } else {
            $unit = ServiceUnit::create($this->form);
            $this->saveContacts($unit);
            $this->dispatch('notify', type: 'success', message: '服务单位已创建');
            AuditLogService::create('service_unit', '创建服务单位', "创建服务单位：{$unit->name}", $unit->toArray());
        }
        $this->redirect(route('service-units.index'), navigate: true);
    }

    protected function saveContacts(ServiceUnit $unit): void
    {
        // Get existing contact IDs
        $existingIds = $unit->contacts->pluck('id')->toArray();
        $updatedIds = [];

        foreach ($this->contacts as $contact) {
            if (empty($contact['name'])) continue;
            $data = [
                'service_unit_id' => $unit->id,
                'name' => $contact['name'],
                'phone' => $contact['phone'] ?? null,
                'position' => $contact['position'] ?? null,
                'email' => $contact['email'] ?? null,
                'address' => $contact['address'] ?? null,
                'user_id' => $contact['user_id'] ?? null,
                'is_primary' => $contact['is_primary'] ?? false,
            ];
            if (!empty($contact['id'])) {
                $c = ServiceUnitContact::find($contact['id']);
                if ($c) {
                    $c->update($data);
                    $updatedIds[] = $c->id;
                }
            } else {
                $c = ServiceUnitContact::create($data);
                $updatedIds[] = $c->id;
            }
        }

        // Remove contacts not in updated list
        $toDelete = array_diff($existingIds, $updatedIds);
        if (!empty($toDelete)) {
            ServiceUnitContact::whereIn('id', $toDelete)->delete();
        }
    }

    public function render()
    {
        return view('livewire.service-unit.service-unit-form', [
            'users' => User::where('is_system_user', false)->orWhereNull('is_system_user')->orderBy('name')->get(),
        ]);
    }
}

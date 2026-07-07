<?php

namespace App\Livewire\VendorPersonnel;

use App\Models\Personnel;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class PersonnelForm extends Component
{
    public ?int $personnelId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.vendor_id' => 'required|exists:vendors,id',
            'form.name' => 'required|string|max:100',
            'form.id_card' => 'nullable|string|max:18',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email|max:255',
            'form.gender' => 'nullable|integer|in:0,1',
            'form.birth_date' => 'nullable|date',
            'form.position' => 'nullable|string|max:100',
            'form.job_title' => 'nullable|string|max:100',
            'form.entry_date' => 'nullable|date',
            'form.status' => 'required|integer|in:0,1,2',
            'form.is_resident' => 'integer|in:0,1',
            'form.resident_location' => 'nullable|string|max:255',
            'form.work_start_time' => 'nullable',
            'form.work_end_time' => 'nullable',
            'form.emergency_contact' => 'nullable|string|max:100',
            'form.emergency_phone' => 'nullable|string|max:20',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->personnelId = $id;
            $this->isEditing = true;
            $this->form = Personnel::findOrFail($id)->toArray();
        } else {
            $this->form = ['status' => 1, 'is_resident' => 0, 'gender' => 1];
        }
    }

    public function save(): void
    {
        $this->validate();
        if ($this->isEditing) {
            $personnel = Personnel::findOrFail($this->personnelId);
            $oldData = $personnel->toArray();
            $personnel->update($this->form);
            $this->dispatch('notify', type: 'success', message: '人员已更新');
            AuditLogService::update('personnel', '编辑运维人员', "编辑运维人员：{$personnel->name}", $oldData, $personnel->toArray());
        } else {
            $personnel = Personnel::create($this->form);
            $this->dispatch('notify', type: 'success', message: '人员已创建');
            AuditLogService::create('personnel', '创建运维人员', "创建运维人员：{$personnel->name}", $personnel->toArray());
        }
        $this->redirect(route('personnel.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.vendor-personnel.personnel-form', [
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
        ]);
    }
}

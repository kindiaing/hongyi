<?php

namespace App\Livewire\VendorPersonnel;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class VendorForm extends Component
{
    public ?int $vendorId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|max:255',
            'form.short_name' => 'nullable|string|max:100',
            'form.unified_code' => 'nullable|string|max:50',
            'form.type' => 'required|string|max:50',
            'form.qualification_level' => 'nullable|string|max:50',
            'form.legal_person' => 'nullable|string|max:100',
            'form.contact_name' => 'nullable|string|max:100',
            'form.contact_phone' => 'nullable|string|max:20',
            'form.contact_email' => 'nullable|email|max:255',
            'form.address' => 'nullable|string|max:500',
            'form.bank_name' => 'nullable|string|max:255',
            'form.bank_account' => 'nullable|string|max:100',
            'form.cooperation_status' => 'required|integer|in:0,1,2',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->vendorId = $id;
            $this->isEditing = true;
            $this->form = Vendor::findOrFail($id)->toArray();
        } else {
            $this->form = ['cooperation_status' => 1, 'type' => 'software'];
        }
    }

    public function save(): void
    {
        $this->validate();
        if ($this->isEditing) {
            $vendor = Vendor::findOrFail($this->vendorId);
            $oldData = $vendor->toArray();
            $vendor->update($this->form);
            $this->dispatch('notify', type: 'success', message: '单位已更新');
            AuditLogService::update('vendor', '编辑运维单位', "编辑运维单位：{$vendor->name}", $oldData, $vendor->toArray());
        } else {
            $vendor = Vendor::create($this->form);
            $this->dispatch('notify', type: 'success', message: '单位已创建');
            AuditLogService::create('vendor', '创建运维单位', "创建运维单位：{$vendor->name}", $vendor->toArray());
        }
        $this->redirect(route('vendors.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.vendor-personnel.vendor-form');
    }
}

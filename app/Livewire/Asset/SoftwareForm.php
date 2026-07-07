<?php

namespace App\Livewire\Asset;

use App\Models\Software;
use App\Models\Vendor;
use App\Models\SubContract;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class SoftwareForm extends Component
{
    public ?int $softwareId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.software_no' => 'required|string|max:100|unique:software,software_no,' . $this->softwareId,
            'form.software_name' => 'required|string|max:255',
            'form.version' => 'nullable|string|max:50',
            'form.deploy_environment' => 'nullable|string|max:100',
            'form.deploy_server' => 'nullable|string|max:255',
            'form.license_info' => 'nullable|string|max:500',
            'form.sub_contract_id' => 'nullable|exists:sub_contracts,id',
            'form.vendor_id' => 'nullable|exists:vendors,id',
            'form.maintenance_start_date' => 'nullable|date',
            'form.maintenance_end_date' => 'nullable|date',
            'form.maintenance_cycle' => 'nullable|string|max:50',
            'form.sla_level' => 'nullable|string|max:50',
            'form.is_resident_required' => 'boolean',
            'form.resident_location' => 'nullable|string|max:255',
            'form.resident_cycle' => 'nullable|string|max:50',
            'form.work_start_time' => 'nullable',
            'form.work_end_time' => 'nullable',
            'form.emergency_response_time' => 'nullable|integer|min:0',
            'form.status' => 'required|integer|in:0,1,2',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->softwareId = $id;
            $this->isEditing = true;
            $this->form = Software::findOrFail($id)->toArray();
        } else {
            $this->form = [
                'software_no' => 'SW-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6)),
                'status' => 1,
                'is_resident_required' => 0,
            ];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->form;
        $data['created_by'] = Auth::id();
        if ($this->isEditing) {
            $software = Software::findOrFail($this->softwareId);
            $oldData = $software->toArray();
            $software->update($data);
            $this->dispatch('notify', type: 'success', message: '软件已更新');
            AuditLogService::update('software', '编辑软件系统', "编辑软件系统：{$software->software_name}", $oldData, $software->toArray());
        } else {
            $software = Software::create($data);
            $this->dispatch('notify', type: 'success', message: '软件已创建');
            AuditLogService::create('software', '创建软件系统', "创建软件系统：{$software->software_name}", $software->toArray());
        }
        $this->redirect(route('assets.software.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.asset.software-form', [
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
            'subContracts' => SubContract::select('id', 'contract_name')->get(),
        ]);
    }
}

<?php

namespace App\Livewire\Asset;

use App\Models\HardwareDevice;
use App\Models\DataDictionary;
use App\Models\Vendor;
use App\Models\SubContract;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class HardwareDeviceForm extends Component
{
    public ?int $deviceId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.device_no' => 'required|string|max:100|unique:hardware_devices,device_no,' . $this->deviceId,
            'form.device_name' => 'required|string|max:255',
            'form.device_type' => 'required|string|max:50',
            'form.brand' => 'nullable|string|max:100',
            'form.model' => 'nullable|string|max:100',
            'form.serial_no' => 'nullable|string|max:100',
            'form.specification' => 'nullable|string',
            'form.location' => 'nullable|string|max:255',
            'form.sub_contract_id' => 'nullable|exists:sub_contracts,id',
            'form.vendor_id' => 'nullable|exists:vendors,id',
            'form.purchase_date' => 'nullable|date',
            'form.supplier' => 'nullable|string|max:255',
            'form.purchase_amount' => 'nullable|numeric|min:0',
            'form.warranty_period' => 'nullable|integer|min:0',
            'form.start_date' => 'nullable|date',
            'form.expiry_date' => 'nullable|date',
            'form.maintenance_cycle' => 'nullable|string|max:50',
            'form.next_maintenance_date' => 'nullable|date',
            'form.status' => 'required|integer|in:0,1,2,3',
            'form.remark' => 'nullable|string',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->deviceId = $id;
            $this->isEditing = true;
            $this->form = HardwareDevice::findOrFail($id)->toArray();
        } else {
            $this->form = [
                'device_no' => 'DEV-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6)),
                'status' => 1,
            ];
        }
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->form;
        $data['created_by'] = Auth::id();
        if ($this->isEditing) {
            $device = HardwareDevice::findOrFail($this->deviceId);
            $oldData = $device->toArray();
            $device->update($data);
            $this->dispatch('notify', type: 'success', message: '设备已更新');
            AuditLogService::update('device', '编辑硬件设备', "编辑硬件设备：{$device->device_name}", $oldData, $device->toArray());
        } else {
            $device = HardwareDevice::create($data);
            $this->dispatch('notify', type: 'success', message: '设备已创建');
            AuditLogService::create('device', '创建硬件设备', "创建硬件设备：{$device->device_name}", $device->toArray());
        }
        $this->redirect(route('assets.hardware.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.asset.hardware-device-form', [
            'deviceTypes' => DataDictionary::where('category', 'device_type')->pluck('name', 'code'),
            'vendors' => Vendor::select('id', 'name')->where('cooperation_status', 1)->get(),
            'subContracts' => SubContract::select('id', 'contract_name')->get(),
        ]);
    }
}

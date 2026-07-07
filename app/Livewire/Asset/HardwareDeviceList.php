<?php

namespace App\Livewire\Asset;

use App\Models\HardwareDevice;
use App\Models\DataDictionary;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class HardwareDeviceList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $deviceType = '';

    #[Url]
    public string $status = '';

    #[Url]
    public ?int $vendorId = null;

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'device_no' => ['label' => '设备编号', 'default' => true],
            'device_name' => ['label' => '设备名称', 'default' => true],
            'device_type' => ['label' => '设备类型', 'default' => true],
            'brand' => ['label' => '品牌', 'default' => true],
            'model' => ['label' => '型号', 'default' => true],
            'serial_no' => ['label' => '序列号', 'default' => false],
            'location' => ['label' => '所属位置', 'default' => true],
            'vendor' => ['label' => '运维单位', 'default' => true],
            'purchase_date' => ['label' => '采购日期', 'default' => false],
            'purchase_amount' => ['label' => '采购金额', 'default' => true],
            'warranty_period' => ['label' => '质保期(月)', 'default' => false],
            'start_date' => ['label' => '启用日期', 'default' => true],
            'expiry_date' => ['label' => '预计到期', 'default' => true],
            'next_maintenance_date' => ['label' => '下次维保', 'default' => true],
            'status' => ['label' => '状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];

        $saved = session('hw_device_visible_columns');
        if ($saved) {
            $this->visibleColumns = $saved;
        } else {
            $this->visibleColumns = collect($this->availableColumns)
                ->filter(fn($col) => $col['default'])
                ->keys()
                ->toArray();
        }
    }

    public function updatedVisibleColumns(): void
    {
        session(['hw_device_visible_columns' => $this->visibleColumns]);
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->deviceType = '';
        $this->status = '';
        $this->vendorId = null;
        $this->resetPage();
    }

    public function deleteDevice(int $id): void
    {
        $device = HardwareDevice::find($id);
        if ($device) {
            $data = $device->toArray();
            $device->delete();
            $this->dispatch('notify', type: 'success', message: '设备已删除');
            AuditLogService::delete('device', '删除硬件设备', "删除硬件设备：{$data['device_name']}", $data);
        }
    }

    public function render()
    {
        $query = HardwareDevice::query()->with(['vendor', 'subContract']);

        // Data scope filtering
        $user = auth()->user();
        if (!$user->hasAnyRole(['super_admin', 'admin'])) {
            if ($user->hasRole('project_manager')) {
                $query->whereHas('subContract', function ($q) use ($user) {
                    $q->whereHas('managers', fn($q2) => $q2->where('user_id', $user->id))
                      ->orWhereHas('mainContract.managers', fn($q2) => $q2->where('user_id', $user->id));
                });
            } elseif ($user->hasAnyRole(['vendor_admin', 'vendor_staff'])) {
                $query->whereHas('subContract', fn($q) => $q->where('vendor_id', $user->vendor_id));
            } elseif ($user->hasRole('service_unit')) {
                $query->whereRaw('1=0');
            } elseif ($user->hasRole('viewer')) {
                // viewer sees all, no filter needed
            }
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('device_no', 'like', "%{$this->search}%")
                  ->orWhere('device_name', 'like', "%{$this->search}%")
                  ->orWhere('brand', 'like', "%{$this->search}%")
                  ->orWhere('model', 'like', "%{$this->search}%");
            });
        }

        if ($this->deviceType) {
            $query->where('device_type', $this->deviceType);
        }

        if ($this->status !== '') {
            $query->where('status', (int) $this->status);
        }

        if ($this->vendorId) {
            $query->where('vendor_id', $this->vendorId);
        }

        $devices = $query->latest()->paginate(15);
        $deviceTypes = DataDictionary::where('category', 'device_type')->pluck('name', 'code');
        $vendors = Vendor::select('id', 'name')->where('cooperation_status', 1)->get();

        return view('livewire.asset.hardware-device-list', [
            'devices' => $devices,
            'deviceTypes' => $deviceTypes,
            'vendors' => $vendors,
        ]);
    }
}

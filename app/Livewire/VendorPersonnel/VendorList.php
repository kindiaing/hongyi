<?php

namespace App\Livewire\VendorPersonnel;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class VendorList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $type = '';
    #[Url] public string $cooperationStatus = '';

    public array $availableColumns = [];
    public array $visibleColumns = [];
    public bool $showColumnPicker = false;

    public function mount(): void
    {
        $this->availableColumns = [
            'name' => ['label' => '单位名称', 'default' => true],
            'short_name' => ['label' => '简称', 'default' => true],
            'unified_code' => ['label' => '统一社会信用代码', 'default' => false],
            'type' => ['label' => '单位类型', 'default' => true],
            'qualification_level' => ['label' => '资质等级', 'default' => false],
            'legal_person' => ['label' => '法人', 'default' => false],
            'contact_name' => ['label' => '联系人', 'default' => true],
            'contact_phone' => ['label' => '联系电话', 'default' => true],
            'contact_email' => ['label' => '联系邮箱', 'default' => false],
            'address' => ['label' => '地址', 'default' => false],
            'cooperation_status' => ['label' => '合作状态', 'default' => true],
            'created_at' => ['label' => '创建时间', 'default' => false],
        ];
        $saved = session('vendor_visible_columns');
        $this->visibleColumns = $saved ?: collect($this->availableColumns)->filter(fn($c) => $c['default'])->keys()->toArray();
    }

    public function updatedVisibleColumns(): void { session(['vendor_visible_columns' => $this->visibleColumns]); }

    public function resetFilters(): void
    {
        $this->search = ''; $this->type = ''; $this->cooperationStatus = ''; $this->resetPage();
    }

    public function deleteVendor(int $id): void
    {
        $v = Vendor::find($id);
        if ($v) {
            $data = $v->toArray();
            $v->delete();
            $this->dispatch('notify', type: 'success', message: '运维单位已删除');
            AuditLogService::delete('vendor', '删除运维单位', "删除运维单位：{$data['name']}", $data);
        }
    }

    public function render()
    {
        $q = Vendor::query();
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->search}%")
                  ->orWhere('short_name', 'like', "%{$this->search}%")
                  ->orWhere('contact_name', 'like', "%{$this->search}%");
            });
        }
        if ($this->type) $q->where('type', $this->type);
        if ($this->cooperationStatus !== '') $q->where('cooperation_status', (int)$this->cooperationStatus);

        return view('livewire.vendor-personnel.vendor-list', [
            'vendors' => $q->latest()->paginate(15),
        ]);
    }
}

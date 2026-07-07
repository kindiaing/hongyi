<?php

namespace App\Livewire\System;

use App\Models\DataDictionary;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class DataDictionaryList extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public string $category = '';
    #[Url] public string $isEnabled = '';

    public function resetFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->isEnabled = '';
        $this->resetPage();
    }

    public function toggleEnabled(int $id): void
    {
        $d = DataDictionary::find($id);
        if ($d) {
            $oldData = $d->toArray();
            $d->update(['is_enabled' => !$d->is_enabled]);
            $this->dispatch('notify', type: 'success', message: '状态已更新');
            AuditLogService::update('system_dictionary', '切换数据字典状态', "切换数据字典状态：{$d->name}", $oldData, $d->toArray());
        }
    }

    public function deleteDictionary(int $id): void
    {
        $d = DataDictionary::find($id);
        if ($d) {
            $data = $d->toArray();
            $d->delete();
            $this->dispatch('notify', type: 'success', message: '数据字典已删除');
            AuditLogService::delete('system_dictionary', '删除数据字典', "删除数据字典：{$data['name']}", $data);
        }
    }

    public function render()
    {
        $q = DataDictionary::query();
        if ($this->search) {
            $q->where(function ($qq) {
                $qq->where('name', 'like', "%{$this->search}%")
                  ->orWhere('code', 'like', "%{$this->search}%")
                  ->orWhere('value', 'like', "%{$this->search}%");
            });
        }
        if ($this->category) $q->where('category', $this->category);
        if ($this->isEnabled !== '') $q->where('is_enabled', (int)$this->isEnabled);

        $items = $q->orderBy('category')->orderBy('sort_order')->paginate(20);
        $categories = DataDictionary::select('category')->distinct()->pluck('category');

        return view('livewire.system.data-dictionary-list', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }
}

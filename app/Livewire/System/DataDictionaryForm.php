<?php

namespace App\Livewire\System;

use App\Models\DataDictionary;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AuditLogService;

#[Layout('layouts.app')]
class DataDictionaryForm extends Component
{
    public ?int $dictId = null;
    public array $form = [];
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'form.category' => 'required|string|max:50',
            'form.code' => 'required|string|max:50',
            'form.name' => 'required|string|max:100',
            'form.value' => 'nullable|string|max:255',
            'form.sort_order' => 'nullable|integer|min:0',
            'form.is_enabled' => 'boolean',
            'form.description' => 'nullable|string|max:500',
        ];
    }

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->dictId = $id;
            $this->isEditing = true;
            $this->form = DataDictionary::findOrFail($id)->toArray();
        } else {
            $this->form = ['is_enabled' => true, 'sort_order' => 0];
        }
    }

    public function save(): void
    {
        $this->validate();
        if ($this->isEditing) {
            $dict = DataDictionary::findOrFail($this->dictId);
            $oldData = $dict->toArray();
            $dict->update($this->form);
            $this->dispatch('notify', type: 'success', message: '数据字典已更新');
            AuditLogService::update('system_dictionary', '编辑数据字典', "编辑数据字典：{$dict->name}", $oldData, $dict->toArray());
        } else {
            $dict = DataDictionary::create($this->form);
            $this->dispatch('notify', type: 'success', message: '数据字典已创建');
            AuditLogService::create('system_dictionary', '创建数据字典', "创建数据字典：{$dict->name}", $dict->toArray());
        }
        $this->redirect(route('system.dictionaries.index'), navigate: true);
    }

    public function render()
    {
        $categories = DataDictionary::select('category')->distinct()->pluck('category');
        return view('livewire.system.data-dictionary-form', ['categories' => $categories]);
    }
}

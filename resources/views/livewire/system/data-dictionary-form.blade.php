<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑数据字典' : '新增数据字典' }}</flux:heading>
            <flux:subheading>配置系统基础数据</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('system.dictionaries.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.category" label="分类" required list="categories" /></div>
            <div><flux:input wire:model="form.code" label="编码" required /></div>
            <div><flux:input wire:model="form.name" label="名称" required /></div>
            <div><flux:input wire:model="form.value" label="值" /></div>
            <div><flux:input wire:model="form.sort_order" label="排序" type="number" min="0" /></div>
            <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" wire:model="form.is_enabled" id="enabled" class="rounded border-zinc-300 text-indigo-600">
                <label for="enabled" class="text-sm">启用</label>
            </div>
        </div>
        <div><flux:textarea wire:model="form.description" label="描述" rows="2" /></div>
        <datalist id="categories">
            @foreach($categories as $c)<option value="{{ $c }}">@endforeach
        </datalist>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建字典' }}</flux:button>
            <flux:button variant="ghost" :href="route('system.dictionaries.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

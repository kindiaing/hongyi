<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">数据字典</flux:heading>
            <flux:subheading>系统基础数据配置</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('system.dictionaries.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增字典
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索名称/编码/值..." /></div>
            <div class="w-48">
                <flux:select wire:model.live="category">
                    <option value="">全部分类</option>
                    @foreach($categories as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-32">
                <flux:select wire:model.live="isEnabled">
                    <option value="">全部状态</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </flux:select>
            </div>
            <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    <th class="px-4 py-3">分类</th>
                    <th class="px-4 py-3">编码</th>
                    <th class="px-4 py-3">名称</th>
                    <th class="px-4 py-3">值</th>
                    <th class="px-4 py-3">排序</th>
                    <th class="px-4 py-3">状态</th>
                    <th class="px-4 py-3">描述</th>
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($items as $d)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <td class="px-4 py-3"><flux:badge size="sm" color="blue">{{ $d->category }}</flux:badge></td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $d->code }}</td>
                    <td class="px-4 py-3 font-medium">{{ $d->name }}</td>
                    <td class="px-4 py-3">{{ $d->value ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $d->sort_order }}</td>
                    <td class="px-4 py-3"><flux:badge color="{{ $d->is_enabled ? 'emerald' : 'zinc' }}" size="sm">{{ $d->is_enabled ? '启用' : '禁用' }}</flux:badge></td>
                    <td class="px-4 py-3 max-w-xs truncate" title="{{ $d->description }}">{{ Str::limit($d->description, 30) ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" wire:click="toggleEnabled({{ $d->id }})" title="切换状态"><flux:icon.power class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" :href="route('system.dictionaries.edit', $d->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteDictionary({{ $d->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>

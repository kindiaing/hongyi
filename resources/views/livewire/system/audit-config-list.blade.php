<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">审计配置</flux:heading>
            <flux:subheading>操作日志审计开关与类型设置</flux:subheading>
        </div>
        <div class="flex items-center gap-2">
            <flux:button variant="ghost" size="sm" :href="route('system.logs.index')" wire:navigate>
                <flux:icon.arrow-uturn-left class="size-4" /> 返回日志
            </flux:button>
        </div>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="text-sm text-zinc-500">
            <p>审计配置用于控制各模块操作日志的记录策略。可以按模块开关审计功能，并细化到「创建/编辑/删除/查看」操作级别。</p>
            <p class="mt-1">关闭某模块审计后，该模块的所有操作将不再记录到日志中。</p>
        </div>
    </div>

    @foreach($groupedConfigs as $module => $configs)
    <div class="rounded-lg border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800">
        <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <flux:heading size="sm">{{ $module }}</flux:heading>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">审计类型</th>
                        <th class="px-4 py-3">说明</th>
                        <th class="px-4 py-3 text-center">总开关</th>
                        <th class="px-4 py-3 text-center">创建</th>
                        <th class="px-4 py-3 text-center">编辑</th>
                        <th class="px-4 py-3 text-center">删除</th>
                        <th class="px-4 py-3 text-center">查看</th>
                        <th class="px-4 py-3 text-center">记录旧数据</th>
                        <th class="px-4 py-3 text-center">记录新数据</th>
                        <th class="px-4 py-3 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                    @foreach($configs as $config)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $config['audit_name'] }}</div>
                            <div class="text-xs text-zinc-400">{{ $config['audit_type'] }}</div>
                        </td>
                        <td class="px-4 py-3 text-xs text-zinc-500 max-w-xs">{{ $config['description'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($config['is_enabled'])
                                <flux:badge size="sm" color="green">已启用</flux:badge>
                            @else
                                <flux:badge size="sm" color="red">已关闭</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_create']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_update']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_delete']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_view']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_old_data']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($config['record_new_data']) <flux:icon.check class="size-4 text-green-500 mx-auto" /> @else <flux:icon.x-mark class="size-4 text-zinc-300 mx-auto" /> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <flux:button variant="ghost" size="sm" wire:click="startEdit({{ $config['id'] }})">
                                <flux:icon.pencil class="size-4" />
                            </flux:button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    @if($showEdit && $editingId)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="cancelEdit">
        <div class="w-full max-w-lg rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800 shadow-xl">
            <flux:heading size="lg" class="mb-4">编辑审计配置</flux:heading>
            <div class="space-y-4">
                <div class="text-sm text-zinc-600 dark:text-zinc-300">
                    <span class="font-medium">{{ $editForm['audit_name'] ?? '' }}</span>
                    <span class="text-zinc-400 ml-2">({{ $editForm['audit_type'] ?? '' }})</span>
                </div>
                <div class="text-xs text-zinc-500">{{ $editForm['description'] ?? '' }}</div>

                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4 space-y-3">
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">总开关（启用审计）</span>
                        <input type="checkbox" wire:model="editForm.is_enabled" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录创建操作</span>
                        <input type="checkbox" wire:model="editForm.record_create" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录编辑操作</span>
                        <input type="checkbox" wire:model="editForm.record_update" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录删除操作</span>
                        <input type="checkbox" wire:model="editForm.record_delete" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录查看操作</span>
                        <input type="checkbox" wire:model="editForm.record_view" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录变更前数据</span>
                        <input type="checkbox" wire:model="editForm.record_old_data" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                    <label class="flex items-center justify-between py-2">
                        <span class="text-sm">记录变更后数据</span>
                        <input type="checkbox" wire:model="editForm.record_new_data" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <flux:button variant="primary" wire:click="saveConfig">保存</flux:button>
                <flux:button variant="ghost" wire:click="cancelEdit">取消</flux:button>
            </div>
        </div>
    </div>
    @endif
</div>

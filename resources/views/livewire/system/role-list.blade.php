<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">角色权限管理</flux:heading>
            <flux:subheading>配置各角色对应的系统权限</flux:subheading>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    <th class="px-4 py-3 w-48">角色</th>
                    <th class="px-4 py-3">已分配权限</th>
                    <th class="px-4 py-3 w-32 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($roles as $role)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    <td class="px-4 py-3">
                        <div class="font-medium">{{ $role->display_name ?? $role->name }}</div>
                        <div class="text-xs text-zinc-400">{{ $role->name }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @forelse($role->permissions->groupBy('group') as $group => $perms)
                                <div class="inline-flex items-center rounded-md border border-zinc-200 px-2 py-0.5 text-xs dark:border-zinc-700">
                                    <span class="font-medium mr-1">{{ $group }}:</span>
                                    {{ $perms->pluck('display_name')->implode('、') }}
                                </div>
                            @empty
                                <span class="text-zinc-400 text-xs">未分配权限</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($role->name !== 'super_admin')
                            @if($editingRoleId === $role->id)
                                <flux:button variant="ghost" size="sm" wire:click="cancelEdit">取消</flux:button>
                            @else
                                <flux:button variant="ghost" size="sm" wire:click="startEdit({{ $role->id }})">
                                    <flux:icon.pencil class="size-4" /> 配置权限
                                </flux:button>
                            @endif
                        @else
                            <span class="text-xs text-zinc-400">全部权限</span>
                        @endif
                    </td>
                </tr>

                @if($editingRoleId === $role->id)
                <tr>
                    <td colspan="3" class="px-4 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="space-y-4">
                            <div class="text-sm font-medium">为「{{ $role->display_name }}」配置权限：</div>
                            @foreach($permissions as $group => $groupPermissions)
                            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 p-3 bg-white dark:bg-zinc-900">
                                <div class="text-sm font-medium mb-2">{{ $group }}</div>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($groupPermissions as $perm)
                                        <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                                            <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-sm">{{ $perm->display_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <div class="flex items-center gap-3">
                                <flux:button variant="primary" size="sm" wire:click="savePermissions">保存权限配置</flux:button>
                                <flux:button variant="ghost" size="sm" wire:click="cancelEdit">取消</flux:button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr><td colspan="3" class="px-4 py-8 text-center text-zinc-500">暂无角色</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <flux:heading size="sm" class="mb-3">权限说明</flux:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="font-medium mb-1">超级管理员 (super_admin)</div>
                <div class="text-zinc-500">拥有系统全部权限，不可修改</div>
            </div>
            <div>
                <div class="font-medium mb-1">系统管理员 (admin)</div>
                <div class="text-zinc-500">拥有大部分管理权限，无删除权限</div>
            </div>
            <div>
                <div class="font-medium mb-1">项目经理 (project_manager)</div>
                <div class="text-zinc-500">管理自己负责的合同及关联资源，可审核巡检</div>
            </div>
            <div>
                <div class="font-medium mb-1">运维单位管理员 (vendor_admin)</div>
                <div class="text-zinc-500">管理本单位人员、设备、软件，可执行巡检</div>
            </div>
            <div>
                <div class="font-medium mb-1">运维单位人员 (vendor_staff)</div>
                <div class="text-zinc-500">只读本单位数据，可执行巡检任务</div>
            </div>
            <div>
                <div class="font-medium mb-1">服务单位 (service_unit)</div>
                <div class="text-zinc-500">只查看自己服务单位的满意度回访</div>
            </div>
            <div>
                <div class="font-medium mb-1">访客 (viewer)</div>
                <div class="text-zinc-500">全系统只读，不可操作</div>
            </div>
        </div>
    </div>
</div>

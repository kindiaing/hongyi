<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">软件系统管理</flux:heading>
            <flux:subheading>运维软件台账与维保管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('assets.software.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增软件
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索编号/名称/版本/服务器..." /></div>
            <div class="w-32">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    <option value="0">停用</option><option value="1">运行中</option><option value="2">维护中</option>
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="vendorId">
                    <option value="">全部运维单位</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <flux:button variant="ghost" wire:click="resetFilters" size="sm">重置</flux:button>
            <div class="ml-auto">
                <flux:button variant="ghost" size="sm" wire:click="$toggle('showColumnPicker')">
                    <flux:icon.adjustments-horizontal class="size-4" /> 自定义列
                </flux:button>
            </div>
        </div>

        @if($showColumnPicker)
        <div class="mt-4 rounded-md border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-2 text-sm font-medium text-zinc-600 dark:text-zinc-400">选择要显示的列：</div>
            <div class="flex flex-wrap gap-3">
                @foreach($availableColumns as $key => $col)
                    <label class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-1.5 dark:border-zinc-700 cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <input type="checkbox" wire:model.live="visibleColumns" value="{{ $key }}" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm">{{ $col['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                <tr>
                    @if(in_array('software_no', $visibleColumns))<th class="px-4 py-3">软件编号</th>@endif
                    @if(in_array('software_name', $visibleColumns))<th class="px-4 py-3">软件名称</th>@endif
                    @if(in_array('version', $visibleColumns))<th class="px-4 py-3">版本</th>@endif
                    @if(in_array('deploy_environment', $visibleColumns))<th class="px-4 py-3">部署环境</th>@endif
                    @if(in_array('deploy_server', $visibleColumns))<th class="px-4 py-3">部署服务器</th>@endif
                    @if(in_array('license_info', $visibleColumns))<th class="px-4 py-3">许可证</th>@endif
                    @if(in_array('vendor', $visibleColumns))<th class="px-4 py-3">运维单位</th>@endif
                    @if(in_array('maintenance_start_date', $visibleColumns))<th class="px-4 py-3">运维开始</th>@endif
                    @if(in_array('maintenance_end_date', $visibleColumns))<th class="px-4 py-3">运维结束</th>@endif
                    @if(in_array('sla_level', $visibleColumns))<th class="px-4 py-3">SLA</th>@endif
                    @if(in_array('is_resident_required', $visibleColumns))<th class="px-4 py-3">驻场</th>@endif
                    @if(in_array('work_start_time', $visibleColumns))<th class="px-4 py-3">工作开始</th>@endif
                    @if(in_array('work_end_time', $visibleColumns))<th class="px-4 py-3">工作结束</th>@endif
                    @if(in_array('emergency_response_time', $visibleColumns))<th class="px-4 py-3">响应时间</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($software as $s)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('software_no', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $s->software_no }}</td>@endif
                    @if(in_array('software_name', $visibleColumns))<td class="px-4 py-3">{{ $s->software_name }}</td>@endif
                    @if(in_array('version', $visibleColumns))<td class="px-4 py-3">{{ $s->version ?? '-' }}</td>@endif
                    @if(in_array('deploy_environment', $visibleColumns))<td class="px-4 py-3">{{ $s->deploy_environment ?? '-' }}</td>@endif
                    @if(in_array('deploy_server', $visibleColumns))<td class="px-4 py-3">{{ $s->deploy_server ?? '-' }}</td>@endif
                    @if(in_array('license_info', $visibleColumns))<td class="px-4 py-3 max-w-xs truncate" title="{{ $s->license_info }}">{{ Str::limit($s->license_info, 20) ?? '-' }}</td>@endif
                    @if(in_array('vendor', $visibleColumns))<td class="px-4 py-3">{{ $s->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('maintenance_start_date', $visibleColumns))<td class="px-4 py-3">{{ $s->maintenance_start_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('maintenance_end_date', $visibleColumns))<td class="px-4 py-3">{{ $s->maintenance_end_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('sla_level', $visibleColumns))<td class="px-4 py-3">{{ $s->sla_level ?? '-' }}</td>@endif
                    @if(in_array('is_resident_required', $visibleColumns))<td class="px-4 py-3">{{ $s->is_resident_required ? '是' : '否' }}</td>@endif
                    @if(in_array('work_start_time', $visibleColumns))<td class="px-4 py-3">{{ $s->work_start_time ?? '-' }}</td>@endif
                    @if(in_array('work_end_time', $visibleColumns))<td class="px-4 py-3">{{ $s->work_end_time ?? '-' }}</td>@endif
                    @if(in_array('emergency_response_time', $visibleColumns))<td class="px-4 py-3">{{ $s->emergency_response_time ? $s->emergency_response_time . '分' : '-' }}</td>@endif
                    @if(in_array('status', $visibleColumns))
                        <td class="px-4 py-3">
                            @php $sc = ['zinc','orange','emerald']; @endphp
                            <flux:badge color="{{ $sc[$s->status] ?? 'zinc' }}" size="sm">{{ $s->status_text }}</flux:badge>
                        </td>
                    @endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $s->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('assets.software.edit', $s->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteSoftware({{ $s->id }})" wire:confirm="确定删除此软件？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $software->links() }}</div>
</div>

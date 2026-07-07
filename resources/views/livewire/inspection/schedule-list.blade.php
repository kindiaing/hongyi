<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">排班管理</flux:heading>
            <flux:subheading>值班排班与替班管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('inspection.schedules.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增排班
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索值班人员..." /></div>
            <div class="w-32">
                <flux:select wire:model.live="shiftType">
                    <option value="">全部班次</option>
                    <option value="day">白班</option>
                    <option value="night">夜班</option>
                    <option value="holiday">节假日班</option>
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="softwareId">
                    <option value="">全部软件</option>
                    @foreach($softwareList as $s)<option value="{{ $s->id }}">{{ $s->software_name }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="personnelId">
                    <option value="">全部人员</option>
                    @foreach($personnelList as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-40"><flux:input wire:model.live="dateFrom" type="date" label="开始日期" /></div>
            <div class="w-40"><flux:input wire:model.live="dateTo" type="date" label="结束日期" /></div>
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
                    @if(in_array('software', $visibleColumns))<th class="px-4 py-3">软件系统</th>@endif
                    @if(in_array('personnel', $visibleColumns))<th class="px-4 py-3">值班人员</th>@endif
                    @if(in_array('shift_date', $visibleColumns))<th class="px-4 py-3">值班日期</th>@endif
                    @if(in_array('shift_type', $visibleColumns))<th class="px-4 py-3">班次</th>@endif
                    @if(in_array('start_time', $visibleColumns))<th class="px-4 py-3">开始</th>@endif
                    @if(in_array('end_time', $visibleColumns))<th class="px-4 py-3">结束</th>@endif
                    @if(in_array('is_replaced', $visibleColumns))<th class="px-4 py-3">替班</th>@endif
                    @if(in_array('replaced_by', $visibleColumns))<th class="px-4 py-3">替班人</th>@endif
                    @if(in_array('replace_reason', $visibleColumns))<th class="px-4 py-3">替班原因</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($schedules as $s)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('software', $visibleColumns))<td class="px-4 py-3">{{ $s->software?->software_name ?? '-' }}</td>@endif
                    @if(in_array('personnel', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $s->personnel?->name ?? '-' }}</td>@endif
                    @if(in_array('shift_date', $visibleColumns))<td class="px-4 py-3">{{ $s->shift_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('shift_type', $visibleColumns))<td class="px-4 py-3">{{ $s->shift_type_text }}</td>@endif
                    @if(in_array('start_time', $visibleColumns))<td class="px-4 py-3">{{ substr($s->start_time, 0, 5) }}</td>@endif
                    @if(in_array('end_time', $visibleColumns))<td class="px-4 py-3">{{ substr($s->end_time, 0, 5) }}</td>@endif
                    @if(in_array('is_replaced', $visibleColumns))<td class="px-4 py-3">{{ $s->is_replaced ? '是' : '否' }}</td>@endif
                    @if(in_array('replaced_by', $visibleColumns))<td class="px-4 py-3">{{ $s->replacedByPersonnel?->name ?? '-' }}</td>@endif
                    @if(in_array('replace_reason', $visibleColumns))<td class="px-4 py-3 max-w-xs truncate" title="{{ $s->replace_reason }}">{{ Str::limit($s->replace_reason, 20) ?? '-' }}</td>@endif
                    @if(in_array('status', $visibleColumns))<td class="px-4 py-3"><flux:badge color="{{ $s->status === 1 ? 'emerald' : 'zinc' }}" size="sm">{{ $s->status_text }}</flux:badge></td>@endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $s->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('inspection.schedules.edit', $s->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteSchedule({{ $s->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $schedules->links() }}</div>
</div>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">人员管理</flux:heading>
            <flux:subheading>运维单位下的人员信息管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('personnel.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增人员
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索姓名/手机号/岗位..." /></div>
            <div class="w-32">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    <option value="1">在职</option><option value="0">离职</option><option value="2">休假</option>
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="vendorId">
                    <option value="">全部单位</option>
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
                    @if(in_array('name', $visibleColumns))<th class="px-4 py-3">姓名</th>@endif
                    @if(in_array('vendor', $visibleColumns))<th class="px-4 py-3">所属单位</th>@endif
                    @if(in_array('phone', $visibleColumns))<th class="px-4 py-3">手机号</th>@endif
                    @if(in_array('email', $visibleColumns))<th class="px-4 py-3">邮箱</th>@endif
                    @if(in_array('gender', $visibleColumns))<th class="px-4 py-3">性别</th>@endif
                    @if(in_array('position', $visibleColumns))<th class="px-4 py-3">岗位</th>@endif
                    @if(in_array('job_title', $visibleColumns))<th class="px-4 py-3">职称</th>@endif
                    @if(in_array('entry_date', $visibleColumns))<th class="px-4 py-3">入职日期</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('is_resident', $visibleColumns))<th class="px-4 py-3">驻场</th>@endif
                    @if(in_array('resident_location', $visibleColumns))<th class="px-4 py-3">驻场地点</th>@endif
                    @if(in_array('work_start_time', $visibleColumns))<th class="px-4 py-3">工作开始</th>@endif
                    @if(in_array('work_end_time', $visibleColumns))<th class="px-4 py-3">工作结束</th>@endif
                    @if(in_array('emergency_contact', $visibleColumns))<th class="px-4 py-3">紧急联系人</th>@endif
                    @if(in_array('emergency_phone', $visibleColumns))<th class="px-4 py-3">紧急电话</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($personnel as $p)
                @php
                    $statusMap = ['离职','在职','休假'];
                    $statusColors = ['red','emerald','orange'];
                @endphp
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('name', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $p->name }}</td>@endif
                    @if(in_array('vendor', $visibleColumns))<td class="px-4 py-3">{{ $p->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('phone', $visibleColumns))<td class="px-4 py-3">{{ $p->phone }}</td>@endif
                    @if(in_array('email', $visibleColumns))<td class="px-4 py-3">{{ $p->email ?? '-' }}</td>@endif
                    @if(in_array('gender', $visibleColumns))<td class="px-4 py-3">{{ $p->gender_text }}</td>@endif
                    @if(in_array('position', $visibleColumns))<td class="px-4 py-3">{{ $p->position ?? '-' }}</td>@endif
                    @if(in_array('job_title', $visibleColumns))<td class="px-4 py-3">{{ $p->job_title ?? '-' }}</td>@endif
                    @if(in_array('entry_date', $visibleColumns))<td class="px-4 py-3">{{ $p->entry_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('status', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $statusColors[$p->status] ?? 'zinc' }}" size="sm">{{ $statusMap[$p->status] ?? '未知' }}</flux:badge></td>
                    @endif
                    @if(in_array('is_resident', $visibleColumns))<td class="px-4 py-3">{{ $p->is_resident ? '是' : '否' }}</td>@endif
                    @if(in_array('resident_location', $visibleColumns))<td class="px-4 py-3">{{ $p->resident_location ?? '-' }}</td>@endif
                    @if(in_array('work_start_time', $visibleColumns))<td class="px-4 py-3">{{ $p->work_start_time ?? '-' }}</td>@endif
                    @if(in_array('work_end_time', $visibleColumns))<td class="px-4 py-3">{{ $p->work_end_time ?? '-' }}</td>@endif
                    @if(in_array('emergency_contact', $visibleColumns))<td class="px-4 py-3">{{ $p->emergency_contact ?? '-' }}</td>@endif
                    @if(in_array('emergency_phone', $visibleColumns))<td class="px-4 py-3">{{ $p->emergency_phone ?? '-' }}</td>@endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $p->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('personnel.edit', $p->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deletePersonnel({{ $p->id }})" wire:confirm="确定删除此人员？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $personnel->links() }}</div>
</div>

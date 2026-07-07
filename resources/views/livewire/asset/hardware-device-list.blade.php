<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">硬件设备管理</flux:heading>
            <flux:subheading>硬件设备台账与维保管理</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('assets.hardware.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增设备
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索编号/名称/品牌/型号..." /></div>
            <div class="w-40">
                <flux:select wire:model.live="deviceType">
                    <option value="">全部类型</option>
                    @foreach($deviceTypes as $code => $name)<option value="{{ $code }}">{{ $name }}</option>@endforeach
                </flux:select>
            </div>
            <div class="w-32">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    <option value="0">报废</option><option value="1">在用</option><option value="2">维修中</option><option value="3">闲置</option>
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
                    @if(in_array('device_no', $visibleColumns))<th class="px-4 py-3">设备编号</th>@endif
                    @if(in_array('device_name', $visibleColumns))<th class="px-4 py-3">设备名称</th>@endif
                    @if(in_array('device_type', $visibleColumns))<th class="px-4 py-3">类型</th>@endif
                    @if(in_array('brand', $visibleColumns))<th class="px-4 py-3">品牌</th>@endif
                    @if(in_array('model', $visibleColumns))<th class="px-4 py-3">型号</th>@endif
                    @if(in_array('serial_no', $visibleColumns))<th class="px-4 py-3">序列号</th>@endif
                    @if(in_array('location', $visibleColumns))<th class="px-4 py-3">位置</th>@endif
                    @if(in_array('vendor', $visibleColumns))<th class="px-4 py-3">运维单位</th>@endif
                    @if(in_array('purchase_date', $visibleColumns))<th class="px-4 py-3">采购日期</th>@endif
                    @if(in_array('purchase_amount', $visibleColumns))<th class="px-4 py-3 text-right">采购金额</th>@endif
                    @if(in_array('warranty_period', $visibleColumns))<th class="px-4 py-3">质保(月)</th>@endif
                    @if(in_array('start_date', $visibleColumns))<th class="px-4 py-3">启用日期</th>@endif
                    @if(in_array('expiry_date', $visibleColumns))<th class="px-4 py-3">预计到期</th>@endif
                    @if(in_array('next_maintenance_date', $visibleColumns))<th class="px-4 py-3">下次维保</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($devices as $d)
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('device_no', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $d->device_no }}</td>@endif
                    @if(in_array('device_name', $visibleColumns))<td class="px-4 py-3">{{ $d->device_name }}</td>@endif
                    @if(in_array('device_type', $visibleColumns))<td class="px-4 py-3">{{ $deviceTypes[$d->device_type] ?? $d->device_type }}</td>@endif
                    @if(in_array('brand', $visibleColumns))<td class="px-4 py-3">{{ $d->brand ?? '-' }}</td>@endif
                    @if(in_array('model', $visibleColumns))<td class="px-4 py-3">{{ $d->model ?? '-' }}</td>@endif
                    @if(in_array('serial_no', $visibleColumns))<td class="px-4 py-3">{{ $d->serial_no ?? '-' }}</td>@endif
                    @if(in_array('location', $visibleColumns))<td class="px-4 py-3">{{ $d->location ?? '-' }}</td>@endif
                    @if(in_array('vendor', $visibleColumns))<td class="px-4 py-3">{{ $d->vendor?->name ?? '-' }}</td>@endif
                    @if(in_array('purchase_date', $visibleColumns))<td class="px-4 py-3">{{ $d->purchase_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('purchase_amount', $visibleColumns))<td class="px-4 py-3 text-right">{{ $d->purchase_amount ? number_format($d->purchase_amount, 2) : '-' }}</td>@endif
                    @if(in_array('warranty_period', $visibleColumns))<td class="px-4 py-3">{{ $d->warranty_period ?? '-' }}</td>@endif
                    @if(in_array('start_date', $visibleColumns))<td class="px-4 py-3">{{ $d->start_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('expiry_date', $visibleColumns))<td class="px-4 py-3">{{ $d->expiry_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('next_maintenance_date', $visibleColumns))<td class="px-4 py-3">{{ $d->next_maintenance_date?->format('Y-m-d') ?? '-' }}</td>@endif
                    @if(in_array('status', $visibleColumns))
                        <td class="px-4 py-3">
                            @php $sc = ['zinc','emerald','orange','blue']; @endphp
                            <flux:badge color="{{ $sc[$d->status] ?? 'zinc' }}" size="sm">{{ $d->status_text }}</flux:badge>
                        </td>
                    @endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $d->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('assets.hardware.edit', $d->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteDevice({{ $d->id }})" wire:confirm="确定删除此设备？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $devices->links() }}</div>
</div>

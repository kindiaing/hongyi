<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">任务详情</flux:heading>
            <flux:subheading>{{ $task->task_no }} - {{ $task->task_name }}</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('inspection.tasks.index')" wire:navigate>返回列表</flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
                <flux:heading size="base" class="mb-4">基本信息</flux:heading>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-zinc-500">任务类型</div><div>{{ $task->task_type_text }}</div>
                    <div class="text-zinc-500">运维单位</div><div>{{ $task->vendor?->name ?? '-' }}</div>
                    <div class="text-zinc-500">巡检对象</div><div>{{ $task->target_name }}</div>
                    <div class="text-zinc-500">执行人</div><div>{{ $task->assignee?->name ?? '-' }}</div>
                    <div class="text-zinc-500">计划日期</div><div>{{ $task->planned_date?->format('Y-m-d') ?? '-' }}</div>
                    <div class="text-zinc-500">计划时间</div><div>{{ $task->planned_time ? substr($task->planned_time, 0, 5) : '-' }}</div>
                    <div class="text-zinc-500">签到地址</div><div>{{ $task->sign_in_address ?? '-' }}</div>
                    <div class="text-zinc-500">签到坐标</div><div>@if($task->sign_in_lat){{ $task->sign_in_lat }}, {{ $task->sign_in_lng }}@else - @endif</div>
                </div>
            </div>

            @if($task->taskItems->count())
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
                <flux:heading size="base" class="mb-4">检查项结果</flux:heading>
                <div class="space-y-3">
                    @foreach($task->taskItems as $item)
                    <div class="rounded-md border border-zinc-100 p-3 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-sm">{{ $item->templateItem?->item_name ?? '未知项' }}</span>
                            @if($item->is_normal !== null)
                                <flux:badge color="{{ $item->is_normal === 1 ? 'emerald' : 'red' }}" size="sm">{{ $item->is_normal === 1 ? '正常' : '异常' }}</flux:badge>
                            @endif
                        </div>
                        <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">结果：{{ $item->result_value ?? '-' }}</div>
                        @if($item->abnormal_desc)
                        <div class="mt-1 text-sm text-red-600">异常说明：{{ $item->abnormal_desc }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($task->exception_desc)
            <div class="rounded-lg border border-red-200 bg-red-50 p-6 dark:border-red-800 dark:bg-red-900/20">
                <flux:heading size="base" class="mb-2 text-red-700 dark:text-red-400">异常情况</flux:heading>
                <p class="text-sm text-red-700 dark:text-red-300">{{ $task->exception_desc }}</p>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
                <flux:heading size="base" class="mb-4">状态信息</flux:heading>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-zinc-500">状态</span><flux:badge color="{{ $task->status_color }}" size="sm">{{ $task->status_text }}</flux:badge></div>
                    <div class="flex justify-between"><span class="text-zinc-500">检查结果</span><span>@if($task->overall_result !== null)<flux:badge color="{{ $task->overall_result === 1 ? 'emerald' : 'red' }}" size="sm">{{ $task->overall_result_text }}</flux:badge>@else - @endif</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">开始时间</span><span>{{ $task->start_time?->format('Y-m-d H:i') ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">结束时间</span><span>{{ $task->end_time?->format('Y-m-d H:i') ?? '-' }}</span></div>
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
                <flux:heading size="base" class="mb-4">审核信息</flux:heading>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-zinc-500">审核人</span><span>{{ $task->auditor?->name ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">审核时间</span><span>{{ $task->audit_time?->format('Y-m-d H:i') ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-zinc-500">审核结果</span><span>@if($task->audit_result !== null)<flux:badge color="{{ $task->audit_result === 1 ? 'emerald' : 'red' }}" size="sm">{{ $task->audit_result === 1 ? '通过' : '不通过' }}</flux:badge>@else - @endif</span></div>
                    @if($task->audit_comment)
                    <div class="pt-2 border-t border-zinc-100 dark:border-zinc-700"><span class="text-zinc-500">审核意见</span><p class="mt-1">{{ $task->audit_comment }}</p></div>
                    @endif
                </div>
                @if($task->status === 2)
                <div class="mt-4 flex gap-2">
                    <flux:button variant="primary" size="sm" wire:click="auditTask(true)">通过</flux:button>
                    <flux:button variant="outline" size="sm" color="red" wire:click="auditTask(false)">不通过</flux:button>
                </div>
                @endif
            </div>

            @if($task->photos->count())
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
                <flux:heading size="base" class="mb-4">照片记录</flux:heading>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($task->photos as $photo)
                    <div class="rounded overflow-hidden bg-zinc-100 aspect-square flex items-center justify-center text-xs text-zinc-400">
                        {{ $photo->photo_desc ?? '照片' }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

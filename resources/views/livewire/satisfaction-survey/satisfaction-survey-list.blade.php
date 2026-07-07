<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg" level="1">回访/满意度调查</flux:heading>
            <flux:subheading>项目经理对运维人员的回访和满意度调查记录</flux:subheading>
        </div>
        <flux:button variant="primary" :href="route('satisfaction.surveys.create')" wire:navigate>
            <flux:icon.plus class="size-4" /> 新增回访
        </flux:button>
    </div>

    <div class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="flex flex-wrap items-end gap-4">
            <div class="w-64"><flux:input wire:model.live.debounce.300ms="search" placeholder="搜索评价内容/人员..." /></div>
            <div class="w-48">
                <flux:select wire:model.live="serviceUnitId">
                    <option value="">全部服务单位</option>
                    @foreach($serviceUnits as $su)
                        <option value="{{ $su->id }}">{{ $su->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-36">
                <flux:select wire:model.live="satisfactionLevel">
                    <option value="">全部满意度</option>
                    <option value="very_satisfied">非常满意</option>
                    <option value="satisfied">满意</option>
                    <option value="general">一般</option>
                    <option value="dissatisfied">不满意</option>
                </flux:select>
            </div>
            <div class="w-32">
                <flux:select wire:model.live="status">
                    <option value="">全部状态</option>
                    <option value="1">已完成</option>
                    <option value="0">待回访</option>
                </flux:select>
            </div>
            <div class="w-36"><flux:input type="date" wire:model.live="dateFrom" label="开始日期" /></div>
            <div class="w-36"><flux:input type="date" wire:model.live="dateTo" label="结束日期" /></div>
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
                    @if(in_array('survey_date', $visibleColumns))<th class="px-4 py-3">回访日期</th>@endif
                    @if(in_array('service_unit_name', $visibleColumns))<th class="px-4 py-3">服务单位</th>@endif
                    @if(in_array('personnel_name', $visibleColumns))<th class="px-4 py-3">被评价人员</th>@endif
                    @if(in_array('satisfaction_level', $visibleColumns))<th class="px-4 py-3">满意度</th>@endif
                    @if(in_array('service_attitude_score', $visibleColumns))<th class="px-4 py-3">服务态度</th>@endif
                    @if(in_array('response_speed_score', $visibleColumns))<th class="px-4 py-3">响应速度</th>@endif
                    @if(in_array('technical_level_score', $visibleColumns))<th class="px-4 py-3">技术水平</th>@endif
                    @if(in_array('average_score', $visibleColumns))<th class="px-4 py-3">综合评分</th>@endif
                    @if(in_array('surveyor_name', $visibleColumns))<th class="px-4 py-3">调查人</th>@endif
                    @if(in_array('status', $visibleColumns))<th class="px-4 py-3">状态</th>@endif
                    @if(in_array('created_at', $visibleColumns))<th class="px-4 py-3">创建时间</th>@endif
                    <th class="px-4 py-3 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                @forelse($surveys as $survey)
                @php
                    $levelMap = ['very_satisfied'=>'非常满意','satisfied'=>'满意','general'=>'一般','dissatisfied'=>'不满意'];
                    $levelColors = ['very_satisfied'=>'emerald','satisfied'=>'blue','general'=>'orange','dissatisfied'=>'red'];
                @endphp
                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                    @if(in_array('survey_date', $visibleColumns))<td class="px-4 py-3">{{ $survey->survey_date->format('Y-m-d') }}</td>@endif
                    @if(in_array('service_unit_name', $visibleColumns))<td class="px-4 py-3">{{ $survey->serviceUnit?->name ?? '-' }}</td>@endif
                    @if(in_array('personnel_name', $visibleColumns))<td class="px-4 py-3">{{ $survey->personnel?->name ?? '-' }}</td>@endif
                    @if(in_array('satisfaction_level', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $levelColors[$survey->satisfaction_level] ?? 'zinc' }}" size="sm">{{ $levelMap[$survey->satisfaction_level] ?? $survey->satisfaction_level }}</flux:badge></td>
                    @endif
                    @if(in_array('service_attitude_score', $visibleColumns))<td class="px-4 py-3">{{ $survey->service_attitude_score ? $survey->service_attitude_score . '分' : '-' }}</td>@endif
                    @if(in_array('response_speed_score', $visibleColumns))<td class="px-4 py-3">{{ $survey->response_speed_score ? $survey->response_speed_score . '分' : '-' }}</td>@endif
                    @if(in_array('technical_level_score', $visibleColumns))<td class="px-4 py-3">{{ $survey->technical_level_score ? $survey->technical_level_score . '分' : '-' }}</td>@endif
                    @if(in_array('average_score', $visibleColumns))<td class="px-4 py-3 font-medium">{{ $survey->average_score ? $survey->average_score . '分' : '-' }}</td>@endif
                    @if(in_array('surveyor_name', $visibleColumns))<td class="px-4 py-3">{{ $survey->surveyor?->name ?? '-' }}</td>@endif
                    @if(in_array('status', $visibleColumns))
                        <td class="px-4 py-3"><flux:badge color="{{ $survey->status ? 'emerald' : 'orange' }}" size="sm">{{ $survey->status ? '已完成' : '待回访' }}</flux:badge></td>
                    @endif
                    @if(in_array('created_at', $visibleColumns))<td class="px-4 py-3">{{ $survey->created_at->format('Y-m-d H:i') }}</td>@endif
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <flux:button variant="ghost" size="sm" :href="route('satisfaction.surveys.edit', $survey->id)" wire:navigate><flux:icon.pencil class="size-4" /></flux:button>
                            <flux:button variant="ghost" size="sm" color="red" wire:click="deleteSurvey({{ $survey->id }})" wire:confirm="确定删除？"><flux:icon.trash class="size-4" /></flux:button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ count($visibleColumns) + 1 }}" class="px-4 py-8 text-center text-zinc-500">暂无数据</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $surveys->links() }}</div>
</div>

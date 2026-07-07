<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑回访计划' : '新增回访计划' }}</flux:heading>
            <flux:subheading>配置周期性回访/满意度调查计划</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('satisfaction.plans.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="md:col-span-2"><flux:input wire:model="form.plan_name" label="计划名称" required /></div>
            <div>
                <flux:select wire:model="form.service_unit_id" label="服务单位" required>
                    <option value="">请选择</option>
                    @foreach($serviceUnits as $su)
                        <option value="{{ $su->id }}">{{ $su->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.vendor_id" label="运维单位（可选）">
                    <option value="">全部运维单位</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.cycle_type" label="周期类型" required>
                    <option value="monthly">月度</option>
                    <option value="quarterly">季度</option>
                    <option value="annually">年度</option>
                    <option value="custom">自定义</option>
                </flux:select>
            </div>
            @if(in_array($form['cycle_type'] ?? '', ['quarterly', 'annually']))
            <div>
                <flux:select wire:model="form.cycle_month" label="执行月份">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}月</option>
                    @endfor
                </flux:select>
            </div>
            @endif
            @if(($form['cycle_type'] ?? '') !== 'custom')
            <div>
                <flux:input type="number" wire:model="form.cycle_day" label="执行日期(1-31)" min="1" max="31" />
            </div>
            @endif
            <div><flux:input type="date" wire:model="form.start_date" label="开始日期" required /></div>
            <div><flux:input type="date" wire:model="form.end_date" label="结束日期（可选）" /></div>
            <div><flux:input type="number" wire:model="form.remind_days" label="提前提醒天数" min="0" max="30" required /></div>
            <div>
                <flux:select wire:model="form.is_enabled" label="启用状态" required>
                    <option value="1">启用</option>
                    <option value="0">停用</option>
                </flux:select>
            </div>
        </div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建计划' }}</flux:button>
            <flux:button variant="ghost" :href="route('satisfaction.plans.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

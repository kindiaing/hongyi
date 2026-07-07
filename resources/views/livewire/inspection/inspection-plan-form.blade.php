<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑巡检计划' : '新增巡检计划' }}</flux:heading>
            <flux:subheading>配置周期性巡检/回访计划</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('inspection.plans.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.plan_name" label="计划名称" required /></div>
            <div>
                <flux:select wire:model="form.template_id" label="巡检模板" required>
                    <option value="">请选择</option>
                    @foreach($templates as $t)<option value="{{ $t->id }}">{{ $t->template_name }} ({{ $t->template_type_text }})</option>@endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.vendor_id" label="运维单位" required>
                    <option value="">请选择</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.target_type" label="巡检对象类型" required>
                    <option value="hardware">硬件设备</option>
                    <option value="software">软件系统</option>
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.target_id" label="巡检对象" required>
                    <option value="">请选择</option>
                    @if($form['target_type'] === 'software')
                        @foreach($softwareList as $s)<option value="{{ $s->id }}">{{ $s->software_name }}</option>@endforeach
                    @else
                        @foreach($hardwareDevices as $d)<option value="{{ $d->id }}">{{ $d->device_name }}</option>@endforeach
                    @endif
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.cycle_type" label="周期类型" required>
                    <option value="daily">每日</option>
                    <option value="weekly">每周</option>
                    <option value="biweekly">双周</option>
                    <option value="monthly">每月</option>
                    <option value="quarterly">每季度</option>
                    <option value="custom">自定义</option>
                </flux:select>
            </div>
            @if(($form['cycle_type'] ?? '') === 'custom')
            <div><flux:input wire:model="form.cycle_days" label="自定义周期(天)" type="number" min="1" /></div>
            @endif
            <div><flux:input wire:model="form.execute_time" label="执行时间" type="time" required /></div>
            <div><flux:input wire:model="form.start_date" label="开始日期" type="date" required /></div>
            <div><flux:input wire:model="form.end_date" label="结束日期(可选)" type="date" /></div>
            <div>
                <flux:select wire:model="form.assignee_id" label="负责人">
                    <option value="">请选择</option>
                    @foreach($personnel as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </flux:select>
            </div>
            <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" wire:model="form.is_enabled" id="enabled" class="rounded border-zinc-300 text-indigo-600">
                <label for="enabled" class="text-sm">启用计划</label>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建计划' }}</flux:button>
            <flux:button variant="ghost" :href="route('inspection.plans.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

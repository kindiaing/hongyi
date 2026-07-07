<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑排班' : '新增排班' }}</flux:heading>
            <flux:subheading>安排值班与替班</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('inspection.schedules.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <flux:select wire:model="form.software_id" label="软件系统">
                    <option value="">请选择</option>
                    @foreach($softwareList as $s)<option value="{{ $s->id }}">{{ $s->software_name }}</option>@endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.personnel_id" label="值班人员" required>
                    <option value="">请选择</option>
                    @foreach($personnelList as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.shift_date" label="值班日期" type="date" required /></div>
            <div>
                <flux:select wire:model="form.shift_type" label="班次" required>
                    <option value="day">白班</option>
                    <option value="night">夜班</option>
                    <option value="holiday">节假日班</option>
                </flux:select>
            </div>
            <div><flux:input wire:model="form.start_time" label="开始时间" type="time" required /></div>
            <div><flux:input wire:model="form.end_time" label="结束时间" type="time" required /></div>
            <div>
                <flux:select wire:model="form.status" label="状态" required>
                    <option value="1">正常</option>
                    <option value="0">取消</option>
                </flux:select>
            </div>
            <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" wire:model="form.is_replaced" id="replaced" class="rounded border-zinc-300 text-indigo-600">
                <label for="replaced" class="text-sm">已替班</label>
            </div>
            @if($form['is_replaced'] ?? false)
            <div>
                <flux:select wire:model="form.replaced_by" label="替班人">
                    <option value="">请选择</option>
                    @foreach($personnelList as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.replace_reason" label="替班原因" /></div>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建排班' }}</flux:button>
            <flux:button variant="ghost" :href="route('inspection.schedules.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

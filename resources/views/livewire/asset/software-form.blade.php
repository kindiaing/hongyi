<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑软件' : '新增软件' }}</flux:heading>
            <flux:subheading>填写软件系统信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('assets.software.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div><flux:input wire:model="form.software_no" label="软件编号" required /></div>
            <div><flux:input wire:model="form.software_name" label="软件名称" required /></div>
            <div><flux:input wire:model="form.version" label="版本号" /></div>
            <div><flux:input wire:model="form.deploy_environment" label="部署环境" /></div>
            <div><flux:input wire:model="form.deploy_server" label="部署服务器" /></div>
            <div>
                <flux:select wire:model="form.vendor_id" label="运维单位">
                    <option value="">请选择</option>
                    @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                </flux:select>
            </div>
            <div><flux:input wire:model="form.maintenance_start_date" label="运维开始日期" type="date" /></div>
            <div><flux:input wire:model="form.maintenance_end_date" label="运维结束日期" type="date" /></div>
            <div><flux:input wire:model="form.sla_level" label="SLA等级" /></div>
            <div><flux:input wire:model="form.maintenance_cycle" label="运维周期" /></div>
            <div><flux:input wire:model="form.work_start_time" label="工作开始时间" type="time" /></div>
            <div><flux:input wire:model="form.work_end_time" label="工作结束时间" type="time" /></div>
            <div><flux:input wire:model="form.emergency_response_time" label="紧急响应时间(分钟)" type="number" /></div>
            <div>
                <flux:select wire:model="form.status" label="状态" required>
                    <option value="1">运行中</option><option value="0">停用</option><option value="2">维护中</option>
                </flux:select>
            </div>
            <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" wire:model="form.is_resident_required" id="resident" class="rounded border-zinc-300 text-indigo-600">
                <label for="resident" class="text-sm">需要驻场</label>
            </div>
        </div>
        <div><flux:input wire:model="form.resident_location" label="驻场地点" /></div>
        <div><flux:input wire:model="form.license_info" label="许可证信息" /></div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建软件' }}</flux:button>
            <flux:button variant="ghost" :href="route('assets.software.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

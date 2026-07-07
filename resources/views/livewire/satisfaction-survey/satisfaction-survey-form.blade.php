<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $isEditing ? '编辑回访记录' : '新增回访记录' }}</flux:heading>
            <flux:subheading>填写回访/满意度调查信息</flux:subheading>
        </div>
        <flux:button variant="ghost" :href="route('satisfaction.surveys.index')" wire:navigate>返回列表</flux:button>
    </div>
    <form wire:submit="save" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <flux:select wire:model="form.service_unit_id" label="服务单位" required>
                    <option value="">请选择</option>
                    @foreach($serviceUnits as $su)
                        <option value="{{ $su->id }}">{{ $su->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:select wire:model="form.personnel_id" label="被评价运维人员">
                    <option value="">请选择（可选）</option>
                    @foreach($personnelList as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->vendor?->name ?? '无单位' }})</option>
                    @endforeach
                </flux:select>
            </div>
            <div><flux:input type="date" wire:model="form.survey_date" label="回访日期" required /></div>
            <div>
                <flux:select wire:model="form.satisfaction_level" label="满意度" required>
                    <option value="very_satisfied">非常满意</option>
                    <option value="satisfied">满意</option>
                    <option value="general">一般</option>
                    <option value="dissatisfied">不满意</option>
                </flux:select>
            </div>
            <div><flux:input type="number" wire:model="form.service_attitude_score" label="服务态度评分" min="1" max="5" placeholder="1-5分" /></div>
            <div><flux:input type="number" wire:model="form.response_speed_score" label="响应速度评分" min="1" max="5" placeholder="1-5分" /></div>
            <div><flux:input type="number" wire:model="form.technical_level_score" label="技术水平评分" min="1" max="5" placeholder="1-5分" /></div>
            <div>
                <flux:select wire:model="form.status" label="状态" required>
                    <option value="0">待回访</option>
                    <option value="1">已完成</option>
                </flux:select>
            </div>
        </div>
        <div><flux:textarea wire:model="form.overall_evaluation" label="总体评价" rows="3" /></div>
        <div><flux:textarea wire:model="form.improvement_suggestions" label="改进建议" rows="2" /></div>
        <div><flux:textarea wire:model="form.remark" label="备注" rows="2" /></div>
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">{{ $isEditing ? '保存修改' : '创建回访' }}</flux:button>
            <flux:button variant="ghost" :href="route('satisfaction.surveys.index')" wire:navigate>取消</flux:button>
        </div>
    </form>
</div>

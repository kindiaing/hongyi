<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 创建角色
        $roles = [
            ['name' => 'super_admin', 'display_name' => '系统超级管理员'],
            ['name' => 'admin', 'display_name' => '系统管理员'],
            ['name' => 'project_manager', 'display_name' => '项目经理'],
            ['name' => 'vendor_admin', 'display_name' => '运维单位管理员'],
            ['name' => 'vendor_staff', 'display_name' => '运维单位人员'],
            ['name' => 'service_unit', 'display_name' => '服务单位'],
            ['name' => 'viewer', 'display_name' => '访客'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name'], 'guard_name' => 'web'], $role);
        }

        // 创建权限 - 按模块分组，覆盖全部功能
        $permissions = [
            // 合同管理
            ['name' => 'contract.view', 'display_name' => '查看合同', 'group' => '合同管理'],
            ['name' => 'contract.create', 'display_name' => '创建合同', 'group' => '合同管理'],
            ['name' => 'contract.edit', 'display_name' => '编辑合同', 'group' => '合同管理'],
            ['name' => 'contract.delete', 'display_name' => '删除合同', 'group' => '合同管理'],
            ['name' => 'contract.attachment', 'display_name' => '管理合同附件', 'group' => '合同管理'],

            // 资产管理 - 硬件设备
            ['name' => 'device.view', 'display_name' => '查看设备', 'group' => '资产管理-硬件'],
            ['name' => 'device.create', 'display_name' => '创建设备', 'group' => '资产管理-硬件'],
            ['name' => 'device.edit', 'display_name' => '编辑设备', 'group' => '资产管理-硬件'],
            ['name' => 'device.delete', 'display_name' => '删除设备', 'group' => '资产管理-硬件'],

            // 资产管理 - 软件系统
            ['name' => 'software.view', 'display_name' => '查看软件', 'group' => '资产管理-软件'],
            ['name' => 'software.create', 'display_name' => '创建软件', 'group' => '资产管理-软件'],
            ['name' => 'software.edit', 'display_name' => '编辑软件', 'group' => '资产管理-软件'],
            ['name' => 'software.delete', 'display_name' => '删除软件', 'group' => '资产管理-软件'],

            // 运维管理 - 运维单位
            ['name' => 'vendor.view', 'display_name' => '查看运维单位', 'group' => '运维管理-单位'],
            ['name' => 'vendor.create', 'display_name' => '创建运维单位', 'group' => '运维管理-单位'],
            ['name' => 'vendor.edit', 'display_name' => '编辑运维单位', 'group' => '运维管理-单位'],
            ['name' => 'vendor.delete', 'display_name' => '删除运维单位', 'group' => '运维管理-单位'],

            // 运维管理 - 人员
            ['name' => 'personnel.view', 'display_name' => '查看人员', 'group' => '运维管理-人员'],
            ['name' => 'personnel.create', 'display_name' => '创建人员', 'group' => '运维管理-人员'],
            ['name' => 'personnel.edit', 'display_name' => '编辑人员', 'group' => '运维管理-人员'],
            ['name' => 'personnel.delete', 'display_name' => '删除人员', 'group' => '运维管理-人员'],

            // 运维管理 - 服务单位
            ['name' => 'service_unit.view', 'display_name' => '查看服务单位', 'group' => '运维管理-服务单位'],
            ['name' => 'service_unit.create', 'display_name' => '创建服务单位', 'group' => '运维管理-服务单位'],
            ['name' => 'service_unit.edit', 'display_name' => '编辑服务单位', 'group' => '运维管理-服务单位'],
            ['name' => 'service_unit.delete', 'display_name' => '删除服务单位', 'group' => '运维管理-服务单位'],

            // 巡检任务
            ['name' => 'inspection.view', 'display_name' => '查看巡检任务', 'group' => '巡检任务'],
            ['name' => 'inspection.create', 'display_name' => '创建巡检任务', 'group' => '巡检任务'],
            ['name' => 'inspection.execute', 'display_name' => '执行巡检任务', 'group' => '巡检任务'],
            ['name' => 'inspection.audit', 'display_name' => '审核巡检任务', 'group' => '巡检任务'],
            ['name' => 'inspection.delete', 'display_name' => '删除巡检任务', 'group' => '巡检任务'],

            // 巡检计划
            ['name' => 'inspection_plan.view', 'display_name' => '查看巡检计划', 'group' => '巡检计划'],
            ['name' => 'inspection_plan.create', 'display_name' => '创建巡检计划', 'group' => '巡检计划'],
            ['name' => 'inspection_plan.edit', 'display_name' => '编辑巡检计划', 'group' => '巡检计划'],
            ['name' => 'inspection_plan.delete', 'display_name' => '删除巡检计划', 'group' => '巡检计划'],

            // 排班管理
            ['name' => 'schedule.view', 'display_name' => '查看排班', 'group' => '排班管理'],
            ['name' => 'schedule.create', 'display_name' => '创建排班', 'group' => '排班管理'],
            ['name' => 'schedule.edit', 'display_name' => '编辑排班', 'group' => '排班管理'],
            ['name' => 'schedule.delete', 'display_name' => '删除排班', 'group' => '排班管理'],

            // 回访管理
            ['name' => 'satisfaction.view', 'display_name' => '查看回访记录', 'group' => '回访管理'],
            ['name' => 'satisfaction.create', 'display_name' => '创建回访记录', 'group' => '回访管理'],
            ['name' => 'satisfaction.edit', 'display_name' => '编辑回访记录', 'group' => '回访管理'],
            ['name' => 'satisfaction.delete', 'display_name' => '删除回访记录', 'group' => '回访管理'],

            // 回访计划
            ['name' => 'satisfaction_plan.view', 'display_name' => '查看回访计划', 'group' => '回访计划'],
            ['name' => 'satisfaction_plan.create', 'display_name' => '创建回访计划', 'group' => '回访计划'],
            ['name' => 'satisfaction_plan.edit', 'display_name' => '编辑回访计划', 'group' => '回访计划'],
            ['name' => 'satisfaction_plan.delete', 'display_name' => '删除回访计划', 'group' => '回访计划'],

            // 系统管理 - 用户
            ['name' => 'system.user.view', 'display_name' => '查看用户', 'group' => '系统管理-用户'],
            ['name' => 'system.user.create', 'display_name' => '创建用户', 'group' => '系统管理-用户'],
            ['name' => 'system.user.edit', 'display_name' => '编辑用户', 'group' => '系统管理-用户'],
            ['name' => 'system.user.delete', 'display_name' => '删除用户', 'group' => '系统管理-用户'],

            // 系统管理 - 角色
            ['name' => 'system.role.view', 'display_name' => '查看角色', 'group' => '系统管理-角色'],
            ['name' => 'system.role.edit', 'display_name' => '配置角色权限', 'group' => '系统管理-角色'],

            // 系统管理 - 日志
            ['name' => 'system.log.view', 'display_name' => '查看操作日志', 'group' => '系统管理-日志'],

            // 系统管理 - 数据字典
            ['name' => 'system.dictionary.view', 'display_name' => '查看数据字典', 'group' => '系统管理-数据字典'],
            ['name' => 'system.dictionary.create', 'display_name' => '创建数据字典', 'group' => '系统管理-数据字典'],
            ['name' => 'system.dictionary.edit', 'display_name' => '编辑数据字典', 'group' => '系统管理-数据字典'],
            ['name' => 'system.dictionary.delete', 'display_name' => '删除数据字典', 'group' => '系统管理-数据字典'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name'], 'guard_name' => 'web'], $permission);
        }

        // 分配权限给角色
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::findByName('admin');
        $admin->syncPermissions([
            'contract.view', 'contract.create', 'contract.edit',
            'device.view', 'device.create', 'device.edit',
            'software.view', 'software.create', 'software.edit',
            'vendor.view', 'vendor.create', 'vendor.edit',
            'personnel.view', 'personnel.create', 'personnel.edit',
            'service_unit.view', 'service_unit.create', 'service_unit.edit',
            'inspection.view', 'inspection.create', 'inspection.audit',
            'inspection_plan.view', 'inspection_plan.create', 'inspection_plan.edit',
            'schedule.view', 'schedule.create', 'schedule.edit',
            'satisfaction.view', 'satisfaction.create', 'satisfaction.edit',
            'satisfaction_plan.view', 'satisfaction_plan.create', 'satisfaction_plan.edit',
            'system.user.view', 'system.user.create', 'system.user.edit',
            'system.role.view', 'system.role.edit',
            'system.log.view',
            'system.dictionary.view', 'system.dictionary.create', 'system.dictionary.edit',
        ]);

        $projectManager = Role::findByName('project_manager');
        $projectManager->syncPermissions([
            'contract.view', 'contract.create', 'contract.edit', 'contract.attachment',
            'device.view', 'device.create', 'device.edit',
            'software.view', 'software.create', 'software.edit',
            'vendor.view',
            'personnel.view', 'personnel.create', 'personnel.edit',
            'service_unit.view', 'service_unit.create', 'service_unit.edit',
            'inspection.view', 'inspection.create', 'inspection.execute', 'inspection.audit',
            'inspection_plan.view', 'inspection_plan.create', 'inspection_plan.edit',
            'schedule.view', 'schedule.create', 'schedule.edit',
            'satisfaction.view', 'satisfaction.create', 'satisfaction.edit',
            'satisfaction_plan.view', 'satisfaction_plan.create', 'satisfaction_plan.edit',
        ]);

        $vendorAdmin = Role::findByName('vendor_admin');
        $vendorAdmin->syncPermissions([
            'contract.view',
            'device.view', 'device.create', 'device.edit',
            'software.view', 'software.create', 'software.edit',
            'personnel.view', 'personnel.create', 'personnel.edit',
            'service_unit.view',
            'inspection.view', 'inspection.create', 'inspection.execute',
            'schedule.view', 'schedule.create', 'schedule.edit',
        ]);

        $vendorStaff = Role::findByName('vendor_staff');
        $vendorStaff->syncPermissions([
            'contract.view',
            'device.view',
            'software.view',
            'inspection.view', 'inspection.execute',
            'schedule.view',
        ]);

        $serviceUnit = Role::findByName('service_unit');
        $serviceUnit->syncPermissions([
            'satisfaction.view',
        ]);

        $viewer = Role::findByName('viewer');
        $viewer->syncPermissions([
            'contract.view',
            'device.view',
            'software.view',
            'vendor.view',
            'personnel.view',
            'service_unit.view',
            'inspection.view',
            'inspection_plan.view',
            'schedule.view',
            'satisfaction.view',
            'satisfaction_plan.view',
        ]);
    }
}

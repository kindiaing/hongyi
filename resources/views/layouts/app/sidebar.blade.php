<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group heading="工作台" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        仪表盘
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="合同管理" class="grid">
                    <flux:sidebar.item icon="document-text" :href="route('contracts.main.index')" :current="request()->routeIs('contracts.main.*')" wire:navigate>
                        主合同
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-duplicate" :href="route('contracts.sub.index')" :current="request()->routeIs('contracts.sub.*')" wire:navigate>
                        分包合同
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="资产管理" class="grid">
                    <flux:sidebar.item icon="server" :href="route('assets.hardware.index')" :current="request()->routeIs('assets.hardware.*')" wire:navigate>
                        硬件设备
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="code-bracket" :href="route('assets.software.index')" :current="request()->routeIs('assets.software.*')" wire:navigate>
                        软件系统
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="运维管理" class="grid">
                    <flux:sidebar.item icon="building-storefront" :href="route('service-units.index')" :current="request()->routeIs('service-units.*')" wire:navigate>
                        服务单位
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="building-office" :href="route('vendors.index')" :current="request()->routeIs('vendors.*')" wire:navigate>
                        运维单位
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('personnel.index')" :current="request()->routeIs('personnel.*')" wire:navigate>
                        人员管理
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="巡检/回访" class="grid">
                    <flux:sidebar.item icon="clipboard-document-check" :href="route('inspection.tasks.index')" :current="request()->routeIs('inspection.tasks.*')" wire:navigate>
                        任务管理
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar-days" :href="route('inspection.plans.index')" :current="request()->routeIs('inspection.plans.*')" wire:navigate>
                        巡检计划
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clock" :href="route('inspection.schedules.index')" :current="request()->routeIs('inspection.schedules.*')" wire:navigate>
                        排班管理
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="heart" :href="route('satisfaction.surveys.index')" :current="request()->routeIs('satisfaction.surveys.*')" wire:navigate>
                        回访管理
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('satisfaction.plans.index')" :current="request()->routeIs('satisfaction.plans.*')" wire:navigate>
                        回访计划
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="系统管理" class="grid">
                    <flux:sidebar.item icon="book-open" :href="route('system.dictionaries.index')" :current="request()->routeIs('system.dictionaries.*')" wire:navigate>
                        数据字典
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-group" :href="route('system.users.index')" :current="request()->routeIs('system.users.*')" wire:navigate>
                        用户管理
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="shield-check" :href="route('system.roles.index')" :current="request()->routeIs('system.roles.*')" wire:navigate>
                        角色权限
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-magnifying-glass" :href="route('system.logs.index')" :current="request()->routeIs('system.logs.*')" wire:navigate>
                        操作日志
                    </flux:sidebar.item>
                    {{-- <flux:sidebar.item icon="adjustments-horizontal" :href="route('system.audit_configs.index')" :current="request()->routeIs('system.audit_configs.*')" wire:navigate>
                        审计配置
                    </flux:sidebar.item> --}}
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="cog-6-tooth" :href="route('profile.edit')" :current="request()->routeIs('profile.*')" wire:navigate>
                    设置
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>

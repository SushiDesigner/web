<x-app-layout :title="__('Admin Panel')">
    <div class="container">
        <div class="rounded-2 bg-lightish px-3 py-2 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                </ol>
            </nav>
        </div>

        {{-- Allowed colors are 'primary', 'secondary', 'success', 'danger', and 'warning'. --}}

        <x-admin::panel.row :title="__('User Moderation')">
            @may (Users::roleset(), Users::MODERATION_VIEW_USER_PROFILE)
                <x-admin::panel.item color="primary" icon="fa-address-card" :link="route('admin.user.profile')" :action="__('User Profile')" />
            @endmay

            @may (Users::roleset(), Users::MODERATION_GENERAL_BAN)
                <x-admin::panel.item color="danger" icon="fa-ban" :link="route('admin.ban')" :action="__('Ban User')" />
            @endmay

            @may (Users::roleset(), Users::MODERATION_IP_ADDRESS_BAN)
                <x-admin::panel.item color="success" icon="fa-network-wired" :link="route('admin.ban.ip')" :action="__('IP Ban')" />
            @endmay
        </x-admin::panel.row>

        <x-admin::panel.row :title="__('Forum')">
            @may (Forums::roleset(), Forums::MANAGE_CATEGORIES)
                <x-admin::panel.item color="primary" icon="fa-list" :link="route('admin')" :action="__('Manage Categories')" />
            @endmay

            @may (Forums::roleset(), Forums::GLOBAL_PRUNE_USER_POSTS)
                <x-admin::panel.item color="danger" icon="fa-trash-can" :link="route('admin')" :action="__('Prune Posts')" />
            @endmay
        </x-admin::panel.row>

        <x-admin::panel.row :title="__('Game Server Management')">
            @may (GameServers::roleset(), GameServers::CREATE)
                <x-admin::panel.item color="primary" icon="fa-plug" :link="route('admin.game-server.create')" :action="__('Create Game Server')" />
            @endmay

            @may (GameServers::roleset(), GameServers::VIEW)
                <x-admin::panel.item color="secondary" icon="fa-server" :link="route('admin.game-server.all')" :action="__('Game Server List')" />
            @endmay
        </x-admin::panel.row>

        @if ($user->isSuperAdmin())
            <x-admin::panel.row :title="__('Superadmin Tools')">
                <x-admin::panel.item color="info" icon="fa-wrench" :link="route('admin.permissions')" :action="__('Modify User Permissions')" />
                <x-admin::panel.item color="danger" icon="fa-megaphone" :link="route('admin.alert')" :action="__('Create Site Alert')" />
                <x-admin::panel.item color="secondary" icon="fa-list-timeline" :link="route('admin.action-log')" :action="__('View Action Log')" />

                @if (!app()->environment('production'))
                    @if (config('telescope.enabled'))
                        <x-admin::panel.item color="telescope" photo="{{ asset('img/laravel/telescope.png') }}" :link="url('/admin/telescope')" :action="__('Telescope')" />
                    @endif

                    @if (env('HORIZON_ENABLED', false))
                        <x-admin::panel.item color="horizon" photo="{{ asset('img/laravel/horizon.png') }}" :link="url('/admin/horizon')" :action="__('Horizon')" />
                    @endif
                @endif
            </x-admin::panel.row>
        @endif
    </div>
</x-app-layout>

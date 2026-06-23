<?php


return [
    'sidebar' => [
        [
            'heading' => 'Dashboards',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active_pattern' => ['/', 'dashboard*'],
                    'icon' => '<svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>',
                ],
            ],
        ],
        [
            'heading' => 'Identity & Access',
            'icon' => '<svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>',
            'items' => [
                [
                    'label' => 'Users',
                    'route' => 'users.index',
                    'active_pattern' => ['users', 'users/*'],
                    'icon' => '<svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-6.338 0 3.375 3.375 0 016.338 0z" /></svg>',
                ],
                [
                    'label' => 'Access Control',
                    'route' => 'access-control.index',
                    'active_pattern' => ['roles', 'roles/*'],
                    'icon' => '<svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>',
                ],
            ],
        ],
        [
            'heading' => 'Settings',
            'items' => [
                [
                    'label' => 'Theme',
                    'route' => 'settings.theme.index',
                    'active_pattern' => 'settings/theme*',
                    'icon' => '<svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11M19 7h2" /><circle cx="16" cy="7" r="2" class="stroke-current" fill="currentColor" fill-opacity="0.2" stroke-width="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 17h3M11 17h10" /><circle cx="8" cy="17" r="2" class="stroke-current" fill="currentColor" fill-opacity="0.2" stroke-width="1.5"/></svg>',
                ],
            ],
        ],
    ],
];
<?php

return [
    'users' => [
        'title' => 'User Management',
        'heading' => 'User Management',
        'sub_heading' => 'Manage, provision, and review user profiles.',
        'empty_limits_msg' => 'No users match your filter query limits.',

        'view' => [
            'title' => 'User Profile',
            'heading' => 'User profile',
            'sub_heading' => 'Modify user vriables and passwords.',
        ],

        'create' => [
            'title' => 'Create User',
            'heading' => 'Create User Profile',
            'sub_heading' => 'Register a new user and deploy access authorizations.',
        ],
        'edit' => [
            'title' => 'Modify User',
            'heading' => 'Update User Profile',
            'sub_heading' => 'Modify user variables and account designations.',
        ],
    ],
    'access_control' => [
        'title' => 'Access Control',
        'heading' => 'Access Control Management',
        'sub_heading' => 'Manage system roles, configure resource permissions, and assign direct user overrides.',
    ],
    'errors' => [
        '403' => [
            'title' => '403 - Access Denied',
            'heading' => 'Access Denined',
            'sub_heading' => 'Your account does not have the necessary permissions to access this resource or perform this action.',
        ],
        '404' => [
            'title' => '404 - Page Not Found',
            'heading' => 'Page Not Found',
            'sub_heading' => 'Resource you are looking up cannot be resolved or has shifted positions permanently.',
        ],
    ],
];

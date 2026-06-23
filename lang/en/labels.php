<?php

return [
    'global' => [
        'language' => 'Language',
        'select_language' => 'Select Language',
        'confirm_title' => 'Confirm Action',
        'confirm_message' => 'Are you sure you want to proceed with this operation?',
        'confirm_btn' => 'Confirm',
        'cancel_btn' => 'Cancel',
        'created_at' => 'Date created at',
        'updated_at' => 'Date modified at',
    ],
    'login' => [
        'email' => 'Email Address',
        'email_placeholder' => 'name@domain.com',
        'password' => 'Security Password',
        'password_placeholder' => '••••••••••••',
        'remember_me' => 'Remember access token',
        'submit' => 'Authenticate Account',
        'processing' => 'Processing Authentication...',
        'logout' => 'Log Out',
    ],
    'users' => [
        'role' => 'Role',
        'no_role' => 'Role not assigned',
        'created_at' => 'Created At',
        'delete_title' => 'Remove Account',
        'delete_message' => 'This operation wipes this account immediately. Proceed?',
        'delete_confirm' => 'Purge Account',

        'view' => [
            'name' => 'Name',
            'email' => 'Email Address',
            'role' => 'Account Role',
        ],

        'create' => [
            'name' => 'Name',
            'email' => 'Email Address',
            'role' => 'Account Role',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
        ],
    ],
    'access_control' => [
        'unsaved_changes_title'   => 'Unsaved Overrides',
        'unsaved_changes_message' => 'You have unsaved permission modifications. Are you sure you want to change tabs and discard these overrides?',
        'unsaved_changes_confirm' => 'Discard Changes',

        'tabs' => [
            'roles_matrix' => 'Roles & Permissions',
            'user_overrides' => 'User Overrides'
        ],
        'roles' => [
            'create_title' => 'Create New Role',
            'name' => 'Role Key',
            'display_name' => 'Display Label',
            'description' => 'Description',
            'list_heading' => 'Available Roles',
            'perms_count' => 'perms',
            'no_description' => 'No description provided.'
        ],
        'matrix' => [
            'heading' => 'Permissions for',
            'empty_state' => 'Select a system role from the sidebar list to modify its authorized access permissions.'
        ],
        'users' => [
            'search_title' => 'Find User Profile',
            'empty_search' => 'No users loaded. Search above to find a specific user.',
            'edit_heading' => 'Manage Access Details for',
            'override_instructions' => 'Set permissions to Allow (grant explicitly) or Block (deny access regardless of assigned roles).',
            'roles_assignment' => '1. Assigned System Roles',
            'perms_assignment' => '2. Direct Permission Overrides (Independent of Role)',
            'empty_state' => 'Select a user profile from the sidebar to configure individual role assignments or manual permission overrides.'
        ],
        'states' => [
            'inherit' => 'Inherit',
            'allow' => 'Allow',
            'block' => 'Block'
        ],
    ]
];

<?php

return [

    /*
     * Laravel-admin name.
     */
    'name' => 'Laravel-admin',

    /*
     * Logo in admin panel header.
     */
    'logo' => '<b>Laravel</b> admin',

    /*
     * Mini-logo in admin panel header.
     */
    'logo-mini' => '<b>La</b>',

    /*
     * Laravel-admin url prefix.
     */
    'prefix' => 'admin',

    /*
     * Laravel-admin install directory.
     */
    'directory' => app_path('Admin'),

    /*
     * Laravel-admin html title.
     */
    'title' => 'Admin',

    /*
     * Laravel-admin auth setting.
     */
    'auth' => [
        'driver' => 'session',
        'provider' => '',
        'model' => Kizi\Admin\Auth\Database\Administrator::class,
    ],

    /*
     * Laravel-admin upload setting.
     */
    'upload' => [

        'disk' => 'admin',

        'directory' => [
            'image' => 'image',
            'file' => 'file',
        ],

        'host' => 'http://localhost:8000/upload/',
    ],

    /*
     * Laravel-admin database setting.
     */
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'user',
        'users_model' => Kizi\Admin\Auth\Database\Administrator::class,

        // Role table and model.
        'roles_table' => 'role',
        'roles_model' => Kizi\Admin\Auth\Database\Role::class,

        // Permission table and model.
        'permissions_table' => 'permission',
        'permissions_model' => Kizi\Admin\Auth\Database\Permission::class,

        // Menu table and model.
        'menu_table' => 'menu',
        'menu_model' => Kizi\Admin\Auth\Database\Menu::class,

        // Crawler table and model.
        'crawler_table' => 'crawler',
        'crawler_model' => Kizi\Admin\Auth\Database\Crawler::class,

        // Category News table and model.
        'category_news_table' => 'category_news',
        'category_news_model' => Kizi\Admin\Auth\Database\CategoryNews::class,

        // News table and model.
        'news_table' => 'news',
        'news_model' => Kizi\Admin\Auth\Database\News::class,

        // Batch Schedule table and model.
        'batch_schedule_table' => 'batch_schedule',
        'batch_schedule_model' => Kizi\Admin\Auth\Database\BatchSchedule::class,

        // Pivot table for table above.
        'operation_log_table' => 'operation_log',
        'user_permissions_table' => 'user_permissions',
        'role_users_table' => 'role_users',
        'role_permissions_table' => 'role_permissions',
        'role_menu_table' => 'role_menu',
    ],

    /*
     * By setting this option to open or close operation log in laravel-admin.
     */
    'operation_log' => true,

    /*
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
     */
    'skin' => 'skin-blue',

    /*
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
     */
    'layout' => ['sidebar-mini'],

    /*
     * Version displayed in footer.
     */
    'version' => '1.0',
];

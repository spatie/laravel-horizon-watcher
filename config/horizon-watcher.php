<?php

return [
    /*
     * Horizon will be restarted when any PHP file
     * inside these directories get created,
     * updated or deleted
     */

    'paths' => [
        app_path(),
        resource_path('views'),
    ],

    /*
     * This command will be executed to start Horizon
     */
    'command' => 'php artisan horizon',
];

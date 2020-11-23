<?php

declare(strict_types=1);

return [
    'enabled' => env('SECURITY_ENABLED', false),
    'operators' => [
        LiquidCats\Ruler\Operators\Getters\GetUserId::class,
        LiquidCats\Ruler\Operators\Getters\GetKey::class,
    ],
    'resolvers' => [
        LiquidCats\Ruler\Context\Resolvers\UserIdResolver::class,
    ],
    'permissions' => [
        'resource_name' => [
            'action_name' => [
                [
                    'rules' => [
                        'rule1',
                        'rule2',
                        'rule3',
                    ],
                    'decision' => 0,
                ],
                [
                    'rules' => [
                        'rule1',
                        'rule2',
                        'rule3',
                    ],
                    'decision' => 0,
                ],
            ],
        ],
    ],
];

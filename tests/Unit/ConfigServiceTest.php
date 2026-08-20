<?php

use App\Services\ConfigService;
use FeWeDev\Base\Arrays;

test(
    'Service can extract from a configuration array',
    function () {
        $configService = new ConfigService(new Arrays());

        $config = $configService->extractConfig(
            [
                'key-1' => 'value-1',
                'key-2' => 'value-2',
                'key-3' => [
                    0 => 'value-3',
                    1 => 'value-4',
                ],
                'section-1' => [
                    'key-1-1' => 'value-1-1',
                    'key-1-2' => 'value-1-2',
                    'key-1-3' => [
                        0 => 'value-1-3',
                        1 => 'value-1-4',
                    ]
                ],
                'section-2' => [
                    'key-2-1' => 'value-2-1',
                    'key-2-2' => 'value-2-2',
                    'subsection-2-1' => [
                        'key-2-1-1' => 'value-2-1-1',
                        'key-2-1-2' => 'value-2-1-2',
                    ],
                    'subsection-2-2' => [
                        'key-2-2-1' => 'value-2-2-1',
                    ]
                ]
            ],
            ['section-1', 'section-2']
        );

        expect($config)->toBeArray()->and($config)->toHaveCount(7)->and($config)->toMatchArray(
            [
                'key-1-1' => 'value-1-1',
                'key-1-2' => 'value-1-2',
                'key-1-3' => [
                    0 => 'value-1-3',
                    1 => 'value-1-4',
                ],
                'key-2-1' => 'value-2-1',
                'key-2-2' => 'value-2-2',
                'subsection-2-1' => [
                    'key-2-1-1' => 'value-2-1-1',
                    'key-2-1-2' => 'value-2-1-2',
                ],
                'subsection-2-2' => [
                    'key-2-2-1' => 'value-2-2-1',
                ]
            ]
        );
    }
);

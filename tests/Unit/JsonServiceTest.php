<?php

use App\Services\JsonService;
use FeWeDev\Base\Json;
use Illuminate\Console\OutputStyle;
use PHPUnit\Framework\Assert;

test(
    'Service can load a JSON config file',
    function () {
        try {
            $output = Mockery::mock(OutputStyle::class);
        } catch (Throwable $exception) {
            Assert::fail($exception->getMessage());
        }

        $jsonService = new JsonService(new Json());

        $output->expects('writeln');
        $config = $jsonService->load($output, 'tests/test.json');

        expect($config)->toBeArray()->and($config)->toHaveCount(5)->and($config)->toMatchArray(
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
            ]
        );
    }
);

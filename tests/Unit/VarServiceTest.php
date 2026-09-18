<?php

use App\Services\VarService;
use FeWeDev\Base\Arrays;
use FeWeDev\Base\Json;
use FeWeDev\Base\Variables;
use Illuminate\Console\OutputStyle;
use PHPUnit\Framework\Assert;

test(
    'Service can prepare an ENV file from a configuration array',
    function () {
        try {
            $output = Mockery::mock(OutputStyle::class);
        } catch (Throwable $exception) {
            Assert::fail($exception->getMessage());
        }

        $varService = new VarService(new Arrays(), new Variables(), new Json());

        $result = $varService->getOutput(
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

        expect($result)->toBeString()->and($result)->toEqual(
            'key_1=value-1
key_2=value-2
key_3=()
key_3+=("value-3")
key_3+=("value-4")
section_1="{"key-1-1":"value-1-1","key-1-2":"value-1-2","key-1-3":["value-1-3","value-1-4"]}"
section_2="{"key-2-1":"value-2-1","key-2-2":"value-2-2","subsection-2-1":{"key-2-1-1":"value-2-1-1","key-2-1-2":"value-2-1-2"},"subsection-2-2":{"key-2-2-1":"value-2-2-1"}}"'
        );

        $output->expects('writeln');
        $varService->output(
            $output,
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

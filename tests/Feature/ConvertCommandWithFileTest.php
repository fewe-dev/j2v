<?php

it(
    'convert command with file',
    function () {
        $this->artisan(implode(' ', ['convert', '--file tests/test.json']))->assertSuccessful()->expectsOutput(
            'key_1=value-1
key_2=value-2
key_3+=()
key_3+=("value-3")
key_3+=("value-4")
section_1="{"key-1-1":"value-1-1","key-1-2":"value-1-2","key-1-3":["value-1-3","value-1-4"]}"
section_2="{"key-2-1":"value-2-1","key-2-2":"value-2-2","subsection-2-1":{"key-2-1-1":"value-2-1-1","key-2-1-2":"value-2-1-2"},"subsection-2-2":{"key-2-2-1":"value-2-2-1"}}"'
        );
    }
);

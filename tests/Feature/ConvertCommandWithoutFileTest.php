<?php

it(
    'convert command without file',
    function () {
        $this->artisan('convert')->assertExitCode(1);
    }
);

<?php

namespace App\Commands;

use App\Services\ConfigService;
use App\Services\JsonService;
use App\Services\VarService;
use FeWeDev\Base\Variables;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class ConvertCommand extends BaseCommand
{
    public function __construct(
        Variables $variables,
        protected JsonService $jsonService,
        protected ConfigService $configService,
        protected VarService $varService
    ) {
        parent::__construct($variables);
    }

    protected function getCommandName(): string
    {
        return 'convert';
    }

    protected function getCommandDescription(): string
    {
        return 'Convert a JSON file to a VAR file.';
    }

    protected function getCommandParameters(): array
    {
        return [
            $this->prepareInputOption(
                'file',
                'The JSON configuration file.',
                false
            ),
            $this->prepareInputOption(
                'key',
                'The key to extract from the JSON file. Can be repeated multiple times to extract multiple keys.',
                true
            ),
            $this->prepareInputOption(
                'output',
                'The generated VAR file.',
                false
            ),
        ];
    }

    protected function executeCommand(): int
    {
        $file = $this->getRequiredOption('file', 'No file to process specified!');

        $config = $this->jsonService->load($this->getOutput(), $file);

        $keys = $this->getOptionList('key');

        $config = $this->configService->extractConfig($config, $keys);

        $output = $this->getOption('output');

        if (null === $output) {
            $this->varService->output($this->getOutput(), $config);
        } else {
            $this->varService->save($this->getOutput(), $output, $config);
        }

        return self::SUCCESS;
    }
}

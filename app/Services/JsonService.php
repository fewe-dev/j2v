<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\JsonException;
use FeWeDev\Base\Json;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class JsonService
{
    public function __construct(protected Json $json) {}

    /**
     * @return array<mixed>
     */
    public function load(OutputStyle $output, string $file): array
    {
        $output->writeln(sprintf('Processing file: %s', $file), OutputInterface::VERBOSITY_VERBOSE);

        if (!file_exists($file)) {
            throw new JsonException(sprintf('File not found: %s', $file));
        }

        $fileContent = file_get_contents($file);

        if (false === $fileContent) {
            throw new JsonException(sprintf('Could not read file: %s', $file));
        }

        $config = $this->json->decode($fileContent);

        return is_array($config) ? $config : [];
    }
}

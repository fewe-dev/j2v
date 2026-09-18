<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\VarException;
use FeWeDev\Base\Arrays;
use FeWeDev\Base\Json;
use FeWeDev\Base\Variables;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class VarService
{
    public function __construct(protected Arrays $arrays, protected Variables $variables, protected Json $json) {}

    /**
     * @param array<mixed> $config
     */
    public function output(OutputStyle $output, array $config): void
    {
        $output->writeln($this->getOutput($config));
    }

    /**
     * @param array<mixed> $config
     */
    public function save(OutputStyle $output, string $file, array $config): void
    {
        $output->writeln(sprintf('Saving file: %s', $file), OutputInterface::VERBOSITY_VERBOSE);

        if (!file_put_contents($file, $this->getOutput($config).PHP_EOL, LOCK_EX)) {
            throw new VarException(sprintf('Impossible to write to file %s', $file));
        }
    }

    /**
     * @param array<mixed> $config
     */
    public function getOutput(array $config): string
    {
        $output = '';

        foreach ($config as $key => $value) {
            $key = preg_replace('/[^\w\.]/', '_', $key);

            if (null !== $key) {
                if (is_array($value)) {
                    if ($this->arrays->isAssociative($value)) {
                        $value = $this->json->encode($value);

                        if (null !== $value) {
                            $output .= sprintf('%s=%s%s', $key, $this->quoteValue($value), PHP_EOL);
                        }
                    } else {
                        $output .= sprintf('%s=()%s', $key, PHP_EOL);

                        foreach ($value as $valueValue) {
                            $output .= sprintf(
                                '%s+=("%s")%s',
                                $key,
                                $this->quoteValue($this->variables->stringValue($valueValue)),
                                PHP_EOL
                            );
                        }
                    }
                } else {
                    $output .= sprintf(
                        '%s=%s%s',
                        $key,
                        $this->quoteValue($this->variables->stringValue($value)),
                        PHP_EOL
                    );
                }
            }
        }

        return trim($output);
    }

    private function quoteValue(string $value): string
    {
        if (preg_match('/[\n\!\$]/u', $value)) {
            return sprintf('\'%s\'', $value);
        }
        if (preg_match('/[\s"\=:.$()]/u', $value)) {
            return sprintf('"%s"', $value);
        }

        return $value;
    }
}

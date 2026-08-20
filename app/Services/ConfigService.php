<?php

declare(strict_types=1);

namespace App\Services;

use FeWeDev\Base\Arrays;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class ConfigService
{
    public function __construct(protected Arrays $arrays) {}

    /**
     * @param array<mixed>  $config
     * @param array<string> $keys
     *
     * @return array<mixed>
     */
    public function extractConfig(array $config, array $keys): array
    {
        if (0 === count($keys)) {
            return $config;
        }

        $result = [];

        foreach ($keys as $key) {
            $subConfig = $this->arrays->getValue($config, $key, []);

            if (is_array($subConfig)) {
                $result = $this->arrays->mergeArrays($result, $subConfig);
            }
        }

        return $result;
    }
}

<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Composer\Command\CustomRule;

use const DIRECTORY_SEPARATOR;
use function str_replace;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class RectorTemplateContentsProcessor extends AbstractRectorTemplateProcessor
{
    public function processTemplateContents(string $ruleName, SplFileInfo $fileInfo): string
    {
        $rectorName = $this->buildRectorName($ruleName);
        $relativeDirname = str_contains($rectorName, DIRECTORY_SEPARATOR) ? dirname($rectorName) : '';
        $className = basename($rectorName);

        return $this->replaceNameVariable(
            $className,
            $this->replaceNamespace($relativeDirname, $fileInfo->getContents())
        );
    }

    private function replaceNameVariable(string $rectorName, string $contents): string
    {
        return str_replace('__Name__', $rectorName, $contents);
    }

    private function replaceNamespace(string $relativeDirname, string $fileContents): string
    {
        $relativeNamespace = str_replace(DIRECTORY_SEPARATOR, '\\', $relativeDirname);
        if (!empty($relativeNamespace)) {
            $relativeNamespace = "\\$relativeNamespace";
        }

        return str_replace(
            ['Utils\Rector\Rector', 'Utils\Rector\Tests\Rector'],
            ['Ibexa\Rector\Rule' . $relativeNamespace, 'Ibexa\Rector\Tests\Rule' . $relativeNamespace],
            $fileContents
        );
    }
}

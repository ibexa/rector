<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Composer\Command\CustomRule;

use const DIRECTORY_SEPARATOR;
use LogicException;
use function str_replace;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @internal
 */
final class RectorTemplatePathProcessor extends AbstractRectorTemplateProcessor
{
    public function processPathName(string $ruleName, SplFileInfo $fileInfo): string
    {
        return $this->fixPath($this->replacePathVariables($ruleName, $fileInfo->getRelativePathname()));
    }

    public function resolveTemplateContents(string $ruleName, SplFileInfo $fileInfo): string
    {
        $rectorName = $this->buildRectorName($ruleName);
        $relativeDirname = str_contains($rectorName, DIRECTORY_SEPARATOR) ? dirname($rectorName) : '';
        $className = basename($rectorName);

        return $this->replaceNameVariable($className, $this->replaceNamespace($relativeDirname, $fileInfo->getContents()));
    }

    private function replaceNameVariable(string $rectorName, string $contents): string
    {
        return str_replace('__Name__', $rectorName, $contents);
    }

    private function replacePathVariables(string $ruleName, string $relativePathname): string
    {
        $rectorName = $this->buildRectorName($ruleName);
        $className = basename($rectorName);

        // workaround Rector's inability to process Rectors with more complex subdirectory structure
        return str_replace(
            ['__Name__Test.php', '__Name__.php', '__Name__/'],
            [$className . 'Test.php', $rectorName . '.php', $rectorName . '/'],
            $relativePathname
        );
    }

    private function fixPath(string $relativePathname): string
    {
        $fixedPath = preg_replace('@(src|tests)/Rector@', '$1/lib/Rule', $relativePathname);
        if ($fixedPath === null) {
            throw new LogicException("Failed to fix $relativePathname when generating output files");
        }

        return $fixedPath;
    }

    private function replaceNamespace(string $relativeDirname, string $fileContents): string
    {
        $relativeNamespace = str_replace(DIRECTORY_SEPARATOR, '\\', $relativeDirname);
        if (!empty($relativeNamespace)) {
            $relativeNamespace = "\\$relativeNamespace";
        }

        return str_replace('Utils\Rector\Rector', 'Ibexa\Rector\Rule' . $relativeNamespace, $fileContents);
    }
}

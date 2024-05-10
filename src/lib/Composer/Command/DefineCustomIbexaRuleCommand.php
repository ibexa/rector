<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rector\Composer\Command;

use Ibexa\Rector\Composer\Command\CustomRule\RectorTemplateContentsProcessor;
use Ibexa\Rector\Composer\Command\CustomRule\RectorTemplatePathProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * @internal use composer define-custom-rule instead
 */
final class DefineCustomIbexaRuleCommand extends Command
{
    protected static $defaultName = 'define-custom-rule';

    private RectorTemplatePathProcessor $pathNameProcessor;

    private RectorTemplateContentsProcessor $templateContentsProcessor;

    public function __construct()
    {
        parent::__construct();

        $this->pathNameProcessor = new RectorTemplatePathProcessor();
        $this->templateContentsProcessor = new RectorTemplateContentsProcessor();
    }

    protected function configure(): void
    {
        $this->addArgument('rule-name', InputArgument::REQUIRED, 'Rule name');
        $this->addOption(
            'template-dir',
            'd',
            InputOption::VALUE_OPTIONAL,
            'Rector template directory',
            dirname(__DIR__, 4) . '/vendor/rector/rector/templates/custom-rule/utils/rector'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $ruleName = $input->getArgument('rule-name');
        $templateDir = $input->getOption('template-dir');

        $io->info("Generating custom rule $ruleName...");

        $filesystem = new Filesystem();
        $finder = new Finder();
        $files = $finder->in($templateDir)->files();
        $listing = [];
        foreach ($files as $fileInfo) {
            $targetPathName = $this->pathNameProcessor->processPathName($ruleName, $fileInfo);
            $newContent = $this->templateContentsProcessor->processTemplateContents($ruleName, $fileInfo);
            $filesystem->dumpFile($targetPathName, $newContent);
            $listing[] = "Written <info>$targetPathName</info>";
        }
        $io->listing($listing);
        $io->success("Generated $ruleName Rector files");

        return self::SUCCESS;
    }
}

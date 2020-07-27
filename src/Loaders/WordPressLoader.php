<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;

final class WordPressLoader extends AbstractContainerLoader
{
    public const SECTION_NAME = 'WordPress';

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct(self::SECTION_NAME, $logger);
    }

    public function getChildren(): array
    {
        return [
            ThemeSettingsLoader::class => ThemeSettingsLoader::SECTION_NAME,
        ];
    }

    public function isLoaderSupported(): bool
    {
        return true;
    }
}

<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;

final class ThemeSettingsLoader extends AbstractContainerLoader
{
    public const SECTION_NAME = 'Theme Settings';

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct(self::SECTION_NAME, $logger);
    }

    public function getChildren(): array
    {
        return [
            MenuLoader::class => MenuLoader::SECTION_NAME,
            ImageThumbnailLoader::class => ImageThumbnailLoader::SECTION_NAME,
        ];
    }

    public function isLoaderSupported(): bool
    {
        return true;
    }
}

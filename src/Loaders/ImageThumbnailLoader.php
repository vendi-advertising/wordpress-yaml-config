<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;
use Vendi\WordPressYaml\Exceptions\InvalidLoaderDataException;
use Vendi\WordPressYaml\Models\ImageThumbnailModel;

final class ImageThumbnailLoader extends AbstractLoader
{
    public const SECTION_NAME = 'Image Sizes';

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct(self::SECTION_NAME, $logger);
    }

    /**
     * @param $data
     *
     * @return array|null
     * @throws InvalidLoaderDataException
     */
    public function buildModels($data): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $this->requireDataValuesToBeArray($data);

        $ret = [];

        foreach ($data as $fileName => $settings) {
            $ret[] = ImageThumbnailModel::fromArray($fileName, $settings);
        }

        return $ret;
    }

    public function processModels($models): void
    {
        $this->assertGlobalFunctionExists('add_action');
        assert(function_exists('add_action'));

        add_action(
            'after_setup_theme',
            function () use ($models) {

                $this->logThatHookWasCalled('after_setup_theme');
                $this->assertGlobalFunctionExists('fly_add_image_size');

                assert(function_exists('fly_add_image_size'));

                /** @var ImageThumbnailModel[] $models */

                foreach ($models as $imageThumbnailModel) {
                    fly_add_image_size(
                        $imageThumbnailModel->getName(),
                        $imageThumbnailModel->getWidth(),
                        $imageThumbnailModel->getHeight(),
                        $imageThumbnailModel->getCrop()
                    );
                }
            }
        );

    }

    public function isLoaderSupported(): bool
    {
        return function_exists('fly_add_image_size');
    }
}

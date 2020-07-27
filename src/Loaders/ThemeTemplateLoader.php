<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;
use Vendi\WordPressYaml\Exceptions\InvalidLoaderDataException;
use Vendi\WordPressYaml\Models\ThemeTemplateModel;

class ThemeTemplateLoader extends AbstractRequiredLoader
{
    public const SECTION_NAME = 'Templates';

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
        foreach ($data as $fileName => $templateData) {
            $ret[] = ThemeTemplateModel::fromArray($fileName, $templateData);
        }
        return $ret;
    }

    public function processModels($models): void
    {
        $this->assertGlobalFunctionExists('add_filter');

        // This is needed for PhpStorm
        assert(function_exists('add_filter'));

        add_filter(
            'theme_templates',
            function (array $page_templates, $theme, $post, string $post_type) use ($models) {

                $this->logThatHookWasCalled('theme_templates');

                /** @var ThemeTemplateModel[] $models */

                foreach ($models as $templateModel) {
                    if (in_array($post_type, $templateModel->getPostTypes(), true)) {
                        $page_templates[$templateModel->getFileName()] = $templateModel->getDisplayName();
                    }

                }
                return $page_templates;
            },
            1,
            4
        );

    }
}

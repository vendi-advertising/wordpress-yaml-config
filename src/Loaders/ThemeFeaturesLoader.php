<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;
use Vendi\WordPressYaml\Models\ThemeFeatureModel;

class ThemeFeaturesLoader extends AbstractRequiredLoader
{
    public const SECTION_NAME = 'Features';

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct(self::SECTION_NAME, $logger);
    }

    public function buildModels($data): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $ret = [];
        foreach ($data as $feature => $options) {
            $ret[] = new ThemeFeatureModel($feature, $options);
        }
        return $ret;
    }

    public function processModels(?array $models): void
    {
        assert(function_exists('add_action'));

        add_action(
            'after_setup_theme',
            function () use ($models) {

                $this->logThatHookWasCalled('after_setup_theme');
                $this->assertGlobalFunctionExists('add_theme_support');

                // This is needed for PhpStorm
                assert(function_exists('add_theme_support'));

                /** @var ThemeFeatureModel[] $models */

                foreach ($models as $feature) {
                    add_theme_support($feature->getFeatureName(), $feature->getArgs());
                }
            }
        );
    }
}

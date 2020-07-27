<?php

namespace Vendi\WordPressYaml\Loaders;

use Psr\Log\LoggerInterface;
use Vendi\WordPressYaml\Exceptions\InvalidLoaderDataException;
use Vendi\WordPressYaml\Models\MenuModel;

final class MenuLoader extends AbstractRequiredLoader
{
    public const SECTION_NAME = 'Menus';

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct(self::SECTION_NAME, $logger);
    }

    /**
     * @param $data
     *
     * @return MenuModel[]|null
     * @throws InvalidLoaderDataException
     */
    public function buildModels($data): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $this->requireDataValuesToBeStrings($data);

        $ret = [];

        foreach ($data as $location => $description) {
            $ret[] = new MenuModel($location, $description);
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
                $this->assertGlobalFunctionExists('register_nav_menu');

                assert(function_exists('register_nav_menu'));

                /** @var MenuModel[] $models */

                foreach ($models as $menu) {
                    register_nav_menu($menu->getLocation(), $menu->getDisplayName());
                }
            }
        );

    }
}

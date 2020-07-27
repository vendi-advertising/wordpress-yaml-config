<?php

namespace Vendi\WordPressYaml\Loaders;

abstract class AbstractRequiredLoader extends AbstractLoader
{
    final public function isLoaderSupported(): bool
    {
        return true;
    }
}

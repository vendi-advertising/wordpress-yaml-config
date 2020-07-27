<?php

namespace Vendi\WordPressYaml\Loaders;

use Vendi\WordPressYaml\Models\ModelInterface;

interface LoaderInterface
{
    public function getSectionName(): string;

    /**
     * @param $data
     *
     * @return ModelInterface[]|null
     */
    public function buildModels($data): ?array;

    /**
     * @param ModelInterface[]|null $models
     */
    public function processModels(?array $models): void;

    public function isLoaderSupported(): bool;
}

<?php

namespace Vendi\WordPressYaml\Loaders;

abstract class AbstractContainerLoader extends AbstractLoader
{
    abstract public function getChildren(): array;

    public function buildModels($data): ?array
    {
        return $data;
    }

    final public function processModels($models): void
    {
        foreach ($this->getChildren() as $className => $sectionName) {
            $this->getLogger()->debug('Processing section', ['section-name' => $sectionName, 'class-name' => $className]);
            if (!array_key_exists($sectionName, $models)) {
                $this->getLogger()->debug('Section not found in container, skipping', ['section-name' => $sectionName, 'class-name' => $className]);
                continue;
            }

            $this->getLogger()->debug('Testing if class exists', ['class-name' => $className, 'exists' => class_exists($className)]);
            assert(class_exists($className));

            $this->getLogger()->debug('Instantiating object', ['class-name' => $className]);
            $obj = new $className;

            $this->getLogger()->debug('Ensuring proper type', ['class-name' => $className, 'is-correct-type' => $obj instanceof LoaderInterface]);
            assert($obj instanceof LoaderInterface);

            $this->getLogger()->debug('Determining if loader is supported', ['class-name' => $className, 'supported' => $obj->isLoaderSupported()]);

            if (!$obj->isLoaderSupported()) {
                continue;
            }

            $this->getLogger()->debug('Calling buildModels on object', ['section-name' => $sectionName, 'class-name' => $className]);
            $childModels = $obj->buildModels($models[$sectionName]);

            $this->getLogger()->debug('Calling processModels on object', ['section-name' => $sectionName, 'class-name' => $className]);
            $obj->processModels($childModels);

        }
    }
}

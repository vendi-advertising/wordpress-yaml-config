<?php

namespace Vendi\WordPressYaml\Models;

class ThemeTemplateModel implements ModelInterface
{
    private string $fileName;

    private string $displayName;

    private array $postTypes;

    public function __construct(string $fileName, string $displayName, array $postTypes)
    {
        $this->fileName = $fileName;
        $this->displayName = $displayName;
        $this->postTypes = $postTypes;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getPostTypes(): array
    {
        return $this->postTypes;
    }

    public static function fromArray(string $fileName, $data): self
    {
        if (is_string($data)) {
            $data = [
                'name' => $data,
                'types' => [],
            ];
        }

        if (!array_key_exists('name', $data)) {
            $data['name'] = 'Name not set';
        }

        if (!array_key_exists('types', $data) || !is_array($data['types']) || 0 === count($data['types'])) {
            $data['types'] = ['page'];
        }

        return new self($fileName, $data['name'], $data['types']);
    }
}

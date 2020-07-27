<?php

namespace Vendi\WordPressYaml\Models;

class MenuModel implements ModelInterface
{
    private string $location;
    private string $displayName;

    public function __construct(string $location, string $displayName)
    {
        $this->location = $location;
        $this->displayName = $displayName;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}

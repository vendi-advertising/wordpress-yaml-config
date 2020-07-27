<?php

namespace Vendi\WordPressYaml\Models;

class ContainerModel implements ModelInterface
{
    private $data;

    public function __construct($data)
    {
    }

    public function getData()
    {
        return $this->data;
    }
}

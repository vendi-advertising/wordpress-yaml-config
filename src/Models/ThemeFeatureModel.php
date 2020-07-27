<?php

namespace Vendi\WordPressYaml\Models;

class ThemeFeatureModel implements ModelInterface
{
    private string $featureName;

    private $args;

    public function __construct(string $featureName, $args = null)
    {
        $this->featureName = $featureName;

        if (!$args) {
            $args = [true];
        } elseif (is_scalar($args)) {
            $args = [$args];
        }

        $this->args = $args;
    }

    public function getFeatureName(): string
    {
        return $this->featureName;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}

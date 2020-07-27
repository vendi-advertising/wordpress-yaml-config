<?php

namespace Vendi\WordPressYaml\Models;

class ImageThumbnailModel implements ModelInterface
{
    private string $name;
    private int $width;
    private int $height;
    private bool $crop;

    public function __construct(string $name, int $width, int $height, bool $crop)
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
    }

    public static function fromArray($fileName, $settings): self
    {
        $width = $settings['width'] ?? 0;
        $height = $settings['height'] ?? 0;
        $crop = $settings['crop'] ?? false;
        return new self($fileName, (int)$width, (int)$height, (bool)$crop);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getCrop(): bool
    {
        return $this->crop;
    }
}

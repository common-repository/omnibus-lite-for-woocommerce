<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations\Version;

final class Version
{
    /** @var string */
    private $version;
    public function __construct(string $version)
    {
        $this->version = $version;
    }
    public function __toString() : string
    {
        return $this->version;
    }
}

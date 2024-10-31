<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations;

interface Migrator
{
    public function migrate() : void;
}

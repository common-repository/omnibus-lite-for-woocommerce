<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations\Finder;

use OmnibusVendor\WPDesk\Migrations\AbstractMigration;
interface MigrationFinder
{
    /**
     * @param string $directory
     * @return class-string<AbstractMigration>[]
     */
    public function find_migrations(string $directory) : array;
}

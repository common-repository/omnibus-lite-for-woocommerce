<?php

namespace OmnibusVendor\WPDesk\Migrations\Version;

use OmnibusVendor\WPDesk\Migrations\AbstractMigration;
interface MigrationFactory
{
    public function create_version(string $migration_class) : AbstractMigration;
}

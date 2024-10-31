<?php

namespace OmnibusVendor\WPDesk\Migrations;

use OmnibusVendor\WPDesk\Migrations\Version\Version;
interface MigrationsRepository
{
    /** @return iterable<AvailableMigration> */
    public function get_migrations() : iterable;
    public function register_migration(string $migration_class_name) : void;
}

<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations;

class ArrayMigrationsRepository extends AbstractMigrationsRepository
{
    protected function load_migrations() : void
    {
        foreach ($this->migrations_source as $class) {
            $this->register_migration($class);
        }
    }
}

<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations\Version;

use Psr\Log\LoggerInterface;
use OmnibusVendor\WPDesk\Migrations\AbstractMigration;
class WpdbMigrationFactory implements MigrationFactory
{
    /** @var \wpdb */
    protected $wpdb;
    /** @var LoggerInterface */
    protected $logger;
    public function __construct(\wpdb $wpdb, LoggerInterface $logger)
    {
        $this->wpdb = $wpdb;
        $this->logger = $logger;
    }
    public function create_version(string $migration_class) : AbstractMigration
    {
        return new $migration_class($this->wpdb, $this->logger);
    }
}

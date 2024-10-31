<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations;

use Psr\Log\LoggerInterface;
abstract class AbstractMigration
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
    public abstract function up() : bool;
    public function down() : void
    {
    }
}

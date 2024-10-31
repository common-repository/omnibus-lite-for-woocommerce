<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations;

use Psr\Log\LoggerInterface;
use OmnibusVendor\WPDesk\Migrations\Finder\GlobFinder;
use OmnibusVendor\WPDesk\Migrations\Version\AlphabeticalComparator;
use OmnibusVendor\WPDesk\Migrations\Version\Comparator;
use OmnibusVendor\WPDesk\Migrations\Version\Version;
use OmnibusVendor\WPDesk\Migrations\Version\WpdbMigrationFactory;
class WpdbMigrator implements Migrator
{
    /** @var \wpdb */
    private $wpdb;
    /** @var MigrationsRepository */
    private $migrations_repository;
    /** @var Comparator */
    private $comparator;
    /** @var LoggerInterface */
    private $logger;
    /** @var string */
    private $option_name;
    /** @param string[] $migration_directories */
    public static function from_directories(array $migration_directories, string $option_name) : self
    {
        global $wpdb;
        $logger = new WpdbLogger($option_name . '_log');
        return new self($wpdb, $option_name, new FilesystemMigrationsRepository($migration_directories, new GlobFinder(), new WpdbMigrationFactory($wpdb, $logger), new AlphabeticalComparator()), new AlphabeticalComparator(), $logger);
    }
    /** @param class-string<AbstractMigration>[] $migration_class_names */
    public static function from_classes(array $migration_class_names, string $option_name) : self
    {
        global $wpdb;
        $logger = new WpdbLogger($option_name . '_log');
        return new self($wpdb, $option_name, new ArrayMigrationsRepository($migration_class_names, new WpdbMigrationFactory($wpdb, $logger), new AlphabeticalComparator()), new AlphabeticalComparator(), $logger);
    }
    public function __construct(\wpdb $wpdb, string $option_name, MigrationsRepository $migrations_repository, Comparator $comparator, LoggerInterface $logger)
    {
        $this->wpdb = $wpdb;
        $this->option_name = $option_name;
        $this->migrations_repository = $migrations_repository;
        $this->comparator = $comparator;
        $this->logger = $logger;
    }
    private function get_current_version() : Version
    {
        return new Version(get_option($this->option_name, ''));
    }
    public function migrate() : void
    {
        require_once \ABSPATH . 'wp-admin/includes/upgrade.php';
        $this->logger->info('DB update start');
        $current_version = $this->get_current_version();
        foreach ($this->migrations_repository->get_migrations() as $migration) {
            if ($this->comparator->compare($migration->get_version(), $this->get_current_version())) {
                $this->logger->info(\sprintf('DB update %s:%s', $current_version, $migration->get_version()));
                try {
                    $migration->get_migration()->up();
                    $this->logger->info(\sprintf('DB update %s:%s -> ', $current_version, $migration->get_version()) . 'OK');
                    update_option($this->option_name, (string) $migration->get_version(), \true);
                } catch (\Throwable $e) {
                    $error_msg = \sprintf('Error while upgrading a database: %s', $this->wpdb->last_error);
                    $this->logger->error($error_msg);
                    \trigger_error($error_msg, \E_USER_WARNING);
                }
            }
        }
        $this->logger->info('DB update finished');
    }
}

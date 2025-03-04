<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Migrations;

use Psr\Log\LoggerTrait;
class WpdbLogger implements \Psr\Log\LoggerInterface
{
    use LoggerTrait;
    private const MAX_LOG_SIZE = 30;
    /** @var string[] */
    private $log;
    /** @var string */
    private $log_name;
    public function __construct(string $log_name)
    {
        $this->log_name = $log_name;
        $this->log = \json_decode(get_option($this->log_name, '[]'));
        if (!\is_array($this->log)) {
            $this->log = [];
        }
    }
    public function log($level, $message, array $context = [])
    {
        $this->log[] = \date('Y-m-d G:i:s') . \sprintf(': %s', $message);
        if (\count($this->log) > self::MAX_LOG_SIZE) {
            \array_shift($this->log);
        }
        update_option($this->log_name, \json_encode($this->log), \false);
    }
}

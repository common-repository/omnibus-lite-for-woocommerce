<?php

declare (strict_types=1);
namespace OmnibusVendor\WPDesk\Logger;

use OmnibusVendor\Monolog\Handler\HandlerInterface;
use OmnibusVendor\Monolog\Handler\NullHandler;
use OmnibusVendor\Monolog\Logger;
use OmnibusVendor\Monolog\Handler\ErrorLogHandler;
use OmnibusVendor\WPDesk\Logger\WC\WooCommerceHandler;
final class SimpleLoggerFactory implements LoggerFactory
{
    /** @var Settings */
    private $options;
    /** @var string */
    private $channel;
    /** @var Logger */
    private $logger;
    public function __construct(string $channel, Settings $options = null)
    {
        $this->channel = $channel;
        $this->options = $options ?? new Settings();
    }
    public function getLogger($name = null) : Logger
    {
        if ($this->logger) {
            return $this->logger;
        }
        $logger = new Logger($this->channel);
        if ($this->options->use_wc_log && \function_exists('wc_get_logger')) {
            $logger->pushHandler(new WooCommerceHandler(\wc_get_logger(), $this->channel));
        }
        // Adding WooCommerce logger may have failed, if so add WP by default.
        if ($this->options->use_wp_log || empty($logger->getHandlers())) {
            $logger->pushHandler($this->get_wp_handler());
        }
        return $this->logger = $logger;
    }
    private function get_wp_handler() : HandlerInterface
    {
        if (\defined('WP_DEBUG_LOG') && \WP_DEBUG_LOG) {
            return new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, $this->options->level);
        }
        return new NullHandler();
    }
}

<?php

namespace OmnibusVendor\WPDesk\License;

use OmnibusVendor\WPDesk\License\ActivationForm\AjaxHandler;
use OmnibusVendor\WPDesk\License\ActivationForm\PluginsPageRenderer;
use OmnibusVendor\WPDesk\License\WpUpgrader\SubscriptionHandler;
use OmnibusVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use OmnibusVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use OmnibusVendor\WPDesk_API_Manager_With_Update_Flag;
use OmnibusVendor\WPDesk_Plugin_Info;
class LicenseManager implements HookableCollection
{
    use HookableParent;
    /**
     * @var WPDesk_Plugin_Info
     */
    private $plugin_info;
    /**
     * @var PluginsPageRenderer
     */
    private $plugins_page_renderer;
    /**
     * @var AjaxHandler
     */
    private $ajax_handler;
    /**
     * @param WPDesk_Plugin_Info $plugin_info
     */
    public function __construct(WPDesk_Plugin_Info $plugin_info)
    {
        $this->plugin_info = $plugin_info;
    }
    /**
     * @param bool $hooks_to_updates
     *
     * @return WPDesk_API_Manager_With_Update_Flag
     */
    public function create_api_manager(bool $hook_to_updates = \true) : WPDesk_API_Manager_With_Update_Flag
    {
        $address_repository = new ServerAddressRepository($this->plugin_info->get_product_id());
        return new WPDesk_API_Manager_With_Update_Flag($address_repository->get_default_update_url(), $this->plugin_info->get_version(), $this->plugin_info->get_plugin_file_name(), $this->plugin_info->get_product_id(), $this->plugin_info->get_plugin_file_name(), $this->plugin_info->get_plugin_slug(), $hook_to_updates, $this->plugin_info->get_plugin_name());
    }
    /**
     *
     */
    public function init_activation_form()
    {
        $this->plugins_page_renderer = new PluginsPageRenderer($this->plugin_info);
        $this->add_hookable($this->plugins_page_renderer);
        $this->ajax_handler = new AjaxHandler($this->plugin_info);
        $this->add_hookable($this->ajax_handler);
    }
    /**
     * .
     */
    public function init_wp_upgrader(bool $activated, $subscriptions_url)
    {
        $this->add_hookable(new SubscriptionHandler($this->plugin_info->get_plugin_file_name(), $activated, $subscriptions_url));
    }
    /**
     * .
     */
    public function hooks()
    {
        $this->hooks_on_hookable_objects();
    }
    /**
     * @return PluginsPageRenderer
     */
    public function get_plugins_page_renderer() : PluginsPageRenderer
    {
        return $this->plugins_page_renderer;
    }
    /**
     * @return AjaxHandler
     */
    public function get_ajax_handler() : AjaxHandler
    {
        return $this->ajax_handler;
    }
}

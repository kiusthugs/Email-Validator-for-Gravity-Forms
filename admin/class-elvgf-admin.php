<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/kiusthugs
 * @since      1.0.0
 *
 * @package    Elvgf
 * @subpackage Elvgf/admin
 */
class Elvgf_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name    The name of this plugin.
	 * @param    string    $version        The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', array($this, 'create_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
		
		//Settings link
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/elvgf-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/elvgf-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
 	* Create settings page for Email Validator Elvgf plugin.
 	*/
	public function create_settings_page() {
		add_options_page(
			'Email Validator Settings',
			'Email Validator',
			'manage_options',
			'elv-settings',
			array($this, 'render_settings_page')
		);
	}
	
	// Add a method to render the settings page content.
	public function render_settings_page() {
		?>
		<div class="wrap">
			<h2>Email Validator Settings</h2>
			<form method="post" action="options.php">
				<?php settings_fields('elv_settings_group'); ?> 
				<?php do_settings_sections('elv-settings'); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	// Add a method to register the settings and API key field.
	public function register_settings() {
		register_setting(
			'elv_settings_group',
			'elv_api_key'
		);

		add_settings_section(
			'elv_settings_section',
			'API Key Settings',
			array($this, 'settings_section_callback'),
			'elv-settings'
		);

		add_settings_field(
			'elv_api_key',
			'API Key',
			array($this, 'api_key_field_callback'),
			'elv-settings',
			'elv_settings_section'
		);
	}

	// Callback function for the settings section.
	public function settings_section_callback() {
		echo '<p>Enter your API key below:</p>';
	}

	// Callback function for the API key field.
	public function api_key_field_callback() {
		$api_key = get_option('elv_api_key');
		echo '<input type="text" id="elv_api_key" name="elv_api_key" value="' . esc_attr($api_key) . '" />';
	}

	// Settings link
	public function add_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=elv-settings">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

}

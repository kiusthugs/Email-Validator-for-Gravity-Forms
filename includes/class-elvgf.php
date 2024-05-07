<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/kiusthugs
 * @since      1.0.0
 *
 * @package    Elvgf
 * @subpackage Elvgf/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Elvgf
 * @subpackage Elvgf/includes
 * @author     Kirt Perez, BTV Marketing <kirtperez3245@gmail.com>, Tom Madrid, MixTape Las Vegas
 */
class Elvgf {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Elvgf_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'ELVGF_VERSION' ) ) {
            $this->version = ELVGF_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'elvgf';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        // Integrate Email Validator methods
        add_action('init', array($this, 'init_plugin'));
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Elvgf_Loader. Orchestrates the hooks of the plugin.
     * - Elvgf_i18n. Defines internationalization functionality.
     * - Elvgf_Admin. Defines all hooks for the admin area.
     * - Elvgf_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        // Load the class responsible for orchestrating the actions and filters of the core plugin.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-elvgf-loader.php';

        // Load the class responsible for defining internationalization functionality of the plugin.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-elvgf-i18n.php';

        // Load the class responsible for defining all actions that occur in the admin area.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-elvgf-admin.php';

        // Load the class responsible for defining all actions that occur in the public-facing side of the site.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-elvgf-public.php';

        // Create an instance of the loader which will be used to register the hooks with WordPress.
        $this->loader = new Elvgf_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Elvgf_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        // Create a new instance of Elvgf_i18n class.
        $plugin_i18n = new Elvgf_i18n();

        // Add action to hook the 'plugins_loaded' event and load the plugin text domain.
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        // Create a new instance of Elvgf_Admin class.
        $plugin_admin = new Elvgf_Admin( $this->get_plugin_name(), $this->get_version() );

        // Add actions to hook the 'admin_enqueue_scripts' event and enqueue styles and scripts for admin area.
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        // Create a new instance of Elvgf_Public class.
        $plugin_public = new Elvgf_Public( $this->get_plugin_name(), $this->get_version() );

        // Add actions to hook the 'wp_enqueue_scripts' event and enqueue styles and scripts for public area.
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Elvgf_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Initialize the plugin.
     *
     * Retrieve API key from settings and validate emails using the retrieved API key.
     *
     * @since    1.0.0
     */
    public function init_plugin() {
        // Retrieve API key from settings.
        $api_key = get_option('elv_api_key');

        // Validate emails using the retrieved API key.
        $this->validate($api_key);
    }

    /**
     * Verify emails with Email List Verify API.
     *
     * @since    1.0.0
     * @param    string    $key     API key.
     * @param    string    $email   Email address to verify.
     * @return   string             API Response.
     */
    private function verify_email($key, $email) {
        $query_args = array(
            'secret' => $key,
            'email' => $email,
            'timeout' => 15
        );
        $request_url = add_query_arg($query_args, 'https://apps.emaillistverify.com/api/verifyEmail');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        
    
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_status !== 200) {
            echo $http_status;
            $error_message = curl_error($ch);
            echo "There is something wrong with the API, please try again later.";
            return "Error: $error_message";
        }
        
        curl_close($ch);
        

        return $response;
    }

    /**
     * Validate emails using Email List Verify API.
     *
     * @since    1.0.0
     * @param    string    $api_key    API key.
     */
    public function validate($api_key) {
        if (class_exists('GFAPI')) {
            // Add filter to validate Gravity Forms field.
            add_filter('gform_field_validation', function ($result, $value, $form, $field) use ($api_key) {
                // Check if API key is empty.
                if (empty($api_key)) {
                    echo "Please enter API key in settings";
                    return;
                }

                // Validate email if the field type is 'email' and the result is valid.
                if ($field->get_input_type() === 'email' && $result['is_valid']) {
                    $email = $value;
                    $key = $api_key;
                    // Verify email using the retrieved API key.
                    $response = $this->verify_email($key, $email);
                    // If the response is not 'ok', mark the email as invalid.
                    if ($response !== 'ok') {
                        $result['is_valid'] = false;
                    }
                }
                return $result;
            }, 10, 4);
        }
    }

}

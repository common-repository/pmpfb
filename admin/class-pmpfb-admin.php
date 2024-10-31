<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://figarts.co
 * @since      1.0.0
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/admin
 */

class Pmpfb_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->initialize();

	}

	/**
	 * Registers plugin options
	 *
	 * @since    1.0.0
	 */
	function initialize(){
		if( false == get_option( 'pmpfb' ) ) {  
		  add_option( 'pmpfb', pmpfb_default_options() );
		} // end if
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		$screen = get_current_screen();
		if ($screen->id != 'memberships_page_pmpro_form_builder') {
			return;
		}
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pmpfb-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$screen = get_current_screen();
		if ($screen->id != 'memberships_page_pmpro_form_builder') {
			return;
		}
		// wp_dump(PMPFB_DIR_URL . 'admin/js/tabs.js');
		wp_enqueue_script( 'pmpfb-fb', PMPFB_DIR_URL . 'admin/js/form-builder.min.js', array( 'jquery', 'jquery-ui-sortable' ), $this->version, true );
    wp_enqueue_script( 'pmpfb-tabs', PMPFB_DIR_URL . 'admin/js/tabs.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pmpfb-repeatable', PMPFB_DIR_URL . 'admin/js/jquery.repeatable.js', array( 'jquery' ), $this->version, true );		
		wp_enqueue_script( $this->plugin_name, PMPFB_DIR_URL . 'admin/js/pmpfb-admin.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Adds a submenu under Restrict menu
	 *
	 * @since    1.0.0
	 */
	public function add_submenu() {
	  add_submenu_page(
  		'pmpro-membershiplevels',
      esc_html__( 'Form Builder', 'pmpfb' ),  // The title
      esc_html__( 'Form Builder', 'pmpfb' ),  // The text to be displayed for this menu item
      'manage_options',                       // Which type of users can see this menu item
      'pmpro_form_builder',                     // The unique ID - that is, the slug - for this menu item
      array( $this, 'render_submenu_page' )   // The name of the function to call 
	  );
	} 

	/**
	 * Renders the submenu created above
	 *
	 * @since    1.0.0
	 */
	function render_submenu_page() {

    $data = get_option('pmpfb');
    
    $fields = pmpfb_fields_to_object($data['fields']);
		// wp_dump($fields);
    
    $checkouts = $data['checkouts'];
    $settings = $data['settings'];
		require_once PMPFB_ADMIN_PARTIALS . '/submenu-page.php';
	} 


	/**
	 * Saves form settings
	 *
	 * @since    1.0.0
	 */
	public function save_settings(){
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pmpfb_form_data'])) {
      
      if( ! current_user_can( 'manage_options' ) )
        return;

      // Do a nonce security check
      $nonce = $_REQUEST['_wpnonce'];
      if ( ! wp_verify_nonce( $nonce, 'pmpfb_save_nonce' ) ) wp_die( 'Security check' ); 
      
      $data = [];  
      
      if( ! empty( $_FILES['pmpfb_import_file']['name']) ){
        $name = $_FILES['pmpfb_import_file']['name'];
        $extension = end( explode( '.', $name ) );

        if( $extension != 'json' ) {
          wp_die( esc_html__( 'Please upload a valid .json file', 'rcpfb' ) );
        }

        $import_file = $_FILES['pmpfb_import_file']['tmp_name'];
        if( empty( $import_file ) ) {
          wp_die( esc_html__( 'Please upload a file to import', 'rcpfb' ) );
        }
        // Retrieve the form from the file and convert the json object to an array. 

        $import_data = trim( file_get_contents( $import_file ), '"');
        $import_data = stripslashes( sanitize_text_field( $import_data ) );
        $import_data = json_decode( $import_data, TRUE);
        $data['fields'] = $import_data['fields'];
        $data['checkouts'] = $import_data['checkouts'];
      }
      else{
				
				$posted_fields = $_POST['pmpfb_form_data'];
	      $fields = stripslashes( sanitize_text_field($posted_fields) );
	      $data['fields'] = json_decode( $fields, TRUE);
      
	      if ( isset($_POST['pmpfb_checkouts']) && is_array($_POST['pmpfb_checkouts']) ) {
	      	$posted_checkouts = array_column($_POST['pmpfb_checkouts'], 'name');
	      	$posted_checkouts = array_filter($posted_checkouts);

					if( empty($posted_checkouts) ){
						$data['checkouts'] = array();		
					}

					$data['checkouts'] = array_map('sanitize_text_field', $posted_checkouts);				
	    	
					$existing_checkouts = get_option('pmpfb')['checkouts'];

					if ( count($existing_checkouts) > count($data['checkouts']) ) {
						// remove checkouts
						$existing_checkouts = get_option('pmpfb')['checkouts'];
						if ( is_array($data['checkouts']) && is_array($existing_checkouts) ){
							$diff = array_merge(array_diff($data['checkouts'],$existing_checkouts),array_diff($existing_checkouts,$data['checkouts']));
							if ( is_array($diff) && !empty($diff) ){
							}
						}					
					}
					else{
						// add checkouts
					}
	    	}else{
	    		$existing_checkouts = get_option('pmpfb')['checkouts'];
	    		if ( !empty($existing_checkouts) && is_array($existing_checkouts)  ) {
	    		}
	      	$data['checkouts'] = array();
	    	}

      }

    	// SETTINGS
      if ( isset($_POST['pmpfb_settings']) && is_array($_POST['pmpfb_settings']) ) {
      	$data['settings'] = array_map('sanitize_text_field', $_POST['pmpfb_settings']);
      }else{
        $data['settings'] = array();
      }

      update_option('pmpfb', $data);
    }


	}

}

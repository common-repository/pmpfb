<?php

/**
 * The file that hooks filter/actions
 * 
 * @link       https://figarts.co
 * @since      1.0.0
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/includes
 */

class Pmpfb_Register {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pmpfb_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	private $data;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
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
		$this->data = get_option('pmpfb');
		add_action( 'init', array($this, 'get_pmpfb_checkouts' ));
		add_action( 'init', array($this, 'get_pmpfb_fields' ));
	}

	/**
	 * Retrieve the checkouts and hooks them
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_pmpfb_checkouts() {
	
		$checkouts = $this->data['checkouts'];
		if (!is_array($checkouts) || empty($checkouts))
			return;

		foreach ($checkouts as $checkout) {
			$slug = str_replace(' ', '-', strtolower($checkout));
			pmprorh_add_checkout_box($slug, $checkout);
		}
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_pmpfb_fields() {
		
		// Get field positions
		$positions = array_column(pmpfb_field_locations(), 'id');
		$pmpro_fields = array();

		foreach ($positions as $key => $position) {
			$next = (isset($positions[$key+1])) ? $positions[$key+1] : $positions[$key];
			// Get all the fields associated with each position
			$get_arrays = pmpfb_getArraysBetweenNames($position,$next, $this->data['fields'] );

			$pmpro_fields[$position] = $get_arrays;
		}
		$this->pmpfb_hookify($pmpro_fields);

	}



	/**
	 * Hooks each field
	 * 
	 * @param      array    $fields_arr
	 * @since    1.0.0
	 */
	public function pmpfb_hookify($fields_arr){

		if(!function_exists( 'pmprorh_add_registration_field' )) {
			return false;
		}

    if (!empty($fields_arr) && is_array($fields_arr)) {		
			foreach ($fields_arr as $position => $fields) {

				foreach ($fields as $field) {

          $args = array(
						'label'		=> (isset($field['label'])) ? $field['label'] : '',		// custom field label
						'class'		=> (isset($field['className'])) ? $field['className'] : '',	// custom class
						'profile'	=> (isset($field['profile'])) ? $field['profile'] : '', // show in user profile
						'required'	=> ( isset($field['required']) && $field['required'] == true ) ? true : false,			// make this field required
						'levels'		=> (isset($field['role'])) ? explode(',',$field['role']) : '',
						'memberslistcsv' => (isset($field['memberslistcsv'])) ? $field['memberslistcsv'] : '',
						'hint' => ( isset($field['description']) ) ? $field['description'] : '',
						'divclass' =>  ( isset($field['divclass']) ) ? $field['divclass'] : '',
						'showmainlabel' => ( isset($field['showmainlabel']) && $field['showmainlabel'] == true  ) ? false : true,
						'readonly' => ( isset($field['readonly']) ) ? $field['readonly'] : '',
					);

					if (isset($field['depends']) && $field['depends'] == true) {
						$args['depends'] = pmpfb_pmpro_conditional($field['depends'], $field['dependfield'], $field['dependvalue']);
					}

					if ($field['type'] == 'text') {
						$args['size'] = (isset($field['size'])) ? $field['size'] : '';
					}

					if ($field['type'] == 'textarea') {
						if ( isset($field['html']) && $field['html'] == true) {
							$field['type'] = 'html';
						}
						else{
							$args['rows'] = (isset($field['rows'])) ? $field['rows'] : '';
							$args['cols'] = (isset($field['cols'])) ? $field['cols'] : '';
						}
					}

					if ($field['type'] == 'checkbox') {
						$args['text'] = (isset($field['text'])) ? $field['text'] : '';
						$args['html_attributes'] = (isset($field['values']['0']['selected'] ) && $field['values']['0']['selected'] == true) ? array('checked' => 'checked') : '';	
					}

					if ($field['type'] == 'radio-group') {
						$field['type'] = 'radio';
						$options = array();
						foreach ($field['values'] as $value) {
  						$options[$value['value']] = $value['label'];
							if (isset($value['selected'] ) && $value['selected'] == true){
								$args['value'] = $value['value'];
							}		
						}
						$args['options'] = $options;
					}

					if ($field['type'] == 'select') {
						$options = array();
						foreach ($field['values'] as $value) {
  						$options[$value['value']] = $value['label'];
							if (isset($value['selected'] ) && $value['selected'] == true){
								$args['value'] = $value['value'];
							}		
						}
						$args['options'] = $options;

						if ( isset($field['multiple']) && $field['multiple'] == true) {
							$field['type'] = 'select2';
						}
					}

					if ($field['type'] == 'size') {
						$args['accept'] = (isset($field['accept'])) ? $field['accept'] : '';
					}

					if ($field['type'] == 'hidden') {
						$args['value'] = (isset($field['value'])) ? $field['value'] : '';
					}

					if ($field['type'] == 'date') {
						$args['value'] = (isset($field['value'])) ? $field['value'] : '';
					}

					if ($field['type'] == 'file') {
						$args['accept'] = (isset($field['accept'])) ? $field['accept'] : '';
					}

					if ($field['type'] == 'header' || $field['type'] == 'paragraph') {
						$field['type'] = 'html';
						$args['html'] = '<'.$field['subtype'].'>'.$field['label'].'</'.$field['subtype'].'>';
					}

					$pmpro_field = new PMProRH_Field(
						$field['name'],						// input name, will also be used as meta key
						$field['type'],						// type of field
						$args
					);
					pmprorh_add_registration_field(
						$position,				// location on checkout page
						$pmpro_field						// PMProRH_Field object
					);

				}
			}
		}
	}

}

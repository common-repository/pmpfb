<?php
/**
 * General Functions
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/admin
 * @author     David Towoju (Figarts) <hello@figarts.co>
 */

/**
 * Default options for PMPForm Builder
 * 
 * @since    1.0.0
 * @param    string    Level 
 */
function pmpfb_default_options( ) {

  $defaults = array(
    'fields'    =>  pmpfb_field_locations(),
    'checkouts'   =>  '',
    'settings'    =>  array(
      'disable_email' => true,
      'disable_password' => true
    )
  );
  return apply_filters( 'pmpfb_default_options', $defaults );
}


/**
 * Field Locations
 * 
 * @since    1.0.0
 * @param    string    Level 
 */ 
function pmpfb_field_locations( ) {
  
  $field_locations = array(
    array(
      'name' => 'after_username',
      'id' => 'after_username',
      "type"=> "number",
      "label"=> esc_html__('After Username','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),
    array(
      'name' => 'after_password',
      'id' => 'after_password',
      "type"=> "number",
      "label"=> esc_html__('After Password','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),
    array(
      'name' => 'after_email',
      'id' => 'after_email',
      "type"=> "number",
      "label"=> esc_html__('After Email','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),    
    array(
      'name' => 'after_captcha',
      'id' => 'after_captcha',
      "type"=> "number",
      "label"=> esc_html__('After Captcha','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),    
    array(
      'name' => 'checkout_boxes',
      'id' => 'checkout_boxes',
      "type"=> "number",
      "label"=> esc_html__('Checkout Box: More Information','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),
    array(
      'name' => 'after_billing_fields',
      'id' => 'after_billing_fields',
      "type"=> "number",
      "label"=> esc_html__('After Billing Fields','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),
    array(
      'name' => 'before_submit_button',
      'id' => 'before_submit_button',
      "type"=> "number",
      "label"=> esc_html__('Before Submit Buttons','pmpfb'),
      'className' => 'pmpfb-default-field'
    ),
  );
  array_splice( $field_locations, 5, 0, pmpfb_checkout_fields() );
  return $field_locations;
}


/**
  * Converts PHP array to JSON object.
  *
  * @since    1.0.0
  * @param    array    $fields 
  */
 function pmpfb_array_to_object($fields, $checkout){
  $json = array();

  if ( ! is_array($fields)) {
    return;
  }
  $json['fields'] = $fields;
  $json['checkouts'] = $checkout;

  $json = json_encode($json);
  return $json;
}

/**
  * Converts PHP array to JSON object.
  *
  * @since    1.0.0
  * @param    array    $fields 
  */
function pmpfb_fields_to_object($fields){
  $json = array();

  if ( ! is_array($fields)) {
    return;
  }

  foreach ($fields as $field) {
    $itemObject = new stdClass();
    foreach ($field as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $k => $v) {
          $itemObject->{$key}[$k] = array_map('esc_attr',$v);
        }
      }else {
        $itemObject->{$key} = esc_attr($value);
      }
    }
    array_push($json, $itemObject);
  }
  $json = json_encode($json);

  return $json;
}


/**
 * Get default and dynamically generated checkout fields 
 * 
 * @since    1.0.0
 * @param    string    Level 
 */ 
function pmpfb_checkout_fields(){
  
  $data = get_option('pmpfb');
  $checkouts = $data['checkouts'];
  
  if ( !is_array($checkouts) OR empty($checkouts) )
    return;
  
  $cb = array();
  foreach ($checkouts as $checkout) {
    $slug = str_replace(' ', '-', strtolower($checkout));
    $cb[] = array( 
      'name' => $slug,
      'id' => $slug,
      "type"=> "number",
      "label"=> $checkout,
      'className' => 'pmpfb-default-field'
    );
  }
  return $cb;
}


/**
 * Form Builder Type Attribute Settings
 *
 * @since    1.0.0
 * @param    string    $membership 
 */
function pmpfb_get_type_attr(){
    
  $type_attr = array(
    'typeUserAttrs' => array(
      'number' => array(
        'id' => array(
          'label' => 'ID',
        ),
      ),
      'text' => array(
        'size' => array(
          'label' => 'Size',
          'type' => 'number',
        ),
      ),
      'textarea' => array(
        'cols' => array(
          'label' => 'Cols',
          'type' => 'number',
        ),
      ),
      'select' => array( 
       'select2' => array(
          'label' => 'Select2',
          'type' => 'checkbox',
        ),             
      ),
      'checkbox' => array(  
        'text' => array(
          'label' => 'Text',
        ),            
      ),
      'radio-group' => array(       
      ),
      'date' => array(        
      ),
      'file' => array(        
        'accept' => array(
          'label' => 'Accept',
          'type' => 'text',
          'placeholder' => 'type image/* to accept only images'
        ),        
      ),
      'hidden' => array(        
      ),
      'header' => array(
       'name' => array(
          'label' => 'Name',
        ), 
      ),
      'paragraph' => array(
       'name' => array(
          'label' => 'Name',
        ), 
      )
    )
  );

  $type_attr['typeUserAttrs']['text'] = array_merge($type_attr['typeUserAttrs']['text'],pmpfb_common_attr());
  $type_attr['typeUserAttrs']['textarea'] = array_merge($type_attr['typeUserAttrs']['textarea'],pmpfb_common_attr());
  $type_attr['typeUserAttrs']['radio-group'] = array_merge($type_attr['typeUserAttrs']['radio-group'],pmpfb_common_attr());
  $type_attr['typeUserAttrs']['hidden'] = array_merge($type_attr['typeUserAttrs']['hidden'],pmpfb_common_attr());

  $type_attr = json_encode($type_attr, JSON_PRETTY_PRINT);

  return substr($type_attr, 1, -1);

}


/**
 * Common field attributes
 *
 * @since    1.0.0
 */
function pmpfb_common_attr()
{

  $attrs = array(
    'memberslistcsv' => array(
      'label' => 'CSV',
      'type' => 'checkbox',
    ),
    'readonly' => array(
      'label' => 'Read Only',
      'type' => 'checkbox',
    ),                 
    'depends' => array(
      'label' => 'Conditional',
      'type' => 'checkbox',
    ),
    'dependfield' => array(
      'label' => 'Conditional Name',
    ),
    'dependvalue' => array(
      'label' => 'Conditional Value',
    ),
    'profile' => array(
      'label' => 'Profile',
      'options' => array(
        'true' => 'True',
        'false' => 'False',
        'only' => 'Only',
        'only_admin' => 'Only Admin',
      )
    ),
    'showmainlabel' => array(
      'label' => 'Remove Label',
      'type' => 'checkbox',
    ),
    'divclass' => array(
      'label' => 'Div Class',
    ),

  );
  return $attrs;
}


/**
 * Get arrays bewtween two values
 * 
 * @since    1.0.0
 * @param    string    start 
 * @param    string    end 
 * @param    array    array 
 */
function pmpfb_getArraysBetweenNames($name1, $name2, $array)
{
  $return = [];
  $foundName1 = false;

  if ($name1 == 'jolly' || $name1 == 'fresh') {
    $name1 = ucwords($name1);
  }

  if ($name2 == 'jolly' || $name2 == 'fresh') {
    $name2 = ucwords($name2);
  }

  if (is_array($array) && !empty($array)) {
    foreach ($array as $key => $item) {
      if ($foundName1) {
        if ( isset($item['id']) && $item["id"] == $name2)
          break;

        $return[$key] = $item;
      } elseif ( isset($item['id']) && $item["id"] == $name1) {
        $foundName1 = true;
      }
    }
  }

  return $return;
}


/**
 * Format array to PMPro select field
 * 
 * @since    1.0.0
 * @param    array    array 
 */
function pmpfb_pmpro_select_format($field, $args=''){
  $options = array();
  $values = $field['values'];
  foreach ($values as $value) {
    $options[$value['value']] = $value['label'];
    if (isset($value['selected'] ) && $value['selected'] == true){
      $args['value'] = $value['value'];
    }   
  }
  return $options;
}


/**
 * PMPro Conditional logic
 * 
 * @since    1.0.0
 * @param    string    depends 
 * @param    string    id 
 * @param    string    value 
 */
function pmpfb_pmpro_conditional($depends,$id,$value){
  if ($depends == true) {
    return array(array('id' => $id, 'value' => $value));
  }
  else{
    return array();
  }
}



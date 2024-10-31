<?php
/**
 * Settings
 *
 * Shows form settings
 * @package    Pmpfb
 * @subpackage Pmpfb/admin
 * @author     David Towoju (Figarts) <hello@figarts.co>
 */
?>

<h2><?php esc_html_e('Settings', 'pmpfb'); ?></h2>

<table class="form-table">

  <tr>
    <th align="left" scope="row">Email Repeat</th>
    <td align="left">
      <p>
        <label for="pmpfb_disable_email" title="Show approved comments">
        <input name="pmpfb_settings[disable_email]" id="pmpfb-disable-email" value="1" type="checkbox" disabled class="pmpfb_settings" <?php checked(true, isset($settings['disable_email']) ? $settings['disable_email'] : '' )  ?>><?php esc_html_e('Turn off to disable email repeat', 'pmpfb') ?></label>
      </p>
    </td>
  </tr>

  <tr>
    <th align="left" scope="row">Password Repeat</th>
    <td align="left">
      <p>
        <label for="pmpfb_disable_password" title="Show approved comments">
        <input name="pmpfb_settings[disable_password]" disabled id="pmpfb-disable-password" value="1" type="checkbox" class="pmpfb_settings" <?php checked(true, isset($settings['disable_password']) ? $settings['disable_password'] : '') ?>><?php esc_html_e('Turn off to disable password repeat', 'pmpfb') ?></label>
      </p>
    </td>
  </tr>
</table>
<div class="metabox-holder">
  <div class="postbox disabled">
    <h3><span><?php esc_html_e( 'Export Settings', 'pmpfb' ); ?></span></h3>
    <div class="inside">
      <p><?php esc_html_e( 'Export the form fields as a .json file. This allows you to easily import the form into another site', 'pmpfb' ); ?></p>                   
      <a href="<?php echo esc_url( wp_nonce_url(admin_url('admin.php?page=pmpro_form_builder&pmpfb_export=1'), 'exporting_pmpfb', 'pmpfb_nonce') ); ?>" class="button pmpfb-button"><?php esc_html_e( 'Export', 'pmpfb' ) ?> </a>
    </div><!-- .inside -->
  </div><!-- .postbox -->

  <div class="postbox disabled">
    <h3><span><?php _e( 'Import Settings' ); ?></span></h3>
    <div class="inside">
      <p><?php esc_html_e( 'Import the form fields from a .json file. This file can be obtained by exporting the form on another site using the form above.' ); ?></p>
      <p>
        <input type="file" name="pmpfb_import_file"/>
      </p>
    </div><!-- .inside -->
  </div><!-- .postbox -->

  <div class="postbox disabled">
    <h3><span><?php _e( 'Reset Form' ); ?></span></h3>
    <div class="inside">
      <p><?php esc_html_e( 'Resetting form will delete fields, checkouts and settings created with this plugin.' ); ?></p>
       <a onclick="return confirm('Are you sure you want to reset form?');" href="<?php echo esc_url( wp_nonce_url(admin_url('admin.php?page=pmpro_form_builder&pmpfb_reset=1'), 'resets_pmpfb', 'pmpfb_nonce') ); ?>" class="button pmpfb-button"><?php esc_html_e( 'Reset', 'pmpfb' ) ?> </a>
    </div><!-- .inside -->
  </div><!-- .postbox -->





</div><!-- .metabox-holder -->  
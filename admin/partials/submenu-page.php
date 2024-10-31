<?php
/**
 * Provide a admin area view for the plugin
 *
 * @link       https://figarts.co
 * @since      1.0.0
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/admin/partials
 */
?>

<div id="wp-body">
  <div id="wpbody-content">

    <div class="wrap">
      <?php printf('<h1>%s</h1>', esc_html__('Form Builder', 'pmpfb')) ?>	
      <div id="tabs" class="pmpfb-tabs no-js">

        <div id="setting-error-settings_updated" class="pmpfb-upgrade notice notice-warning"> 
          <p style="width: 100%; display: flex; flex-wrap: nowrap; box-sizing: border-box;">Please <a href="https://figarts.co/product/paid-memberships-pro-form-builder/?utm_source=wp-dashboard&utm_medium=pmpfb-lite" style="">Upgrade to PRO</a><span style="">to unlock all disabled features</span></p>
        </div>

        <form method="post" action="" id="pmpfb-form" enctype="multipart/form-data">

	        <h2 class="nav-tab-wrapper" style="margin-bottom: 0px">
	          <a href="?page=pmpro_form_builder&tab=display_fields" class="nav-tab is-active">
	          	<?php esc_html_e('Form Fields', 'pmpfb') ?>	
	          </a>
	          <a href="?page=pmpro_form_builder&tab=display_checkouts" class="nav-tab">
	          	<?php esc_html_e('Checkouts', 'pmpfb') ?>	
	          </a>
	          <a href="?page=pmpro_form_builder&tab=display_settings" class="nav-tab">
	          	<?php esc_html_e('Settings', 'pmpfb') ?>	
	          </a>
	        </h2>

	        <div class="pmpfb-tab is-active">
	          <div id="pmpfb-form-fields" class="pmpfb-tab__content"></div>
						<input type="hidden" name="pmpfb_form_data" id="pmpfb-form-data">
            <?php require_once PMPFB_ADMIN_PARTIALS . '/builder.php'; ?>
					</div>

	        <div class="pmpfb-tab">
	          <div id="pmpfb-form-fields" class="pmpfb-tab__content"></div>
            <?php require_once PMPFB_ADMIN_PARTIALS . '/checkouts.php'; ?>
					</div>

	        <div class="pmpfb-tab">
	          <div id="pmpfb-form-fields" class="pmpfb-tab__content"></div>
            <?php require_once PMPFB_ADMIN_PARTIALS . '/settings.php'; ?>
					</div>

        <?php 
          wp_nonce_field( 'pmpfb_save_nonce' );
          submit_button( esc_html__('Save Form', 'pmpfb'), 'pmpfb-button primary', 'save_pmpfb' );
        ?>

        </form>


      </div><!--tabs-->
    </div><!--wrap-->
  </div><!--wpbody-content-->
</div><!--wp-body-->
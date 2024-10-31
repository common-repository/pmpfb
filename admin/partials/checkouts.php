<?php
/**
 * Checkouts
 *
 * Shows the form to add/remove checkouts 
 * @package    Rcpfb
 * @subpackage Rcpfb/admin
 * @author     David Towoju (Figarts) <hello@figarts.co>
 */
?>

<h2><?php esc_html_e('Checkout Boxes', 'rcpfb'); ?></h2>
<div class="metabox-holder">
  <div class="postbox disabled">
      
    <div class="pmpfb-right" style="float: right; margin-right: 20px; margin-top: 15px;">
      <a href="<?php echo esc_url( wp_nonce_url(admin_url('admin.php?page=rcp_form_builder&rcpfb_export=1'), 'exporting_rcpfb', 'rcpfb_nonce') ); ?>" class="button pmpfb-button add"><?php esc_html_e( 'Add Checkout Box', 'rcpfb' ) ?> </a>
    </div>
    
    <h3 style="padding: 26px 10px 12px;"><span><?php esc_html_e( 'Add Checkout boxes one after the other', 'rcpfb' ); ?></span></h3>

    <div class="inside" style="border-top: 1px solid #eee;">
      <fieldset class="checkout_labels">
        <h4></h4>
        
        <p style="width: 100%; display: flex; flex-wrap: nowrap; box-sizing: border-box;">
          <input name="checkout_labels_default" type="text" size="15" value="More Information" id="checkout_labels_default" class="regular-text code" style="margin-right: 1rem;" disabled>
          <input type="button" name="submit" id="submit" class="pmpfb-button delete" value="X" disabled>
        </p>

        <div class="repeatable">
          <?php echo Pmpfb_Repopulator::repopulate("checkouts", $checkouts); ?>
        </div>

        <script type="text/template" id="checkout_labels">
          <?php echo Pmpfb_Repopulator::$templates["checkouts"]; ?>
        </script>
      </fieldset>
    </div><!-- .inside -->
  </div><!-- .postbox -->
</div><!-- .metabox-holder -->  
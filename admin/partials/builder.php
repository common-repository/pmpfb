<?php
/**
 * Builder
 *
 * Shows the form builder 
 * @package    Pmpfb
 * @subpackage Pmpfb/admin
 * @author     David Towoju (Figarts) <hello@figarts.co>
 */
?>
<script>

(function( $ ) {
	'use strict';

  var checkbox_input = ['memberslistcsv','readonly','depends','showmainlabel'];

	 $(function () {
    var fbTemplate = document.getElementById('pmpfb-form-fields');
    var options = {
      disableFields: ['button','autocomplete','number','checkbox-group'],
      controlOrder: ['text','textarea','checkbox','radio-group','select','date'],    
      disabledActionButtons: ['data','clear','save'],
      disabledAttrs: ['toggle','placeholder','inline','other','maxlength'],      
      typeUserDisabledAttrs: {
        'text': ['value','subtype'],
        'hidden': ['memberslistcsv','access'],
        'textarea': ['subtype','value'],
        'file' : ['multiple','subtype'],
        'number' : ['min','max','step']
      },
      typeUserEvents: {
        text: {
          onadd: function (fld) {
            fixCheckedPropForField(fld, checkbox_input);
          }
        },
        textarea: {
          onadd: function (fld) {
            fixCheckedPropForField(fld, checkbox_input);
          }
        }, 
        'radio-group': {
          onadd: function (fld) {
            fixCheckedPropForField(fld, checkbox_input);
          }
        }, 
        hidden: {
          onadd: function (fld) {
            fixCheckedPropForField(fld, checkbox_input);
          }
        }, 
 
               
      },      
      fields : [{
        label: 'Checkbox',
        attrs: {
          type: 'checkbox'
        }
      }],
      <?php echo pmpfb_get_type_attr() ?>,
      roles: <?php echo pmpfb_get_pmprolevels() ?>,
      formData: '<?php echo $fields ?>', 
    };
    
    var formBuilder = $(fbTemplate).formBuilder(options);
    $('#pmpfb-form').submit(function() {       
      var data = formBuilder.actions.getData('json', true);
      $('#pmpfb-form-data').val(data);
      return true;
    });   

    /**
     * Fix Custom Checked Box Form Builder.
     * 
     * @param {type} fld
     * @returns {undefined}
     */
    function fixCheckedPropForField (fld, fieldNames) {

      $.each( fieldNames, function( index, value ){
        var $checkbox = $(".fld-"+ value, fld);
        // alert($checkbox.attr('default'))
        // According to the value of the attribute "value", check or uncheck
        if($checkbox.val() == "1"){
            $checkbox.attr("checked", true);
        }else{
            $checkbox.attr("checked", false);
        }
      });

      var $dependField = $(".fld-dependfield", fld);
      var $dependValue = $(".fld-dependvalue", fld);
      var $dependfieldWrap = $dependField.parents(".dependfield-wrap:eq(0)");
      var $dependvalueWrap = $dependValue.parents(".dependvalue-wrap:eq(0)");
      $dependField.prop("disabled", true);
      $dependValue.prop("disabled", true);
      $dependfieldWrap.hide();
      $dependvalueWrap.hide();
      fld.querySelector(".fld-depends").onchange = function(e) {
        var toggle = e.target.checked;
        $dependField.prop("disabled", !toggle);
        $dependfieldWrap.toggle(toggle);              
        $dependValue.prop("disabled", !toggle);
        $dependvalueWrap.toggle(toggle);
      };

      var optionFields = ['checkbox', 'radio-group', 'select'];
      if ( jQuery.inArray( $(fld).attr('type'), optionFields ) !== -1 ) {
        $( $(fld).find('.sortable-options li input[type="radio"]') ).each( function( index, element ){
          if ($( this ).val() == '1') {
            $( this ).attr('checked', 'checked');
          }
        });
      }
    };

  });

})( jQuery );

</script>

<?php

/**
 * A jQuery plugin that allows you to easily create repeatable groups of form fields. [See it in action.])
 *
 * @link       (http://jenwachter.com/jquery.repeatable/
 * @since      1.0.0
 *
 * @package    Pmpfb
 * @subpackage Pmpfb/includes
 */
class Pmpfb_Repopulator{

	public static $templates = array(
		"checkouts" => '<div class="field-group controls-row">
                      <p style="width: 100%; display: flex; flex-wrap: nowrap; box-sizing: border-box;">
                        <input name="pmpfb_checkouts[{?}][name]" type="text" size="15" value="{name}" id="name_{?}" class="regular-text code" style="margin-right: 1rem;">
                        <input type="button" name="submit" id="submit" class="pmpfb-button delete" value="X">
                      </p>
                  	</div>',
	);

	public static function repopulate($key, $checkouts)
	{
		if ( !isset($checkouts) || empty($checkouts)) return;

		$i = 0;
		foreach ($checkouts as $checkout) {
			$template = preg_replace("/\{\?\}/", $i++, Pmpfb_Repopulator::$templates[$key]);
			$k = 'name';
			$template = preg_replace("/\{{$k}\}/", $checkout, $template);
			echo $template;
		}

	}
}
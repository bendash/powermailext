/**
 * jQuery dependency plugin
 *
 * @author Ben Walch
 * @licence MIT
 *
 * usage:
 *
 *	Initialize Dependency:
 *	$(selector).dependency();
 *
 *	control dependency with data- attributes:
 *		- data-depends-on: insert here the name (or a part of the name) of the form control the current element is dependent on
 *		- data-depends-on-operator: insert here an integer to set the operator which will be applied to compare the value of the field
 *				1: not empty
 *				2: equal
 *				3: greather than
 *				4: less than
 *				5: contains
 *				6: not set
 *		- data-depends-on-value: insert the value which will be compared against the value of the field set by 'data-depends-on'
 *		- data-depends-on-action: insert here an integer to define what will happen if the dependency is 'true'
 *				1: visibility
 *				3: visibility (and validation)
 *				4: state
 *				6: state (and validation)
 *		
 */

(function($) {
	'use strict';
	function resetField(fieldName) {
	try {
		var $field = jQuery('[name="'+fieldName+'"]');
		if (jQuery.inArray($field.prop('type'), ['radio', 'checkbox']) > -1) {
			$field.each(function() {
				//jQuery(this).prop('checked', false).trigger('change');
			});
			$field.first().trigger('change');
		} else if ($field.prop('tagName').toLowerCase() == 'select') {
			//$field.children().removeAttr('selected').trigger('change');
		} else {
			$field.val('').trigger('change');
		}
	} catch(e) {}
}
	
	
	jQuery.fn.dependency = function() {
			
		var $dependentFields = jQuery(this).find('[data-depends-on]');
		var dependentTriggers = {};
		$dependentFields.each(function(index, field) {
			dependentTriggers[$(field).data('depends-on').toLowerCase().replace(/^A-Za-z0-9\-_/g, '')] = true;
		});
		
		jQuery.each(dependentTriggers, function(triggerField, value) {
			var $triggerFields = jQuery('[name*="'+triggerField+'"]:not([type="hidden"])');
			$triggerFields.on('change dependency.init', function(event) {
				var $changedField = jQuery(event.target);
				$dependentFields.each(function() {			
					if ($changedField.prop('name').indexOf(jQuery(this).data('depends-on')) > -1) {
						var dependencyIsTrue, invertResult = false;
						var toggleVisibility = jQuery(this).data('depends-on-action') <= 3;
						var toggleState = jQuery(this).data('depends-on-action') % 2 == 0;
						var changedVal = $changedField.val();
						changedVal = (typeof changedVal == 'undefined') ? '' : changedVal;
						switch($changedField.prop('type').toLowerCase()) {
							case 'radio':
								if(!$changedField.is(':checked')) {
									changedVal = $triggerFields.filter(':checked').val();
								}
								break;
							case 'checkbox':
								invertResult = !$changedField.is(':checked');
								if ($triggerFields.length > 1) {
									changedVal = Array();
									invertResult = !$triggerFields.filter(':checked').length > 1;
									$triggerFields.filter(':checked').each(function() {
										changedVal.push(jQuery(this).val());
									});
								}
								break;
							default:
								break;
						}
						switch(jQuery(this).data('depends-on-operator')) {
							// not empty
							case 1:
								dependencyIsTrue = changedVal != '';
								break;
							// equal
							case 2:								
								dependencyIsTrue = jQuery(this).data('depends-on-value') == changedVal;
								break;
							// greater than
							case 3:
								dependencyIsTrue = changedVal > jQuery(this).data('depends-on-value');
								break;
							// less than
							case 4:
								dependencyIsTrue = changedVal < jQuery(this).data('depends-on-value');
								break;
							// contains
							case 5:
								if (changedVal == '') {
									dependencyIsTrue = false;
								} else {
									var tArr = jQuery(this).data('depends-on-value').toString().split(',');
									for (var i in tArr) {
										if (changedVal.indexOf(tArr[i]) > -1) {
											dependencyIsTrue = true;
											break;
										}
									}
								}
								break;
							// not set
							case 6:
								dependencyIsTrue = changedVal == '';
								break;
						}
						if (invertResult)
							dependencyIsTrue = !dependencyIsTrue;
						if(dependencyIsTrue) {
							if (toggleVisibility) {
								jQuery(this).show();
								jQuery(this).find('input, select').removeAttr('disabled'); // modern browser do validate hidden inputs with required attribute. If disabled, validation will be skipped on them
							}
							if (toggleState) {
								jQuery(this).find('input, select').removeAttr('disabled');
							}
							jQuery(this).find('input, select').removeClass('dependency-novalidate').trigger('dependency.change');
						} else {
							if (toggleVisibility) {
								jQuery(this).hide();
								jQuery(this).find('input, select').attr('disabled', 'disabled'); // modern browser do validate hidden inputs with required attribute. If disabled, validation will be skipped on them
							}
							if (toggleState) {
								jQuery(this).find('input, select').attr('disabled', 'disabled');
							}
							jQuery(this).find('input, select').addClass('dependency-novalidate').trigger('dependency.change');
						}
					}
				});
			}).trigger('dependency.init');
		});
		
		jQuery(this).find('select, input').on('dependency.change', function() {
			if(jQuery(this).closest('[data-depends-on-action]').data('depends-on-action') <= 3) {
					resetField(jQuery(this).attr('name'));
			}
		});
		
		return this;
	}
	
} (jQuery));

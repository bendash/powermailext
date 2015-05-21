'use strict';

jQuery(function() {
	
	jQuery('form').each(function() {
		
		var $dependentFields = jQuery(this).find('[data-depends-on]');
		var dependentTriggers = {};
		$dependentFields.each(function(index, field) {
			dependentTriggers[$(field).data('depends-on').toLowerCase().replace(/[^A-Za-z0-9\-_]/g, '')] = true;
		});
		
		jQuery.each(dependentTriggers, function(triggerField, value) {
			var $triggerFields = jQuery('[name*="'+triggerField+'"]');
			$triggerFields.on('change pmext.init', function(event) {
				var $changedField = jQuery(event.target);
				$dependentFields.each(function() {			
					if ($changedField.prop('name').indexOf(jQuery(this).data('depends-on')) > -1) {
						var dependencyIsTrue, invertResult = false;
						var toggleVisibility = jQuery(this).data('depends-on-action') <= 3;
						var toggleState = jQuery(this).data('depends-on-action') % 2 == 0;
						var changedVal = $changedField.val();
						switch($changedField.prop('type').toLowerCase()) {
							case 'radio':
								if(!$changedField.is(':checked'))
									changedVal = jQuery('[name*="'+triggerField+'"]:checked').val();
								break;
							case 'checkbox':
								invertResult = !$changedField.is(':checked');
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
								dependencyIsTrue = jQuery(this).data('depends-on-value').indexOf(changedVal) > -1;
								break;
						}
						if (invertResult)
							dependencyIsTrue = !dependencyIsTrue;
						if(dependencyIsTrue) {
							if (toggleVisibility) jQuery(this).show();
							if (toggleState) jQuery(this).find('input, select').removeAttr('disabled');
							jQuery(this).find('input, select').removeClass('pmext-novalidate').trigger('pmext.dependency.change');
						} else {
							if (toggleVisibility) jQuery(this).hide();
							if (toggleState) jQuery(this).find('input, select').attr('disabled', 'disabled');
							jQuery(this).find('input, select').addClass('pmext-novalidate').trigger('pmext.dependency.change');
						}
					}
				});
			}).trigger('pmext.init');
		});
		
		
		jQuery(this).find('select, input').on('pmext.dependency.change', function() {
			if(jQuery(this).closest('[data-depends-on-action]').data('depends-on-action') <= 3)
				resetField(jQuery(this).prop('name'));
		});
		
	});
});

function resetField(fieldName) {
	var $field = jQuery('[name="'+fieldName+'"]');
	if (jQuery.inArray($field.prop('type'), ['radio', 'checkbox']) > -1) {
		$field.each(function() {
			jQuery(this).prop('checked', false);
		});
		$field.first().trigger('change');
	} else if ($field.prop('tagName').toLowerCase() == 'select') {
		$field.children().removeAttr('selected');
	} else {
		$field.val('').trigger('change');
	}
}
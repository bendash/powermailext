jQuery(function() {
	
	jQuery('form.powermail_form').each(function() {
		
		var $dependentFields = jQuery(this).find('[data-depends-on]');
		var dependentTriggers = {};
		$dependentFields.each(function(index, field) {
			dependentTriggers[$(field).data('depends-on').toLowerCase().replace(/[^A-Za-z0-9\-_]/g, '')] = true;
		});
		
		jQuery.each(dependentTriggers, function(triggerField, value) {
			var $triggerFields = jQuery('[name*="'+triggerField+'"]');
			$triggerFields.on('change keyup', function(event) {
				$changedField = jQuery(event.target);
				$dependentFields.each(function() {
					if ($changedField.prop('name').indexOf(jQuery(this).data('depends-on')) > -1) {
						var shouldShow, invertResult = false;
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
						switch($(this).data('depends-on-operator')) {
							// not empty
							case 0:
								shouldShow = changedVal != '';
								break;
							// equal
							case 1:
								shouldShow = jQuery(this).data('depends-on-value') == changedVal;
								break;
							// greater than
							case 2:
								shouldShow = changedVal > jQuery(this).data('depends-on-value');
								break;
							// less than
							case 3:
								shouldShow = changedVal < jQuery(this).data('depends-on-value');
								break;
							// contains
							case 4:
								shouldShow = changedVal.indexOf(jQuery(this).data('depends-on-value')) > -1;
								break;
						}
						if (invertResult)
							shouldShow = !shouldShow;
						if(shouldShow) {
							jQuery(this).show();
						} else {
							jQuery(this).hide();
							jQuery(this).find('> input').val('');
						}
					}
				});
			}).trigger('change');
		});
	});
});
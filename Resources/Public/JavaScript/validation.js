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
							case 1:
								shouldShow = changedVal != '';
								break;
							// equal
							case 2:
								shouldShow = jQuery(this).data('depends-on-value') == changedVal;
								break;
							// greater than
							case 3:
								shouldShow = changedVal > jQuery(this).data('depends-on-value');
								break;
							// less than
							case 4:
								shouldShow = changedVal < jQuery(this).data('depends-on-value');
								break;
							// contains
							case 5:
								shouldShow = jQuery(this).data('depends-on-value').indexOf(changedVal) > -1;
								break;
						}
						if (invertResult)
							shouldShow = !shouldShow;
						if(shouldShow) {
							jQuery(this).show();
							jQuery(this).find('> input').trigger('pmext.visibility.change');
						} else {
							jQuery(this).hide();
							jQuery(this).find('> input').trigger('pmext.visibility.change');
						}
					}
				});
			}).trigger('pmext.init');
		});
	});
});
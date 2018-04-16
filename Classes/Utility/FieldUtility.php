<?php
namespace WorldDirect\Powermailext\Utility;

/**
 * Field Utility
 *
 * @package TYPO3
 * @subpackage powermailext
 * @version
 */
class FieldUtility {
    
    /**
     * adds additional attributes to the field
     */
    public function addAdditionalAttributes(&$dataArray, $field, $iteration, $parentObject) {
        if ($field->getMaxlength() > 0) {
			$dataArray['maxlength'] = $field->getMaxlength();
		}
		if ($field->getDisabled()) {
			$dataArray['disabled'] = 'disabled';
		}
		if ($field->getReadonly()) {
			$dataArray['readonly'] = 'readonly';
		}
    }
    
    
}
<?php
namespace WorldDirect\Powermailext\ViewHelpers\Validation;

/**
 * Returns Data-Attributes for JS and Native Validation
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class ValidationDataAndAttributesViewHelper extends \In2code\Powermail\ViewHelpers\Validation\ValidationDataAttributeViewHelper {

	/**
	 * Returns Data Attribute Array for JS validation and some html tag attributes
	 *
	 * @param \In2code\Powermail\Domain\Model\Field $field
	 * @param \array $additionalAttributes To add further attributes
	 * @param \mixed $iteration Iterationarray for Multi Fields (Radio, Check, ...)
	 * @return \array for data attributes
	 */
	public function render(\In2code\Powermail\Domain\Model\Field $field, array $additionalAttributes = [], $iteration = null) {
		switch ($field->getType()) {
			case 'check':
				// multiple field radiobuttons
			case 'radio':
				$this->addMandatoryAttributesForMultipleFields($additionalAttributes, $field, $iteration);
				break;
			default:
				$this->addMandatoryAttributes($additionalAttributes, $field);
		}
		$this->addAttributes($additionalAttributes, $field);
		$this->addValidationAttributes($additionalAttributes, $field);
		return $additionalAttributes;
	}
	
	/**
	 * Set different attributes
	 *
	 * @param \array $dataArray
	 * @param \In2code\Powermail\Domain\Model\Field $field
	 * @param \mixed $iteration
	 * @return void
	 */
	protected function addAttributes(&$dataArray, $field) {
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
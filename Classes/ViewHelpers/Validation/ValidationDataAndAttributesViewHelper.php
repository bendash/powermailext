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
	public function render(\In2code\Powermail\Domain\Model\Field $field, $additionalAttributes = array(), $iteration = NULL) {
		$dataArray = $additionalAttributes;
		$this->extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();
		if ($this->arguments['extensionName'] !== NULL) {
			$this->extensionName = $this->arguments['extensionName'];
		}

		$this->addAttributes($dataArray, $field);
		$this->addMandatoryAttributes($dataArray, $field, $iteration);
		$this->addValidationAttributes($dataArray, $field);
		return $dataArray;
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
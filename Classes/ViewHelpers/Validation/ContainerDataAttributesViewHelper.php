<?php
namespace WorldDirect\Powermailext\ViewHelpers\Validation;

/**
 * Returns Data-Attributes for JS and Native Validation
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class ContainerDataAttributesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	 * Returns Data Attribute Array for Container Field (powermail fieldwrap) in FE
	 *
	 * @param \In2code\Powermail\Domain\Model\Field $field
	 * @param \array $additionalAttributes To add further attributes
	 * @return \array for data attributes
	 */
	public function render(\In2code\Powermail\Domain\Model\Field $field = NULL) {
	
		if($field && $field->getDependency() && in_array($field->getDependencyAction(), array(1,2))) {
			return 'data-depends-on="'.$field->getDependencyField()->getMarker().'" data-depends-on-operator="'.$field->getDependencyOperator().'" data-depends-on-value="'.$field->getDependencyValue().'"';
		}
		
		return '';
	}
}
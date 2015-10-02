<?php
namespace WorldDirect\Powermailext\ViewHelpers\Misc;
/**
 * Returns Data-Attributes for JS and Native Validation
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class CorrectTextAnswerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * Returns Data Attribute Array Datepicker settings (FE + BE)
	 *
	 * @param \In2code\Powermail\Domain\Model\Field $field
	 * @param \array $additionalAttributes To add further attributes
	 * @return \array for data attributes
	 */
	public function render(\In2code\Powermail\Domain\Model\Answer $answer = NULL) {
		$textAnswer = '';
		
		if($answer) {
			$field = $answer->getField();
			$answerValue = $answer->getValue();
			switch($field->getType()) {
				case 'select':
				case 'check':
				case 'radio':
					$possibleAnswers = $field->getModifiedSettings();
					if (!is_array($answerValue)) {
						$answerValue = array($answerValue);
					}
					$i = 0;
					foreach ($answerValue as $value) {
						foreach ($possibleAnswers as $possibleAnswer) {
							if ($possibleAnswer['value'] == $value)
							$textAnswer .= $possibleAnswer['label'];
						}
						if($i != (count($answerValue)-1))
							$textAnswer .= ', ';
						$i++;
					}
					break;
				default:
					$textAnswer = $answerValue;
					break;
			}
		}
		return $textAnswer;
		
	}
}
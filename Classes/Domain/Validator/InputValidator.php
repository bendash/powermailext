<?php
namespace WorldDirect\Powermailext\Domain\Validator;

class InputValidator extends \In2code\Powermail\Domain\Validator\InputValidator {
		
	/**
	 * Validation of given Params
	 *
	 * @param \In2code\Powermail\Domain\Model\Mail $mail
	 * @return bool
	 */
	public function isValid($mail) {
		// stop validation if it's turned off
		if (!$this->isServerValidationEnabled()) {
			return TRUE;
		}

		// iterate through all fields of current form
		// every page
		foreach ($mail->getForm()->getPages() as $page) {
			// every field
			foreach ($page->getFields() as $field) {
				// check if field should be validated, if a validation condition is attached to it
				if($this->fieldShouldBeValidated($field, $mail)) {
					$this->isValidField(
						$field,
						$this->getAnswerFromField($field, $mail)
					);
				}
			}
		}

		return $this->getIsValid();
	}

	/**
	 * Get Answer from given field out of Mail object
	 *
	 * @param \In2code\Powermail\Domain\Model\Field $field
	 * @param \In2code\Powermail\Domain\Model\Mail $mail
	 * @return \string Answer value
	 */
	protected function getAnswerFromField($field, $mail) {
		$theAnswer = '';
		foreach ($mail->getAnswers() as $answer) {
			if ($answer->getField()->getUid() == $field->getUid()) {
				$theAnswer = $answer->getValue();
			}
		}
		return $theAnswer;
	}
	
	/**
	 * fieldShouldBeValidated
	 *
	 * @param \WorldDirect\Powermailext\Domain\Model\Field $field
	 * @param \In2code\Powermail\Domain\Model\Mail $mail
	 */
	public function fieldShouldBeValidated($field, $mail) {
		if ($field->getValidationCondition()) {
			$theAnswer = $this->getAnswerFromField($field->getValidationConditionField(), $mail);
			if (is_array($theAnswer))
				$theAnswer = join('', $theAnswer);
			switch ($field->getValidationConditionOperator()) {
				// not empty
				case 0:
					if ($theAnswer)
						return TRUE;
					break;
				// equal
				case 1:
					if ($theAnswer == $field->getValidationConditionValue())
						return TRUE;
					break;
				// greater than
				case 2:
					if ($theAnswer > $field->getValidationConditionValue())
						return TRUE;
					break;
				// less than (integer)
				case 3:
					if ($theAnswer < $field->getValidationConditionValue())
						return TRUE;
					break;
				// contains (for multiple checkboxes)
				case 4:
					if (strpos($theAnswer, $field->getValidationConditionValue()) !== false)
						return TRUE;
					break;
			}
		} else {
			return TRUE;
		}
	}
}
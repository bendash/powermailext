<?php
namespace WorldDirect\Powermailext\Domain\Validator;

class DynamicValidator extends \WorldDirect\Powermailext\Domain\Validator\InputValidator {
	
	/**
	 * countryRepository
	 *
	 * @var SJBR\StaticInfoTables\Domain\Repository\CountryRepository
	 * @inject
	 */
	protected $countryRepository;
	
	/**
	 * validate
	 *
	 * @param \In2code\Powermail\Domain\Model\Mail $mail 
	 * @param \In2code\Powermail\Domain\Validator\CustomValidator $pObj
	 */
	public function validate($mail, $pObj) {		
		if($mail) {
			foreach ($mail->getAnswers() as $answer) {
				$field = $answer->getField();
				if ($this->fieldShouldBeValidated($field, $mail)) {
					switch ($field->getValidation()) {
						// Birthdate
						case 100:
							if(!$this->validateBirthdate($field, $answer->getValue())) {
								$pObj->setIsValid(FALSE);
								$pObj->addError('Kein gültiges Geburtsdatum angegeben!', $field->getMarker());
							}
							break;
						// IBAN
						case 101:
							if(!$this->validateIBAN($field, $answer->getValue())) {
								$pObj->setIsValid(FALSE);
								$pObj->addError('Kein gültiger IBAN eingegeben!', $field->getMarker());
							}
							break;
					}
				}
			}
		}
    }
	
	/**
	 *
	 * validateBirthdate
	 *
	 * @param \WorldDirect\Powermailext\Domain\Model\Field $field
	 * @return boolean
	 */
	private function validateBirthdate(\WorldDirect\Powermailext\Domain\Model\Field $field, $value) {
		$birthDate = strtotime(trim($value));
		$minBirthDate = strtotime('-100 years');
		$maxBirthDate = strtotime('-18 years');
		return ($birthDate >= $minBirthDate && $birthDate <= $maxBirthDate);
	}
	
	/**
	 * validateIBAN
	 *
	 * @param \WorldDirect\Powermailext\Domain\Model\Field $field
	 * @return boolean
	 */
	private function validateIBAN(\WorldDirect\Powermailext\Domain\Model\Field $field, $value) {
		$countries = $this->countryRepository->findAll()->toArray();
		$countryCodes = array_map(function($country) { return strtoupper($country->getIsoCodeA2()); }, $countries);
		$characterMap = array(
				'A' => 10,
				'B' => 11,
				'C' => 12,
				'D' => 13,
				'E' => 14,
				'F' => 15,
				'G' => 16,
				'H' => 17,
				'I' => 18,
				'J' => 19,
				'K' => 20,
				'L' => 21,
				'M' => 22,
				'N' => 23,
				'O' => 24,
				'P' => 25,
				'Q' => 26,
				'R' => 27,
				'S' => 28,
				'T' => 29,
				'U' => 30,
				'V' => 31,
				'W' => 32,
				'X' => 33,
				'Y' => 34,
				'Z' => 35
		);
		$IBAN = strtoupper($value);
	 	$IBAN = str_replace(' ', '', $IBAN);
	 	
	 	$countryCode = substr($IBAN, 0, 2);
	 	$checksum = substr($IBAN, 2, 2);
	 	$BBAN = substr($IBAN,4);
	 
	 	if(strlen($IBAN) > 34 || strlen($IBAN) < 5 || !in_array($countryCode, $countryCodes) || !ctype_digit($checksum)) 		
	 		return FALSE;
	 	
	 	$IBANcheck = $BBAN.$countryCode.$checksum;	 	
	 	$IBANcheck = strtr($IBANcheck, $characterMap);	 	
	 	return bcmod($IBANcheck, 97) == 1;
	}
	
}
?>
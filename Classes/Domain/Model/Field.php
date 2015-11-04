<?php
namespace WorldDirect\Powermailext\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ben Walch <ben.walch@world-direct.at>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Field Model
 *
 * @package powermail
 * @subpackage powermailext
 */
class Field extends \In2Code\Powermail\Domain\Model\Field {
	
	/**
	 * maxlength
	 *
	 * @var integer
	 */
	protected $maxlength;
	
	/**
	 * disabled
	 *
	 * @var boolean
	 */
	protected $disabled;
	
	/**
	 * readonly
	 *
	 * @var boolean
	 */
	protected $readonly;
	
	
	/**
	 * dependency
	 *
	 * @var boolean
	 */
	protected $dependency;

	/**
	 * dependencyField
	 *
	 * @var \In2code\Powermail\Domain\Model\Field
	 */
	protected $dependencyField;
	
	/**
	 * dependencyOperator
	 *
	 * @var integer
	 */
	protected $dependencyOperator;

	/**
	 * dependencyValue
	 *
	 * @var string
	 */
	protected $dependencyValue;

	/**
	 * dependencyAction
	 *
	 * @var integer
	 */
	protected $dependencyAction;
	
	/**
	 * dependencyResetField
	 *
	 * @var integer
	 */
	protected $dependencyResetField;
	
	/**
	 * @param integer $maxlength
	 * @return void
	 */
	public function setMaxlength($maxlength) {
		$this->maxlength = $maxlength;
	}

	/**
	 * @return integer
	 */
	public function getMaxlength() {
		return $this->maxlength;
	}
	
	/**
	 * @param boolean $disabled
	 * @return void
	 */
	public function setDisabled($disabled) {
		$this->disabled = $disabled;
	}

	/**
	 * @return boolean
	 */
	public function getDisabled() {
		return $this->disabled;
	}
	
	/**
	 * @param boolean $readonly
	 * @return void
	 */
	public function setReadonly($readonly) {
		$this->readonly = $readonly;
	}

	/**
	 * @return boolean
	 */
	public function getReadonly() {
		return $this->readonly;
	}

	/**
	 * @param boolean $dependency
	 * @return void
	 */
	public function setDependency($dependency) {
		$this->dependency = $dependency;
	}

	/**
	 * @return boolean
	 */
	public function getDependency() {
		return $this->dependency;
	}
	
	/**
	 * @param \In2code\Powermail\Domain\Model\Field $dependencyField
	 * @return void
	 */
	public function setDependencyField($dependencyField) {
		$this->dependencyField = $dependencyField;
	}

	/**
	 * @return \In2code\Powermail\Domain\Model\Field
	 */
	public function getDependencyField() {
		return $this->dependencyField;
	}
	
	/**
	 * @param integer $dependencyOperator
	 * @return void
	 */
	public function setValidationOperator($dependencyOperator) {
		$this->dependencyOperator = $dependencyOperator;
	}

	/**
	 * @return integer
	 */
	public function getDependencyOperator() {
		return $this->dependencyOperator;
	}
	
	/**
	 * @param string $dependencyValue
	 * @return void
	 */
	public function setDependencyValue($dependencyValue) {
		$this->dependencyValue = $dependencyValue;
	}

	/**
	 * @return string
	 */
	public function getDependencyValue() {
		return $this->dependencyValue;
	}
	
	/**
	 * @param integer $dependencyAction
	 * @return void
	 */
	public function setDependencyAction($dependencyAction) {
		$this->dependencyAction = $dependencyAction;
	}

	/**
	 * @return integer
	 */
	public function getDependencyAction() {
		return $this->dependencyAction;
	}
	
	/**
	 * @param integer $dependencyResetField
	 * @return void
	 */
	public function setDependencyResetField($dependencyResetField) {
		$this->dependencyResetField = $dependencyResetField;
	}

	/**
	 * @return integer
	 */
	public function getDependencyResetField() {
		return $this->dependencyResetField;
	}

}
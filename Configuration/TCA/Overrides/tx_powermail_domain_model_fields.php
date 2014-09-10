<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// TCA modification for powermail
$tempColumns = array(
	'tx_powermailext_maxlength' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.attributes.maxlength',
		'displayCond' => 'FIELD:type:IN:input,textarea,password',
		'config' => array(
			'type' => 'input',
			'default' => '',
			'size' => 4,
			'eval' => 'int'
		),
	),
	'tx_powermailext_disabled' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.attributes.disabled',
		'config' => array(
			'type' => 'check',
			'default' => 0,
		),
	),
	'tx_powermailext_readonly' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.attributes.readonly',
		'config' => array(
			'type' => 'check',
			'default' => 0,
		),
	),
	'tx_powermailext_validation_condition' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext.validation_condition.activate',
		'config' => array(
			'type' => 'check',
			'default' => 0,
		),
	),
	'tx_powermailext_validation_condition_field' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_field',
		'displayCond' => 'FIELD:tx_powermailext_validation_condition:=:1',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:pleaseChoose', 0)
			),
			'foreign_table' => 'tx_powermail_domain_model_fields',
			'foreign_table_where' => 'AND tx_powermail_domain_model_fields.pages = ###REC_FIELD_pages### AND tx_powermail_domain_model_fields.uid <> ###THIS_UID###',
			'default' => 0,
		),
	),
	'tx_powermailext_validation_condition_operator' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator',
		'displayCond' => 'FIELD:tx_powermailext_validation_condition:=:1',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator.0', 0),
				array('LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator.1', 1),
				array('LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator.2', 2),
				array('LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator.3', 3),
				array('LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_operator.4', 4)
			),
			'default' => 0,
		),
	),
	'tx_powermailext_validation_condition_value' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.xlf:tx_powermailext_domain_model_field.validation_condition_value',
		'displayCond' => 'FIELD:tx_powermailext_validation_condition:=:1',
		'config' => array(
			'size' => 8,
			'type' => 'input',
			'eval' => 'trim'
		),
	),
	'tx_extbase_type' => array(
		'exclude' => 0,
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('Powermail Default Model', ''),
				array('Powermail Extended Model', 'Tx_Powermailext_Domain_Model_Field')
			),
			'default' => 'Tx_Powermailext_Domain_Model_Field'
		)
	)
);
// add tca columns
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_fields', $tempColumns);

// create new palette with the fields in showitem for maxlength, disabled, readonly
$additionalAttributesPaletteIndex = max(array_keys($GLOBALS['TCA']['tx_powermail_domain_model_fields']['palettes'])) + 1;
$GLOBALS['TCA']['tx_powermail_domain_model_fields']['palettes'][$additionalAttributesPaletteIndex] = array(
	'canNotCollapse' => 1,
	'showitem' => 'tx_powermailext_disabled, tx_powermailext_readonly, tx_powermailext_maxlength'
);
// create new palette with the fields in showitem for validation_condition*
$validationCondtionPaletteIndex = $additionalAttributesPaletteIndex + 1;
$GLOBALS['TCA']['tx_powermail_domain_model_fields']['palettes'][$validationCondtionPaletteIndex] = array(
	'canNotCollapse' => 1,
	'showitem' => 'tx_powermailext_validation_condition, tx_powermailext_validation_condition_field, tx_powermailext_validation_condition_operator, tx_powermailext_validation_condition_value'
);

// required for extending the model
$GLOBALS['TCA']['tx_powermail_domain_model_fields']['ctrl']['type'] = 'tx_extbase_type';
// reload TCA form if validation_condition is activated
$GLOBALS['TCA']['tx_powermail_domain_model_fields']['ctrl']['requestUpdate'] .= ',tx_powermailext_validation_condition';
// show Validation options for date field too
$GLOBALS['TCA']['tx_powermail_domain_model_fields']['columns']['validation']['displayCond'] .= ',date';
// add the fields to all types for the powermail fields table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_powermail_domain_model_fields', '--palette--;LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.clf:tx_powermailext_domain_model_field.attributes;'.$additionalAttributesPaletteIndex, '', 'before:mandatory');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_powermail_domain_model_fields', '--palette--;LLL:EXT:powermailext/Resources/Private/Language/locallang_tca.clf:tx_powermailext_domain_model_field.validation_condition;'.$validationCondtionPaletteIndex, '', 'after:validation_configuration');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_powermail_domain_model_fields', 'tx_extbase_type');

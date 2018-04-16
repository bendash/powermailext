<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

// hook into the signal slot to add the additional field attributes
$signalSlotDispatcher->connect(
	'In2code\Powermail\ViewHelpers\Validation\ValidationDataAttributeViewHelper',
    'render',
    'WorldDirect\Powermailext\Utility\FieldUtility',
    'addAdditionalAttributes',
    FALSE
);

?>
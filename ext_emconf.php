<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "powermailext"
 *
 * Auto generated by Extension Builder 2014-07-23
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Powermail Extended',
	'description' => 'This extension extends powermail',
	'category' => 'plugin',
	'author' => 'Ben Walch',
	'author_email' => 'ben.walch@world-direct.at',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'version' => '1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2',
			'powermail' => '2.1-0.0.0',
			'static_info_tables' => '6.1.0-0.0.0'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
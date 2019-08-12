<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "redisdiag"
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'redis_diag',
	'description' => 'Displays diagnosis information about redis',
	'category' => 'module',
	'version' => '1.0.0',
	'author' => 'Jan Bartels',
	'author_email' => 'j.bartels@arcor.de',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-9.5.99',
			'php' => '7.0.0-7.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
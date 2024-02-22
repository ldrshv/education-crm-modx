<?php

$varchar = [
	'dbtype' => 'varchar',
	'precision' => '255',
	'phptype' => 'string',
	'null' => true,
];

$xpdo_meta_map['Company'] = [
	'package' => 'app',
	'version' => null,
	'table' => 'app_companys',
	'extends' => 'xPDOSimpleObject',
	'tableMeta' => [
		'engine' => 'InnoDB',
	],
	'fields' => [
		'name' => '',
		'status' => null,
		'brand' => null,
		'logo' => null,
		'address' => null,
		'email' => null,
		'phone' => null,
		'site' => null,
		'contacts' => null,
		'inn' => null,
		'ogrn' => null,
		'description' => null,
		'createdon' => null,
		'user' => 0,
	],
	'fieldMeta' => [
		'name' => [
			'dbtype' => 'varchar',
			'precision' => '255',
			'phptype' => 'string',
		],
		'status' => $varchar,
		'brand' => $varchar,
		'logo' => $varchar,
		'address' => $varchar,
		'email' => $varchar,
		'phone' => $varchar,
		'site' => $varchar,
		'contacts' => [
			'dbtype' => 'json',
			'phptype' => 'string', 
			'null' => true,
		],
		'inn' => $varchar,
		'ogrn' => $varchar,
		'description' => [
			'dbtype' => 'mediumtext',
			'phptype' => 'string',
			'null' => true,
		],
		'createdon' => [
            'dbtype' => 'datetime',
			'phptype' => 'datetime',
            'default' => 'CURRENT_TIMESTAMP'
		],
		'user' => [
			'dbtype' => 'int',
			'precision' => '11',
			'phptype' => 'integer',
			'default' => 0,
		],
	],
];
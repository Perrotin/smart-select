<?php

return [
	'output' => [
		/*
		|--------------------------------------------------------------------------
		| directory
		|--------------------------------------------------------------------------
		|
		| Folder where files can be generated. For example it is possible to
		| generate YAML file of your grant configuration.
		|
		*/

		'directory' => env('SMART_SELECT_DIRECTORY', 'smart-select'),

		/*
		|--------------------------------------------------------------------------
		| filename
		|--------------------------------------------------------------------------
		|
		| Filename of the generated file. Note that this is a prefix and it will
		| always have a timestamp added.
		|
		*/

		'filename' => env('SMART_SELECT_FILENAME', 'models-smart'),
	],

	'db' => [
		/*
		|--------------------------------------------------------------------------
		| user
		|--------------------------------------------------------------------------
		|
		| The SQL user you want to use and to whom you want to grant access
		|
		*/

		'user' => env('SMART_SELECT_DB_USER', 'userSmart'),

		/*
		|--------------------------------------------------------------------------
		| base
		|--------------------------------------------------------------------------
		|
		| The database where the grant will set to.
		|
		*/

		'base' => env('SMART_SELECT_DB_BASE'),

		/*
		|--------------------------------------------------------------------------
		| ip
		|--------------------------------------------------------------------------
		|
		| The IP where the sql user is authorized to
		|
		*/

		'ip' => env('SMART_SELECT_DB_IP'),

		/*
		|--------------------------------------------------------------------------
		| allowed_actions
		|--------------------------------------------------------------------------
		|
		| What are the allowed actions when doing a grant
		|
		*/

		'allowed_actions' => ['SELECT', 'INSERT', 'UPDATE', 'DELETE'],
	],
];

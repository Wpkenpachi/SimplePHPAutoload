<?php

$json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'wp_autoload.json');
$dirs = json_decode($json, true)['class'];

spl_autoload_register(function($class) use ($dirs){

	$full_dir ='';
	
	// Tratando Separador de string
	$complete_class_name = str_replace('\\', '/', $class);

	// 
	$broken_name = explode('/', $complete_class_name);
	$namespace = $broken_name;
	unset( $namespace[ count($namespace) - 1 ] );

	if( count($namespace) > 1 ){
		$namespace = implode(DIRECTORY_SEPARATOR, $namespace);
	}elseif( count($namespace) == 1 ){
		$namespace = $namespace[0];
	}

	$class_name = 	is_array( explode('/', $complete_class_name) ) ?  $broken_name[ count($broken_name) - 1 ] : $complete_class_name ;

	if( array_key_exists($namespace, $dirs) ){
		$full_dir = str_replace('/', DIRECTORY_SEPARATOR, (__DIR__ . '/../' . $dirs[$namespace] . $class_name . ".php") );
		require $full_dir;
	}
});

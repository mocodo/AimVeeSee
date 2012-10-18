<?php

/*
 * Usage : 
 * if(!$foo = Cache::read()){
 *   $foo = 'bar';
 *   Cache::write($foo);
 * }
 **/

abstract class Cache{

	const DURATION = 3600; // 1 hour

	public static function write($content){
		if(is_array($content)){
			$content = serialize($content);
		}
		file_put_contents(CACHE_FILE, $content);
	}

	public static function read($array = false){
		$content = '';

		if(!file_exists(CACHE_FILE))
			return false;

		if(time() - filemtime(filename) > 3600)
			return false;

		if($array){
			$content = unserialize(file_get_contents(CACHE_FILE));
		}
		else{
			$content = file_get_contents(CACHE_FILE);
		}
		return $content;
	}

	public static function clear(){
		if(file_exists(CACHE_FILE))
			unlink(CACHE_FILE);
	}

}

?>
<?php

	/**
	 * FileSystem helper class.
	 * 
	 * Offers several helper methods for files and directories. For example
	 * to determine the overall size of a directory and the number of files in it.
	 * 
	 * (this class is not meant to be extended)
	 * 
	 */
	final class Filesystem {

		// FIXME: add phpdoc comments
		// returns array with count of files in directory, overall filesize, maximal depth
		public static function getDirectoryInfo($directory, $recursive = false, $blackList = false) {
			$info = array();
			$info["size"] = $info["count"] = 0;
			$dirHandle = @opendir($directory);
			if($dirHandle) {
				while(false !== ($fileName = readdir($dirHandle))) {
					clearstatcache();
					if($fileName == "." OR $fileName == ".." OR (is_array($blackList) && in_array($fileName, $blackList))) {
						continue;
					}
					$file = $directory."/".$fileName;
					
					if(is_file($file) & is_readable($file)) {
						$info["size"] += filesize($file);
						$info["count"] += 1;
					}
					if(is_dir($file) & $recursive) {
						$rec_info = self::getDirectoryInfo($file, true);
						$info["size"] += $rec_info["size"];
						$info["count"] += $rec_info["count"];
					}
				}
			}
			return $info;
		}
		
		public static function getDirectoryFileList($directory = ".", $recursive = false) {
			$fileList = array();
			$dirHandle = @openDir($directory);
			if($dirHandle) {
				while(false !== ($fileName = readDir($dirHandle))) {
					if($fileName == "." OR $fileName == "..") {
						continue;
					}
					$path = $directory."/".$fileName;
					if(is_dir($path) && $recursive) {
						$fileList = array_merge($fileList, self::getDirectoryFileList($path, true));
					} else {
						$fileList[] = $path;
					}
				}
			}
			return $fileList;
		}
		
		public static function getDirectoryDepth($directory) {
			$depth = -1;
			$dirHandle = @openDir($directory);
			if($dirHandle) {
				while(false !== ($fileName = readdir($dirHandle))) {
					if($fileName == "." OR $fileName == "..") {
						continue;
					}
					$file = $directory."/".$fileName;
					if(is_dir($file)) {
						$theDepth = self::getDirectoryDepth($file);
						$depth = ($depth < $theDepth) ? $theDepth : $depth;
					}
				}
			}
			return $depth + 1;
		}
		
		// needs further testing
		public static function walkDirectory($directory, $callback, $recursive = false) {
			if(!is_callable($callback)) {
				return false;
			}
			$dirHandle = @opendir($directory);
			if($dirHandle) {
				while(false !== ($fileName = readdir($dirHandle))) {
					if($fileName == "." OR $fileName == "..") {
						continue;
					}
					$path = $directory."/".$fileName;
					call_user_func($callback, $path);
					if(is_dir($path)  & $recursive) {
						self::walkDirectory($path, $callback, true);
					}
				}
			}
			return true;
		}
	}

?>
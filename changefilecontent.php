<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1288M');
set_time_limit(0);

/*
|============================================================|
|change file content in N-level directory structur           |
|============================================================|
*/

function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}


$fileslist = getDirContents('service');
//print each file name

foreach($fileslist as $file)
{
	$result[] = $file;
}
foreach ($result as $key => $value) {

	$path = array_reverse(explode('\\', $value));
	
	$my_file = $value;
	$handle = fopen($my_file, 'r+') or die('Cannot open file:  '.$my_file);
	
	$filedone = 0;
	$data = file($value);
	$in = array();
	$out = array();
	foreach($data as $line) {
		$in[] = $line;
		if(trim($line) == '<?php include("../../../config.php"); ?>') {
	    	$filedone = 1;
		}
		if(trim($line) == '<?php include("header.php"); ?>') {
			$topflag = 1;
			$out[] = '';
			$out[] = '<?php include("../../../config.php"); ?>';
			$out[] = PHP_EOL;
			$out[] = '<?php include("../../../header.php"); ?>';
			$out[] = PHP_EOL;
		} else {
		   	$out[] = $line;
	    }
	}
	
	if($filedone == 0) {
		$fp = fopen($value, "w+");
		flock($fp, LOCK_EX);
		foreach($out as $line) {
		    fwrite($fp, $line);
		}
		flock($fp, LOCK_UN);
	} else {
		$fp = fopen($value, "w+");
		flock($fp, LOCK_EX);
		foreach($in as $line) {
		    fwrite($fp, $line);
		}
		flock($fp, LOCK_UN);
	}

	fclose($handle);
	


}    
	echo "/=============D O N E==============/";
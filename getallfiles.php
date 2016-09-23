<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

/*
|============================================================|
|get file name in N-level directory structur                 |
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

// $filesandfolderlist = listFolderFiles('service');
$fileslist = getDirContents('service');
echo "<pre>";
print_r($fileslist);exit;
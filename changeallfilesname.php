<?php
/*
|============================================================|
|Change file name in N-level directory structur              |
|============================================================|
*/
function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ol>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li>'.$ff;
            $fileExtention = substr($ff,-4);
            if($fileExtention == 'html') {
            	$newext = substr($ff, 0 , -4);
            	$newname = $newext.'php';
            	rename($dir.'/'.$ff, $dir.'/'.$newname); 
            }
            if(is_dir($dir.'/'.$ff)) {
            	listFolderFiles($dir.'/'.$ff);
            }
            echo '</li>';
        }
    }
    // return $files;
    echo '</ol>';
}

$fileslist = listFolderFiles('admin_2');
echo "<pre>";
print_r($fileslist);exit;
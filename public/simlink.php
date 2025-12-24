<?php
    $target = $_SERVER['DOCUMENT_ROOT']."/../storage/app/public";
    $link = $_SERVER['DOCUMENT_ROOT']."/storage";
    symlink( $target, $link);
    if(symlink( $target, $link )){
        echo "OK.";
    } else {
        echo "Gagal.";
    }
?>
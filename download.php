<?php
    if(isset($_POST['imglink']) && isset($_POST['video_id'])) {
        $imglink=$_POST['imglink'];
        $video_id=$_POST['video_id'];

        $url    = "$imglink";
        $img    = $video_id.'.png';
        $file   = file($url);
        $result = file_put_contents('images/'.$img, $file);

        header("Cache-Control: public");
        header("Content-Description: FIle Transfer");
        header("Content-Disposition: attachment; filename=$img");
        header("Content-Type: image/png");
        header("Content-Transfer-Emcoding: binary");

        readfile('images/'.$img);
        exit;
    } else {
        header("Location: index.php");
	    exit();
    }
?>
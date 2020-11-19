<?php
    $video_url = $_POST['url'];
    $data = parse_url($video_url); //linki parçala
    $parcala = explode('v=', $video_url); // v= den sonrasını al
    $video_id = $parcala[1];
    $video_id = substr($video_id,0,11);


    if (strpos($video_url, 'youtube.com/watch?v=') !== false) {

    }else{
        header("Location: index.php");
	    exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body class="info-body">
        <script>
            function copy(that){
                var inp =document.createElement('input');
                document.body.appendChild(inp)
                inp.value =that.textContent
                inp.select();
                document.execCommand('copy',false);
                inp.remove();
            }

            function copy_tags(){
                var copyText = document.getElementById("yt_tags");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }
        </script>

        <div class="nav"><a href="index.php"><< Geri</a></div>

        <div class="tags">
            <h1 style="margin-right: 25px;">Etiketler</h1>
            <?php
                $site = file_get_contents("$video_url");
                preg_match_all('@<meta property="og:video:tag" content="(.*?)">@si', $site, $baslik);
                $cikti = '<div class="tag" onclick="copy(this)">'.implode('</div><div class="tag" onclick="copy(this)">', $baslik[1]).'</div>';
                echo $cikti;
            ?>
        </div>

        <div class="result">
            <h1>Thumbnail</h1>
            <?php
                $site = file_get_contents("$video_url");
                preg_match_all('@<link rel="image_src" href="(.*?)">@si', $site, $img);
                $imglink = implode("", $img[1]);
                echo '<img src="',$imglink,'">'
            ?>
            <form action="download.php" method="post">
                <?php echo "<input type='hidden' name='imglink' value='$imglink'>"?>
                <?php echo "<input type='hidden' name='video_id' value='$video_id'><br>"?>
                <button type="submit">İndir</button>
            </form>
        </div>

        <div class="video">
            <h1>Video</h1>
            <iframe width="70%" height="400" src="https://www.youtube.com/embed/<?=$video_id;?>" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="tags-copy">
            <h1>Etiketleri Kopyala</h1>
            <textarea id="yt_tags"><?php
                    $site = file_get_contents("$video_url");
                    preg_match_all('@<meta property="og:video:tag" content="(.*?)">@si', $site, $baslik);
                    $cikti = implode(', ', $baslik[1]);
                    echo $cikti;?></textarea><br>
            <button onclick="copy_tags();">Kopyala</button>
        </div>
    </body>
</html>
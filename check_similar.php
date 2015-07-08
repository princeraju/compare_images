<?php

    $scale= return_scale( 'foo','bar'); //Enter your both file names here.
    echo $scale; //For troubleshooting purpose :)

    function test ($filename)
    {
        $filename = convertImage($filename, uniqid().'.jpg');

    list($width, $height) = getimagesize($filename);

    $img = imagecreatefromjpeg($filename);
    $new_img = imagecreatetruecolor(8, 8);

    imagecopyresampled($new_img, $img, 0, 0, 0, 0, 8, 8, $width, $height);
    imagefilter($new_img, IMG_FILTER_GRAYSCALE);

    $colors = array();
    $sum = 0;
    
    for ($i = 0; $i < 8; $i++) {
        for ($j = 0; $j < 8; $j++) {
            $color = imagecolorat($new_img, $i, $j) & 0xff;
            $sum += $color;
            $colors[] = $color;
        }
    }

    $avg = $sum / 64;

    $hash = '';
    $curr = '';
    $count = 0;
    foreach ($colors as $color) {
        if ($color > $avg) {
            $curr .= '1';
        } else {
            $curr .= '0';
        }
        $count++;

        if (!($count % 4)) {
            $hash .= dechex(bindec($curr));
            $curr = '';
        }
    }
    unlink($filename);
    return $hash;
}

function convertImage($originalImage, $outputImage, $quality=100)
{

    $myfile = fopen($outputImage, "w");
    // jpg, png, gif or bmp?
    $exploded = explode('.',$originalImage);
    $ext = $exploded[count($exploded) - 1]; 

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return $outputImage;
}

function return_scale($filename1, $filename2)
{
    $hash1=hash_file('md5', $filename1);
    $hash2=hash_file('md5', $filename2);
    if( strcmp($hash1,$hash2) == 0 )
        return 100;
    else
    {
        $hash1 = test($filename1);
        $hash2 = test($filename2);
        $diff=0;

        for($i=0 ; $i<16 ; $i++)  //Hash value length is 16
        {
            if( $hash1[$i] != $hash2[$i])
                $diff++;
        }

        return ( (16-$diff) /16)*100;
    }
}

  ?>

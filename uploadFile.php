<?php
if(is_array($_FILES)) {
    if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

    $file = $_FILES['userImage']['tmp_name'];
    $sourceProperties = getImageSize($file);
    $fileNewName = time();
    $folderPath = "images/";
    $ext = pathinfo($_FILES['userImage']['name'],PATHINFO_EXTENSION);
    $imageType = $sourceProperties[2];

    // $imageType = exif_imagetype($file)

    // $targetPath = "images/".$_FILES['userImage']['name'];
    if($imageType == IMAGETYPE_JPEG){
        $imageResourceId = imagecreatefromjpeg($file);
        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
        imagejpeg($targetLayer,$folderPath.$fileNewName."_res.".$ext);
    }else if($imageType == IMAGETYPE_PNG){
        $imageResourceId = imagecreatefrompng($file);
        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
        imagepng($targetLayer,$folderPath.$fileNewName."_res".$ext);
    }else if($imageType == IMAGETYPE_GIF){
        $imageResourceId = imagecreatefrompng($file);
        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
        imagegif($targetLayer,$folderPath.$fileNewName."_res".$ext);
    }else{
        echo "Invalid Image type.";
        // exit;
    }
    
    move_uploaded_file($file, $folderPath. $fileNewName. ".". $ext);
    echo "Image Resize Successfully.";

    include_once('img_lib.php');
    $targetFile = $folderPath.$fileNewName."_res.".$ext;
    $thumbnail = "images/thumb_".$fileNewName.".".$ext;
    $wthumb = 150;
    $hthumb = 150;

    ak_img_thumb($targetFile, $thumbnail, $wthumb, $hthumb, $ext);


    }
}

function imageResize($imageResourceId,$width,$height) {
    $imgWidth = $width;
    $imgHeight = $height;
    $resizeHeight = 300;
    $divideFactor = $imgHeight / $resizeHeight ;
    $resizeWidth = $imgWidth / $divideFactor;

    // $targetWidth =300;
    // $targetHeight =300;

    $targetWidth = $resizeWidth;
    $targetHeight = $resizeHeight;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;
}   
?>
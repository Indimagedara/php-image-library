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
    include_once('img_lib.php');

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
    
    if(move_uploaded_file($file, $folderPath. $fileNewName. ".". $ext)){
        $response = [
            'status' => '1'
        ];
        echo json_encode($response);
    }

    $targetFile = $folderPath.$fileNewName."_res.".$ext;
    $thumbnail = "images/thumb_".$fileNewName.".".$ext;
    $wthumb = 150;
    $hthumb = 150;

    ak_img_thumb($targetFile, $thumbnail, $wthumb, $hthumb, $ext);


    }
}
  
?>

<?php
function PROFILE_IMAGE_PATH() {
  if (isAdmin()) {
    return "../img/user/";
  }
  else {
    return "img/user/";
  }
}

function THUMBNAIL_IMAGE_PATH() {
  if (isAdmin()) {
    return "../img/user/thumbnail/thumb_";
  }
  else {
    return "img/user/thumbnail/thumb_";
  }
}

function COMPARE_IMAGE_PATH() {
  if (isAdmin()) {
    return "../img/user/compare/compare_";
  }
  else {
    return "img/user/compare/compare_";
  }
}

function ORIGINAL_IMAGE_PATH() {
  if (isAdmin()) {
    return "../img/user/original/original_";
  }
  else {
    return "img/user/original/original_";
  }
}

function maxWidth_original () {
  return 600;
}
 
function maxHeight_original () {
  return 600;
}

function maxWidth () {
  return 159;
}
 
function maxHeight () {
  return 153;
}

function maxWidth_thumb () {
  return 68;
}
 
function maxHeight_thumb () {
  return 63;
}

function maxWidth_compare () {
  return 133;
}
 
function maxHeight_compare () {
  return 123;
}

function upload_no_adjust ($file_id, $folder="", $types="") {
    if(!$_FILES[$file_id]['name']) return array('','No file specified');

    $file_title = $_FILES[$file_id]['name'];
    $bad_char = '%[&"<>:;\(\)\,\?\^\*\$#!\|\{\[\}\]\\\+=`~]%';
    $file_title_preg = preg_replace($bad_char, '', $_FILES[$file_id]['name']);
    $file_title = str_replace('\'', '', $file_title_preg);
    //Get file extension
    $ext_arr = split("\.",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(),1)),0,5);
    $file_name = $uniqer . '_' . $file_title;//Get Unique Name

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name']."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    //if($folder) $folder .= '/';//Add a '/' at the end of the folder
    

    $image = new SimpleImage();
    
    
    $image->load($_FILES[$file_id]['tmp_name']);
    
    //echo $folder . $file_name;
    //die();

    if ($image->getWidth() != maxWidth_original())
    {
      $image->resizeToWidth(maxWidth_original());
       
    }
    if ($image->getHeight() > maxHeight_original())
    {
      $image->resizeToHeight(maxHeight_original());
      
    }

    $image->save($folder . $file_name);
    return array($file_name,$result);
}

function rotateImage($image_name_to_be, $image, $degrees){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
 
        $newImage = imagerotate($source, $degrees, 0);
	

	switch($imageType) {
		case "image/gif":
                        
	  		imagegif($newImage,$image_name_to_be); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
                         
	  		imagejpeg($newImage,$image_name_to_be,90); 
			break;
		case "image/png":
		case "image/x-png":
                        
			imagepng($newImage,$image_name_to_be);  
			break;
    }
    chmod($image_name_to_be, 0777);
    return $image_name_to_be;
}  

function resizeCroppedImage($image_name_to_be, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
                        
	  		imagegif($newImage,$image_name_to_be); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
                         
	  		imagejpeg($newImage,$image_name_to_be,90); 
			break;
		case "image/png":
		case "image/x-png":
                        
			imagepng($newImage,$image_name_to_be);  
			break;
    }
    chmod($image_name_to_be, 0777);
    return $image_name_to_be;
} 


/******* THIS FUNCTION IS DEPRECATED ****************/

function upload($file_id, $folder="", $types="") {
    if(!$_FILES[$file_id]['name']) return array('','No file specified');

    $file_title = $_FILES[$file_id]['name'];
    //Get file extension
    $ext_arr = split("\.",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(),1)),0,5);
    $file_name = $uniqer . '_' . $file_title;//Get Unique Name

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name']."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    if($folder) $folder .= '/';//Add a '/' at the end of the folder
    

    $image = new SimpleImage();
    $image_thumb = new SimpleImage();
    $image_compare = new SimpleImage();
    
    $image->load($_FILES[$file_id]['tmp_name']);
    $image_thumb ->load($_FILES[$file_id]['tmp_name']);
    $image_compare ->load($_FILES[$file_id]['tmp_name']);

    /*if ($image->getWidth() > $image->getHeight())
    {
      $image->resizeToWidth(maxWidth());
      $image_thumb->resizeToWidth(maxWidth_thumb());
      $image_compare->resizeToWidth(maxWidth_compare()); 
    }
    else {
      $image->resizeToHeight(maxHeight());
      $image_thumb->resizeToHeight(maxHeight_thumb());
      $image_compare->resizeToHeight(maxHeight_compare());

    }*/

    if ($image->getWidth() != maxWidth())
    {
      $image->resizeToWidth(maxWidth());
       
    }
    if ($image->getHeight() > maxHeight())
    {
      $image->resizeToHeight(maxHeight());
      
    }    
    
    if ($image_thumb->getWidth() != maxWidth_thumb())
    {  
      $image_thumb->resizeToWidth(maxWidth_thumb());
    }
    if ($image_thumb->getHeight() > maxHeight_thumb())
    {
      $image_thumb->resizeToHeight(maxHeight_thumb());
      
    } 

    if ($image_compare->getWidth() != maxWidth_compare())
    {  
      $image_compare->resizeToWidth(maxWidth_compare());
    }
    if ($image_compare->getHeight() > maxHeight_compare())
    {
      $image_compare->resizeToHeight(maxHeight_compare());
      
    } 
 



    $image->save($folder . $file_name);
    $image_thumb->save($folder . 'thumbnail/thumb_' . $file_name);
    $image_compare->save($folder . 'compare/compare_' . $file_name);
    






/*
    

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '".$_FILES[$file_id]['name']."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif(!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_name = '';
        
    } else {
        if(!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }
*/

    return array($file_name,$result);
}  

/******* END DEPRECATED FUNCTION ****************/

class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
 
}
?>
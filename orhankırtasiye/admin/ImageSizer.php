<?php
/*********************************/
		// İlker Şahin //
/*********************************/
	
ob_start();
$ctype = $_GET["ctype"];
// header('Content-type: '. $ctype);

$resim		= $_GET["resim"];
$target		= $_GET["target"];
$stat		= $_GET["stat"];

if($stat == 0 || $stat == "0")
{
	$image = new ImageSizer();
	$image->load("../" . $resim);
	$image->scale(50);
	$image->save("../" . $target);
}

if ($stat == 9 || $stat == "9")
{
	$image = new ImageSizer();
	$image->load("../" . $resim);
	
	if($_GET["height"] > 0 && $_GET["width"] > 0)
		$image->resize($_GET["width"], $_GET["height"]);
	else if($_GET["height"] > 0 && $_GET["width"] == 0)
		$image->resizeToHeight($_GET["height"]);
	else
		$image->resizeToWidth($_GET["width"]);
	
	$image->save("../" . $resim);
}

echo "Resim yüklendi. <b>\o/</b> The image has been uploaded.";
echo "<br />";
echo "<b>3 saniye</b> sonra sayfa kapatılacak..";
echo "<script type='text/javascript'>setInterval(function(){window.open('location', '_self', '');window.close();},3000);</script>";

class ImageSizer {
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
 
   function resize($width, $height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
}
?>
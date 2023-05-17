<?php

class GallerySizer{
      var $img;     // Original image file object
      var $thumb;          // Thumbnail file object
      var $resize;         // Resized image file name
      var $width;          // Original image width
      var $height;         // Original image height
      var $new_width;      // Resized image width
      var $new_height;     // Resized image height
	  var $max_width;      // Image max width (by petition)
	  var $max_height;     // Image max width (by petition)	  
	  var $max_twidth;     // Thumb max width (by petition)
	  var $max_theight;    // Thumb max width (by petition)		  
      var $image_location; // Path to image
	  var $image_path;     // Path to image
	  var $thumb_path;     // Path to image
      var $thumbscale;     // Scale to resize thumbnail
      var $image_file;     // Resized image filename
      var $thumb_file;     // Thumbnail image filename
      var $thumbnail;      // Thumbnail image file object
      var $random_file;    // Resized image file name (random)
   /*****
   * Constructor
   * Initialize variables
   */
   function GallerySizer($image, $imageMX, $imageMY, $thumbMX, $thumbMY){
   		$this->image_file = str_replace("..", "/", $image);
		$this->max_width = $imageMX;
		$this->max_height = $imageMY;
   		$this->max_twidth = $thumbMX;
		$this->max_theight = $thumbMY;		
   }
   
   /*****
     * Retrieves path to uploaded image.
     * Retrieves filename of uploaded image
     */
    function getLocation($imagepath, $thumbpath = ''){
        //$this->image_file = str_replace("..", "/", $image);
		$this->image_path = $imagepath;
		$this->image_location = $imagepath .'/'. $this->image_file;
		if($thumbpath == '')
			$this->thumb_path = $imagepath;
		else        
			$this->thumb_path = $thumbpath;
        return true;
    }
    /*****
    * Determines image type, and creates an image object
    */
    function loadImage(){
        $this->img = null;
        $extension = strtolower(end(explode('.', $this->image_location)));
        if ($extension == 'jpg' || $extension == 'jpeg'){
            $this->img = imagecreatefromjpeg($this->image_location);
        } else if ($extension == 'png'){
            $this->img = imagecreatefrompng($this->image_location);
        } else {
            return false;
        }
		// Sets a random name for the image based on the extension type
        $file_name = strtolower(current(explode('.', $this->image_file)));
        $this->random_file = $file_name . $this->getRandom() . "." . $extension;
        $this->thumbnail = $this->random_file;
        $this->converted = $this->random_file;
        $this->resize = $this->random_file;
		echo 'Imagen cargada';
        return true;
    }

function getSize(){
      if ($this->img){
		$this->width = imagesx($this->img);
		$this->height = imagesy($this->img);
		$this->thumbscale = min($this->max_twidth / $this->width, $this->max_theight / $this->height);
      } else {
          return false;
      }
       return true;
 }

    /*****
     * Creates a thumbnail image from the original uploaded image
     */
    function setThumbnail(){
        // Check if image is larger than max size
        if ($this->thumbscale < 1){
            $this->new_width = floor($this->thumbscale * $this->width);
            $this->new_height = floor($this->thumbscale * $this->height);
            // Create temp image
            $tmp_img = imagecreatetruecolor($this->new_width, $this->new_height);
            // Copy and resize old image into new
            imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->width, $this->height);
			$this->thumb = $tmp_img;
        }
        return true;
    }
   /*****
     * Resizes uploaded image to desired viewing size
     */
    function resizeImage(){
     if ($this->width < $this->max_width){
         $this->resize = $this->img;
            return true;
        } else {
            // Create re-sized image
            $tmp_resize = imagecreatetruecolor($this->max_width, $this->max_height);
            // Copy and resize image
            imagecopyresized($tmp_resize, $this->img, 0, 0, 0, 0, $this->max_width, $this->max_height, $this->width, $this->height);
            imagedestroy($this->img);
            $this->resize = $tmp_resize;
            return true;
        }
    }
    /*****
     * Copies thumbnail image to specified thumbnail directory.
     * Sets permissions on file
     */
    function copyThumbImage(){
 imagejpeg($this->thumb, $this->thumbnail);
        if(!copy($this->thumbnail, $this->thumb_path . $this->thumbnail)){
            echo("Error processing file... Please try again!");
            return false;
        }
        if(!chmod($this->thumbnail, 666)){
            echo("Error processing file... Please try again!");
            return false;
        }
        if(!unlink($this->thumbnail)){
            echo("Error processing file... Please try again!");
            return false;
        }
        return true;
    }
    /*****
     * Copies the resized image to the specified images directory.
     * Sets permissions on file.
     */
    function copyResizeImage(){
        imagejpeg($this->resize, $this->converted);
        if(!copy($this->converted, $this->image_path . $this->converted)){
            echo("Error processing file... Please try again!");
            return false;
        }
        if(!chmod($this->converted, 666)){
            echo("Error processing file... Please try again!");
            return false;
        }
        if(!unlink($this->converted)){
            echo("Error processing file... Please try again!");
            return false;
        }
        // Delete the original uploaded image
        if(!unlink($this->image_path . $this->image_file)){
            echo("Error processing file... Please try again!");
            return false;
        }
        return true;
    }
    /*****
     * Generates a random number.  Random number is used to rename
     * the original uploaded image, once resized.
     */
    function getRandom(){        
        return "_" . date("dmy");
    }
    /*****
     * Returns path to thumbnail image
     */
    function getThumbLocation(){
        return "thumbs/" . $this->random_file;
    }
    /*****
     * Returns path to resized image
     */
    function getImageLocation(){
        return "photos/" . $this->random_file;
    }


}
?>
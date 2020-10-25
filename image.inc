<?php
class  hft_image {
    var ; //image resource for original image
    public $file_original; //file for original image
    public $image_original_width; //dimensions of the original image
    public $image_original_height;
    public $image_original_type_code; //type code for the original image
    public $image_original_type_abbr;//Abbreviation for the code above (JPG, PNG etc)
    public $image_original_html_sizes; // same fields for resized image
    //resized image
    public $image_resized;
   //these are filled only when you save resized image to the file
    public $file_resized;
    public $image_resized_width;
    public $image_resized_height;
    public $image_resized_type_code;
    public $image_resized_type_abbr;
    public $image_resized_html_sizes;
    //some settings
    public $jpeg_quality;
    public $use_gd2;

//Now lets construct the image from the file:

publicfunction __construct($file_original){
    //constructor of the class
    //it takes given file and creates image out of it
    global $ERR;
    $this->clear(); // set all class properties to the start values
    if(file_exists($file_original)){
        $this->file_original = $file_original;
        $this->image_original = $this->imagecreatefromfile($file_original);
        if(!$this->image_original){
            $this->error($ERR['IMAGE_NOT_CREATED_FROM_FILE']." file=$file_original");
            return false;
        }
    } else {
        $this->error($ERR['FILE_DOESNOT_EXSIT']." file=$file_original");
    }
}

//The constructor has introduced three new things to us: array $ERR and methods clear() and ImageCreatefromFile(). The array is just associative array with error strings included in file hft_image_errors.php. Method clear() simply sets some initial values to the properties of the

publicfunction clear() {
  // clear all the class member variables
    $this->image_original=0;
    $this->file_original='';
    $this->image_original_width=0;
    $this->image_original_height =0;
    $this->image_original_type_code=0;
    $this->image_original_type_abbr='';
    $this->image_original_html_sizes ='';
    $this->image_resized=0;
    $this->file_resized='';
    $this->image_resized_width=0;
    $this->image_resized_height=0;
    $this->image_resized_type_code=-1;
    $this->image_resized_type_abbr='';
    $this->image_resized_html_sizes='';
    $this->set_parameters();
}

//Method setparameters() is needed to set just two properties – use GD2 flag and JPEG quality:


publicfunction set_parameters($jpeg_quality='85', $use_gd2=true) {
  $this->jpeg_quality=$jpeg_quality;
  $this->use_gd2=$use_gd2;
 }

//Much more interesting is method ImageCreateFromFile(). Main purpose of this method is to create image resource basing on image type.

publicfunction imagecreatefromfile($img_file){
    global $ERR;
    $img=0;
    $img_sz = getimagesize( $img_file ); // returns array with some
    properties like dimensions and type;
    // Now create original image from uploaded file. Be careful!
    GIF is often not supported, as far as I remember from GD 1.6
    switch( $img_sz[2] ){
        case 1:
            $img = $this->_imagecheckandcreate('ImageCreateFromGif', $img_file);
            $img_type = 'GIF';
        break;
        case 2:
            $img = $this->_imagecheckandcreate('ImageCreateFromJpeg', $img_file);
            $img_type = 'JPG';
        break;
        case 3:
            $img = $this->_imagecheckandcreate('ImageCreateFromPng', $img_file);
            $img_type = 'PNG';
        break;
        // would be nice if this function will be finally supported
        case 4:
            $img = $this->_imagecheckandcreate('ImageCreateFromSwf', $img_file);
            $img_type = 'SWF';
        break;
        default:
            $img = 0;
            $img_type = 'UNKNOWN';
            $this->error($ERR['IMG_NOT_SUPPORTED']." $img_file");
        break;
    }//switch
    if($img){
        $this->image_original_width=$img_sz[0];
        $this->image_original_height=$img_sz[1];
        $this->image_original_type_code=$img_sz[2];
        $this->image_original_type_abbr=$img_type;
        $this->image_original_html_sizes=$img_sz[3];
    }else {
        $this->clear();
    }

    return $img;
}

//Basically image is created in method _imagecheckandcreate(); which takes two parameters -- name of GD function ImagegeCreateFromXXX and filename of the image. this method checks if the function exists and if yes calls it:

publicfunction _imagecheckandcreate($function, $img_file) {
    //inner function used from imagecreatefromfile().
    //Checks if the function exists and returns
    //created image or false
    global $ERR;
    if(function_exists($function)) {
        $img = $function($img_file);
    }else{
        $img = false;
        $this->error($ERR['FUNCTION_DOESNOT_EXIST'].' '.$function);
    }

    return $img;

}
?>

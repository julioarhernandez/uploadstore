<?php
/**
* Plugin Name:       APG Graphics Product Uploads
* Description:       Allow users to upload photos and purchase accessories in Woocommerce
* Version:           2.0.0
* Author:            Famous Internet Solutions
* Author URI:        https://www.famousinternetsolutions.com
* Text Domain:       kennykey
*/

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if(!defined('UPLOADSTORE_URL'))
define('UPLOADSTORE_URL', plugin_dir_url( __FILE__ ));
if(!defined('UPLOADSTORE_PATH'))
define('UPLOADSTORE_PATH', plugin_dir_path( __FILE__ ));


class UploadStore
{
  private $_nonce = 'uploadstore_admin';
  private $option_name = 'uploadstore_data';
  private $private_key = '';
  protected $templates = array(
			'uploadstore.php' => 'Upload To Store Page',
		);


  public function __construct()
  {
    add_action( 'plugins_loaded', array($this, 'plugins_loaded') );
    $this->getUploadPreviewImage();

  }

  function getUploadPreviewImage(){
    if(isset($_GET["uploadpreview"]) && !empty($_GET["upid"]) && !empty($_GET["uptype"])){
      $wp_upload_paths = wp_upload_dir();
      $upload_path = $wp_upload_paths["basedir"];
      $upload_url = $wp_upload_paths["baseurl"];
      $preview_upload_path = $upload_path . "/previews";
      $preview_upload_url = $upload_url . "/previews";
      $file = $preview_upload_path."/".$_GET["upid"].".jpg";

      if(file_exists($file)){
        header("Content-Type: image/jpeg");

        switch($_GET["uptype"]){
          case "original":
            echo file_get_contents($file);
            break;
          default:
            $img = $this->getImageBySize($file, $_GET["uptype"]);
            if($img){ echo $img; }
        }
      }
      die();
    }
  }

  function getHorizontalSize($size){
    $width = 405;
    $height = 405;

    switch($size){
      case "xsmall":
        $width = 70;
        $height = 55;
        if(get_field("landscape_xsmall_width", "cpt_product") && get_field("landscape_xsmall_width", "cpt_product") !== ""){
          $width = get_field("landscape_xsmall_width", "cpt_product");
        }
        if(get_field("landscape_xsmall_height", "cpt_product") && get_field("landscape_xsmall_height", "cpt_product") !== ""){
          $height = get_field("landscape_xsmall_height", "cpt_product");
        }
        break;
      case "small":
        $width = 90;
        $height = 55;
        if(get_field("landscape_small_width", "cpt_product") && get_field("landscape_small_width", "cpt_product") !== ""){
          $width = get_field("landscape_small_width", "cpt_product");
        }
        if(get_field("landscape_small_height", "cpt_product") && get_field("landscape_small_height", "cpt_product") !== ""){
          $height = get_field("landscape_small_height", "cpt_product");
        }
        break;
      case "medium":
        $width = 109;
        $height = 75;
        if(get_field("landscape_medium_width", "cpt_product") && get_field("landscape_medium_width", "cpt_product") !== ""){
          $width = get_field("landscape_medium_width", "cpt_product");
        }
        if(get_field("landscape_medium_height", "cpt_product") && get_field("landscape_medium_height", "cpt_product") !== ""){
          $height = get_field("landscape_medium_height", "cpt_product");
        }
        break;
      case "standard":
        $width = 155;
        $height = 95;
        if(get_field("landscape_standard_width", "cpt_product") && get_field("landscape_standard_width", "cpt_product") !== ""){
          $width = get_field("landscape_standard_width", "cpt_product");
        }
        if(get_field("landscape_standard_height", "cpt_product") && get_field("landscape_standard_height", "cpt_product") !== ""){
          $height = get_field("landscape_standard_height", "cpt_product");
        }
        break;
      case "classic":
        $width = 193;
        $height = 115;
        if(get_field("landscape_classic_width", "cpt_product") && get_field("landscape_classic_width", "cpt_product") !== ""){
          $width = get_field("landscape_classic_width", "cpt_product");
        }
        if(get_field("landscape_classic_height", "cpt_product") && get_field("landscape_classic_height", "cpt_product") !== ""){
          $height = get_field("landscape_classic_height", "cpt_product");
        }
        break;
      case "traditional":
        $width = 220;
        $height = 135;
        if(get_field("landscape_traditional_width", "cpt_product") && get_field("landscape_traditional_width", "cpt_product") !== ""){
          $width = get_field("landscape_traditional_width", "cpt_product");
        }
        if(get_field("landscape_traditional_height", "cpt_product") && get_field("landscape_traditional_height", "cpt_product") !== ""){
          $height = get_field("landscape_traditional_height", "cpt_product");
        }
        break;
      case "large":
        $width = 230;
        $height = 145;
        break;
        if(get_field("landscape_large_width", "cpt_product") && get_field("landscape_large_width", "cpt_product") !== ""){
          $width = get_field("landscape_large_width", "cpt_product");
        }
        if(get_field("landscape_large_height", "cpt_product") && get_field("landscape_large_height", "cpt_product") !== ""){
          $height = get_field("landscape_large_height", "cpt_product");
        }
      case "xlarge":
        $width = 232;
        $height = 175;
        if(get_field("landscape_xlarge_width", "cpt_product") && get_field("landscape_xlarge_width", "cpt_product") !== ""){
          $width = get_field("landscape_xlarge_width", "cpt_product");
        }
        if(get_field("landscape_xlarge_height", "cpt_product") && get_field("landscape_xlarge_height", "cpt_product") !== ""){
          $height = get_field("landscape_xlarge_height", "cpt_product");
        }
        break;
      case "xxlarge":
        $width = 260;
        $height = 165;
        if(get_field("landscape_xxlarge_width", "cpt_product") && get_field("landscape_xxlarge_width", "cpt_product") !== ""){
          $width = get_field("landscape_xxlarge_width", "cpt_product");
        }
        if(get_field("landscape_xxlarge_height", "cpt_product") && get_field("landscape_xxlarge_height", "cpt_product") !== ""){
          $height = get_field("landscape_xxlarge_height", "cpt_product");
        }
        break;
      case "thumbnail":
        return file_get_contents($file);
        break;
      default:
        $width = 405;
        $height = 405;
    }

    return [
      "width" => $width,
      "height" =>  $height
    ];
  }

  function getVerticalSize($size){
    $width = 460;
    $height = 460;

    switch($size){
      case "xsmall":
        $width = 90;
        $height = 125;
        if(get_field("portrait_xsmall_width", "cpt_product") && get_field("portrait_xsmall_width", "cpt_product") !== ""){
          $width = get_field("portrait_xsmall_width", "cpt_product");
        }
        if(get_field("portrait_xsmall_height", "cpt_product") && get_field("portrait_xsmall_height", "cpt_product") !== ""){
          $height = get_field("portrait_xsmall_height", "cpt_product");
        }
        break;
      case "small":
        $width = 90;
        $height = 155;
        if(get_field("portrait_small_width", "cpt_product") && get_field("portrait_small_width", "cpt_product") !== ""){
          $width = get_field("portrait_small_width", "cpt_product");
        }
        if(get_field("portrait_small_height", "cpt_product") && get_field("portrait_small_height", "cpt_product") !== ""){
          $height = get_field("portrait_small_height", "cpt_product");
        }
        break;
      case "medium":
        $width = 110;
        $height = 174;
        if(get_field("portrait_medium_width", "cpt_product") && get_field("portrait_medium_width", "cpt_product") !== ""){
          $width = get_field("portrait_medium_width", "cpt_product");
        }
        if(get_field("portrait_medium_height", "cpt_product") && get_field("portrait_medium_height", "cpt_product") !== ""){
          $height = get_field("portrait_medium_height", "cpt_product");
        }
        break;
      case "standard":
        $width = 130;
        $height = 220;
        if(get_field("portrait_standard_width", "cpt_product") && get_field("portrait_standard_width", "cpt_product") !== ""){
          $width = get_field("portrait_standard_width", "cpt_product");
        }
        if(get_field("portrait_standard_height", "cpt_product") && get_field("portrait_standard_height", "cpt_product") !== ""){
          $height = get_field("portrait_standard_height", "cpt_product");
        }
        break;
      case "classic":
        $width = 150;
        $height = 258;
        if(get_field("portrait_classic_width", "cpt_product") && get_field("portrait_classic_width", "cpt_product") !== ""){
          $width = get_field("portrait_classic_width", "cpt_product");
        }
        if(get_field("portrait_classic_height", "cpt_product") && get_field("portrait_classic_height", "cpt_product") !== ""){
          $height = get_field("portrait_classic_height", "cpt_product");
        }
        break;
      case "traditional":
        $width = 170;
        $height = 258;
        if(get_field("portrait_traditional_width", "cpt_product") && get_field("portrait_traditional_width", "cpt_product") !== ""){
          $width = get_field("portrait_traditional_width", "cpt_product");
        }
        if(get_field("portrait_traditional_height", "cpt_product") && get_field("portrait_traditional_height", "cpt_product") !== ""){
          $height = get_field("portrait_traditional_height", "cpt_product");
        }
        break;
      case "large":
        $width = 180;
        $height = 295;
        if(get_field("portrait_large_width", "cpt_product") && get_field("portrait_large_width", "cpt_product") !== ""){
          $width = get_field("portrait_large_width", "cpt_product");
        }
        if(get_field("portrait_large_height", "cpt_product") && get_field("portrait_large_height", "cpt_product") !== ""){
          $height = get_field("portrait_large_height", "cpt_product");
        }
        break;
      case "xlarge":
        $width = 210;
        $height = 297;
        if(get_field("portrait_xlarge_width", "cpt_product") && get_field("portrait_xlarge_width", "cpt_product") !== ""){
          $width = get_field("portrait_xlarge_width", "cpt_product");
        }
        if(get_field("portrait_xlarge_height", "cpt_product") && get_field("portrait_xlarge_height", "cpt_product") !== ""){
          $height = get_field("portrait_xlarge_height", "cpt_product");
        }
        break;
      case "xxlarge":
        $width = 200;
        $height = 325;
        if(get_field("portrait_xxlarge_width", "cpt_product") && get_field("portrait_xxlarge_width", "cpt_product") !== ""){
          $width = get_field("portrait_xxlarge_width", "cpt_product");
        }
        if(get_field("portrait_xxlarge_height", "cpt_product") && get_field("portrait_xxlarge_height", "cpt_product") !== ""){
          $height = get_field("portrait_xxlarge_height", "cpt_product");
        }
        break;
      case "thumbnail":
        return file_get_contents($file);
        break;
      default:
        $width = 460;
        $height = 460;
    }

    return [
      "width" =>  $width,
      "height" =>  $height
    ];
  }

  function getImageBySize($file, $size){
    $im = new Imagick();
    $im->readImage( $file );
    $img_width = $im->getImageWidth();
    $img_height = $im->getImageHeight();
    if($img_width > $img_height){
      $sizes = $this->getHorizontalSize($size);
      $im->cropThumbnailImage($sizes["width"],$sizes["height"]);
  } else {
    $sizes = $this->getVerticalSize($size);
    $im->cropThumbnailImage($sizes["width"],$sizes["height"]);
  }
    $im->setImagePage(0, 0, 0, 0);
    $img = $im->getImageBlob();
    $im->destroy();
    return $img;
  }

  function getColSize($size){
    $col = "col-lg-3";
    switch($size){
      case "xsmall":
        $col = "col-lg-3";
        break;
      case "small":
        $col = "col-lg-3";
        break;
      case "medium":
        $col = "col-lg-3";
        break;
      case "standard":
        $col = "col-lg-3";
        break;
      case "classic":
        $col = "col-lg-4";
        break;
      case "traditional":
        $col = "col-lg-4";
        break;
      case "large":
        $col = "col-lg-4";
        break;
      case "xlarge":
        $col = "col-lg-6";
        break;
      case "xxlarge":
        $col = "col-lg-6";
        break;
      default:
        $col = "col-lg-3";
    }
    return $col;
  }

  function init(){

  }

  function include_scripts(){
    if($this->is_uploadstore_product()){
    wp_deregister_script('jquery');
	    wp_enqueue_script('jquery', UPLOADSTORE_URL."js/jquery-3.2.1.min.js", array(), null, false);
    //wp_enqueue_script("jquery");
     wp_enqueue_script('buttercake', UPLOADSTORE_URL."js/butterCake.js", array(), null, true);
     wp_localize_script( 'buttercake_index', 'ajax_object', array(
       'ajax_url' => admin_url('admin-ajax.php')
     ));
     wp_enqueue_script('jqueryui', "//code.jquery.com/ui/1.11.1/jquery-ui.min.js", array(), null, true);
    //  wp_enqueue_script('upladstore_caman', UPLOADSTORE_URL."js/caman.full.min.js", array(), null, true);
     //wp_enqueue_script('upladstore_caman', "https://cdnjs.cloudflare.com/ajax/libs/camanjs/4.1.2/caman.full.min.js", array(), null, true);
     //wp_enqueue_script('upladstore_cropselect', UPLOADSTORE_URL."js/crop-select-js.min.js", array(), null, true);
     //wp_enqueue_script('upladstore_editor', UPLOADSTORE_URL."js/editor.js", array(), null, true);
     wp_enqueue_script('filetransport', UPLOADSTORE_URL."js/jquery.iframe-transport.js", array(), "3", true);
     wp_enqueue_script('fileupload', UPLOADSTORE_URL."js/jquery.fileupload.js", array(), "1", true);

     wp_enqueue_script('buttercake_index', UPLOADSTORE_URL."js/index.js", array(), "6", true);
   }

  }

  function include_styles(){
    if($this->is_uploadstore_product()){
      wp_enqueue_style( 'jqueryui', "//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css", false );
      wp_enqueue_style( 'buttercake', UPLOADSTORE_URL."css/butterCake.css", false, "3" );
      wp_enqueue_style( 'uploadstore', UPLOADSTORE_URL."css/style.css", false, "2" );
      wp_enqueue_style( 'uploadstore_editor', UPLOADSTORE_URL."css/editor.css", false );
      wp_enqueue_style( 'uploadstore_crop', UPLOADSTORE_URL."css/crop.css", false );
      wp_enqueue_style( 'uploadstore_custom', UPLOADSTORE_URL."css/customstyle.css", false, "7" );
      wp_enqueue_style( 'googlefont', "//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700", false );
      wp_enqueue_style( 'fontawesome', "//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", false );
    }
  }

  function plugins_loaded(){
    add_filter( 'template_include', array($this, 'product_page_template'), 99 );
    //add_action( 'wp_enqueue_scripts', array($this, 'load_scripts') );
    //add_action( 'wp_enqueue_scripts', array($this, 'load_styles') );

    //if(is_page("upload")){
      add_action('wp_enqueue_scripts', array($this, 'include_styles'));
      add_action('wp_enqueue_scripts', array($this, 'include_scripts'));
    //}

    add_action( 'admin_init', array($this, 'hide_editor') );
    add_action( 'wp_ajax_nopriv_upload_preview', array($this, 'upload_preview') );
    add_action( 'wp_ajax_upload_preview', array($this, 'upload_preview') );
    add_action( 'woocommerce_before_add_to_cart_button', array($this, 'cart_uploaded_image_field'), 10 );
    add_filter( 'woocommerce_add_cart_item_data', array($this, 'cart_uploaded_image_cart_item'), 10, 3 );
    add_filter( 'woocommerce_get_item_data', array($this, 'cart_uploaded_image_cart'), 10, 2 );
    add_action( 'woocommerce_checkout_create_order_line_item', array($this, 'cart_uploaded_image_order_items'), 10, 4 );
  }

  function is_uploadstore_product(){
    global $post;
    if(is_product($post->ID) && get_post_meta($post->ID, "enable_agp_upload_template", true)){
      return true;
    }

    return false;
  }

  function product_page_template( $template ) {

	if ($this->is_uploadstore_product()) {
		$new_template = UPLOADSTORE_PATH."/templates/pages/uploadstore.php";
		if ( !empty( $new_template ) ) {
			return $new_template;
		}
	}

	return $template;
}



  function load_scripts(){

  }

  function cart_uploaded_image_field() {
    global $product;

    /*if ( $product->get_id() !== 1741 ) {
        return;
    }*/

    ?>

        <input type="hidden" id="cart-uploaded-image" name="cart-uploaded-image">
    <?php
}

function cart_uploaded_image_cart_item( $cart_item_data, $product_id, $variation_id ) {
    $upload_image = filter_input( INPUT_POST, 'cart-uploaded-image' );

    //die($upload_image);

    if ( empty( $upload_image ) ) {
        return $cart_item_data;
    }

    $cart_item_data['cart-uploaded-image'] = $upload_image;

    return $cart_item_data;
}

function cart_uploaded_image_cart( $item_data, $cart_item ) {
    if ( empty( $cart_item['cart-uploaded-image'] ) ) {
        return $item_data;
    }

    $item_data[] = array(
        'key'     => 'Uploaded Image',
        'value'   => "<img src='".$cart_item['cart-uploaded-image']."' />",
        'display' => '',
    );

    return $item_data;
}

function cart_uploaded_image_order_items( $item, $cart_item_key, $values, $order ) {
    if ( empty( $values['cart-uploaded-image'] ) ) {
        return;
    }

    $url = $values['cart-uploaded-image'];
    $url_query = parse_url($url, PHP_URL_QUERY);
    parse_str($url_query, $query);
    if(!empty($query["upid"])){
      $upid = $query["upid"];
      $wp_upload_paths = wp_upload_dir();
      $upload_path = $wp_upload_paths["basedir"];
      $preview_upload_path = $upload_path . "/previews";
      $oldfilename = $preview_upload_path."/".$upid.".jpg";
      $filename = $wp_upload_paths["path"]."/".$upid.".jpg";
      $fileurl = $wp_upload_paths['url'] . '/' . basename( $filename );

      rename($oldfilename, $filename);

      $parent_post_id = $order->get_id();

      // Check the type of file. We'll use this as the 'post_mime_type'.
      $filetype = wp_check_filetype( basename( $filename ), null );

      // Get the path to the upload directory.
      $wp_upload_dir = wp_upload_dir();

      // Prepare an array of post data for the attachment.
      $attachment = array(
      	'guid'           => $fileurl,
      	'post_mime_type' => $filetype['type'],
      	'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      	'post_content'   => '',
      	'post_status'    => 'inherit'
      );

      // Insert the attachment.
      $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

      // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
      require_once( ABSPATH . 'wp-admin/includes/image.php' );

      // Generate the metadata for the attachment, and update the database record.
      $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
      wp_update_attachment_metadata( $attach_id, $attach_data );

      set_post_thumbnail( $parent_post_id, $attach_id );
      $item->add_meta_data( "Uploaded Image" , $fileurl );
    }


}



  function upload_preview(){



    $wp_upload_paths = wp_upload_dir();
    $upload_path = $wp_upload_paths["basedir"];
    $upload_url = $wp_upload_paths["baseurl"];
    $preview_upload_path = $upload_path . "/previews";
    $preview_upload_url = $upload_url . "/previews";
    $allowed_types = array("image/jpeg", "image/png");

    if(!empty($_POST["nonce"])){
      if ( ! wp_verify_nonce( $_POST["nonce"], 'preview_image' ) ) {
          die( 'Security check failed' );
      }
    }

    if(!empty($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
      $tmp_file_name = $_FILES['image']['name'];
      $tmp_file_path = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      if(!in_array($file_type, $allowed_types)) {
        die("Incorrect file type");
      }

      $extension = ".jpg";
      /*if($file_type == "image/png"){
        $extension = ".png";
      }*/

      $unique_filename = uniqid()."-".date("Y-m-d");

      $filename = $unique_filename.$extension;
      $new_file_path = $preview_upload_path."/".$filename;

      if(!file_exists($preview_upload_path)){
        mkdir($preview_upload_path);
      }

      //copy($tmp_file_path, $new_file_path);
      //unlink($tmp_file_path);

      $img_size = "portrait";

      $im = new Imagick();
      $im->readImage( $tmp_file_path );
      $width = $im->getImageWidth();
      $height = $im->getImageHeight();
      $im->setImageFormat("jpg");
      $im->writeImage( $new_file_path );
      $im->destroy();

      unlink($tmp_file_path);

      if($width > $height){
        $img_size = "landscape";
      }

      /*
      $im = new Imagick();
      $im->readImage( '/tmp/test.png' );
      $im->thumbnailImage( 480, 480 );
      $im->writeImage( '/tmp/th_test.png' );
      $im->destroy();
      */

      $image_url = $preview_upload_url."/".$filename;

      $secure_image_url = str_replace( 'http://', '//', $image_url );

      //echo $preview_upload_url."/".$filename;

      $response_data = [
        //"img_url" => $secure_image_url
        "id" => $unique_filename,
        "type" => $img_size,
        "original" => site_url("/?uploadpreview&upid=".$unique_filename."&uptype=original"),
        "thumbnail" => site_url("/?uploadpreview&upid=".$unique_filename."&uptype=thumbnail")
      ];

      wp_send_json_success( $response_data );
      die();

    }
    //print_r($_POST);
    //print_r($_FILES);
  }

  function hide_editor() {
  if( !isset( $_GET['post'] ) ) return;
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

  $template_file = get_post_meta($post_id, '_wp_page_template', true);
  if($template_file == 'uploadstore.php'){ // the filename of the page template
    remove_post_type_support('page', 'editor');
  }
}


  public function view_project_template( $template ) {

		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] ) ) {
			return $template;
		}

		$file = plugin_dir_path( __FILE__ ). "templates/pages/" . get_post_meta(
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

}

$uploadstore = new UploadStore();

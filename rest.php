<?php

/*Google Maps Api*/

$maps_request = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_GET['location']);

$maps_json = get_data_from_url($maps_request);

$maps_array = json_decode($maps_json, true);

$location_lat = $maps_array['results'][0]['geometry']['location']['lat'];
$location_lng = $maps_array['results'][0]['geometry']['location']['lng'];



/*Instagram Api*/


$count = 0;


$INSTAGRAM_ACCESS_TOKEN = $_GET['tkn'];

$instagram_request = 'https://api.instagram.com/v1/media/search?lat=' . $location_lat . '&lng=' . $location_lng . '&distance=2800&access_token=' . $INSTAGRAM_ACCESS_TOKEN;

$instagram_json = get_data_from_url($instagram_request);

$instagram_array = json_decode($instagram_json, true);


$output_array_data = array();

foreach ($instagram_array['data'] as $data) {
    
    
    
    $count++;
    
    //get info about the author
    $author = $data['user']['full_name'];
    
    //get photo's instagram url
    $inst_url = $data['link'];
    
    /*Create info about images*/
    
    //create the thumbnail array
    $thumbnail_url    = $data['images']['thumbnail']['url'];
    $thumbnail_width  = $data['images']['thumbnail']['width'];
    $thumbnail_height = $data['images']['thumbnail']['height'];
    $thumbnail        = array();
    $thumbnail[]      = array(
        'url' => "$thumbnail_url",
        'width' => $thumbnail_width,
        'height' => $thumbnail_height
    );
    
    //create the low_resolution array
    $low_url          = $data['images']['low_resolution']['url'];
    $low_width        = $data['images']['low_resolution']['width'];
    $low_height       = $data['images']['low_resolution']['height'];
    $low_resolution   = array();
    $low_resolution[] = array(
        'url' => "$low_url",
        'width' => $low_width,
        'height' => $low_height
    );
    
    
    //create the standard_resolution array
    $standard_url          = $data['images']['standard_resolution']['url'];
    $standard_width        = $data['images']['standard_resolution']['width'];
    $standard_height       = $data['images']['standard_resolution']['height'];
    $standard_resolution   = array();
    $standard_resolution[] = array(
        'url' => "$standard_url",
        'width' => $standard_width,
        'height' => $standard_height
    );
    
    //create images array
    $array_images   = array();
    $array_images[] = array(
        'thumbnail' => $thumbnail,
        'low_resolution' => $low_resolution,
        'standard_resolution' => $standard_resolution
    );
    
    //create the output data array
    $output_array_data[] = array(
        'instagram_url' => "$inst_url",
        'author' => "$author",
        'images' => $array_images
    );
}


/*Output results*/
$output      = array();
$output[]    = array(
    'count' => "$count",
    'data' => $output_array_data
);
//$output_json = utf8_encode(json_encode($output));
$output_json = json_encode($output);
echo $output_json;

function get_data_from_url($url) {
  $ch = curl_init();
  $timeout = 10;
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

?>

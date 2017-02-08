<?php


if( !isset($_GET['tkn']) && !isset($_GET['code']) ){
	$url="https://api.instagram.com/oauth/authorize/";
	$client_id="22a9dde8c3274d84b607667dce5a4030";
	$redirect_uri="http://simonetruglia.altervista.org/progettoreti/index.php";
	$full_url = "$url?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=public_content";
    header("location: $full_url ");
}

if( !isset($_GET['tkn']) && isset($_GET['code']) ){
	$post["client_id"] = "22a9dde8c3274d84b607667dce5a4030";
	$post["client_secret"] = "60ddf9f530d34be8b1bafcb7e7364a49";
	$post["grant_type"] = "authorization_code";
	$post["redirect_uri"] = "http://simonetruglia.altervista.org/progettoreti/index.php";
	$post["code"] =  $_GET['code'];

	$ch = curl_init('https://api.instagram.com/oauth/access_token');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

	// execute!
	$response = curl_exec($ch);


	// close the connection, release resources used
	curl_close($ch);

	///echo $response;
	$repsonse_array=json_decode($response,true);

	header("location: index.php?tkn=".urlencode($repsonse_array['access_token']));
}

$flag=0;


if( !isset($_GET['location']) || strlen($_GET['location'])==0) {

	$flag=1;

	if(isset($_GET['location'])&&strlen($_GET['location'])==0){
		echo "You forgot to insert a location";
		echo '<br/>';
	}
}

$location_label = "";
if(isset($_GET['location'])) $location_label = $_GET['location'];
echo 
'<form action="index.php" method="get">
	<input type="hidden" name="tkn" value="'.urlencode($_GET['tkn']).'">
	Tape a location: <input type="text" name="location" value="'.$location_label.'"><br>
	<input type="submit">
</form>';

if($flag!=0) die;

$service_request='http://simonetruglia.altervista.org/progettoreti/altrodominio/rest.php?location='.urlencode($_GET['location']).'&tkn='.urlencode($_GET['tkn']);


$service_json=get_data_from_url($service_request);


$service_array=json_decode($service_json,true);


$num = $service_array[0]['count'];

if($num==0){
 echo "Sorry mate, there is no photo for ".$_GET['location'];
 die;
}
else if($num==1) echo "There is only one photo for ".$_GET['location'];
else echo "There are $num photos for ".$_GET['location'];
echo "</br>";

$count = 0;

echo '<table border=1 align="left">'."\n";
echo '<tr>'."\n\n";


foreach($service_array[0]['data'] as $data){


    if($count<=4){
    	 $count++;
    }
    
    else{
        echo '</tr>'."\n";
        echo '<tr>'."\n\n";
        $count=0;
    }

    	echo '<th>'."\n";
	echo '<a href="'.$data['instagram_url'].'" target=_BLANK>'."\n";
        echo '<img src="'.$data['images'][0]['low_resolution'][0]['url'].'" alt=""/>'."\n";
        echo '</a>'."\n";
	echo '<hr/>';
        echo '<center>';
        echo "Author: <br/>";
        echo $data['author'];
        echo '</center>';
        echo '</th>'."\n\n";
        $count++;
}

echo '</tr>'."\n";
echo '</table>'."\n";


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

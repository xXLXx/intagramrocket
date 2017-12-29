<?php
if(isset($_GET['getmorepost']))
{
		
		$urls='https://www.instagram.com/'.$_GET['username'].'/?__a=1';


		$chs = curl_init($urls);
		curl_setopt($chs, CURLOPT_TIMEOUT, 10);
		curl_setopt($chs, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
		$datas = curl_exec($chs);
		header("Access-Control-Allow-Origin: *");
		curl_close($chs);
		//var_dump(json_decode($response, true));

		$posts = json_decode($datas, true);
		$posts = $posts['user']['media'];

		echo json_encode($posts);

		// $urls='https://www.instagram.com/'.$_GET['username'].'/media/';


		// $chs = curl_init($urls);
		// curl_setopt($chs, CURLOPT_TIMEOUT, 10);
		// curl_setopt($chs, CURLOPT_CONNECTTIMEOUT, 10);
		// curl_setopt($chs, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		// curl_setopt($chs, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($chs, CURLOPT_HEADER, false);



		// $datas = curl_exec($chs);
		// header('Content-Type: image/jpeg');
  //   	header("Access-Control-Allow-Origin: *");	
		// curl_close($chs);
		// flush();

		// $posts = json_decode((string) $datas, true)['items'];
		
		// echo $datas;
		// die;



   
		
		

}
?>

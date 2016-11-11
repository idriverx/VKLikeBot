<?php
require_once('config.php');

function connect($url) {
	$ch = curl_init($url);
	curl_setopt_array($ch, array(
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYHOST => false,

    ));
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}


/*
	Возьмем инфо о пользователях состоящих в сообществе
*/

$users = connect('https://api.vk.com/method/users.search?fields=photo_id&sex=' . sex . '&sort=1&status=' . status . '&city=292&age_from=' . age_from . '&age_to=' . age_to . '&has_photo=1&online=' . online . '&has_photo=1&count=50&access_token=' . TOKEN . '&v=5.60');
//var_dump($users);
$users = json_decode($users);

foreach($users->response->items as $users) { // разберем полученный объект 
	$name = $users->first_name; 
	$surname = $users->last_name;
	$id = $users->id;
	if(!isset($users->photo_id)) continue; // если фотографии нет - то пропускаем итерацию и ищем, где фотография есть
	else $photoid = $users->photo_id;
	$photoid = substr($photoid, strpos($photoid, '_')+1); // Обрезаем именно item_id (то, что идет после нижнего подчеркивания)
	echo $id . ' ' . $name;
	//$like = connect('https://api.vk.com/method/likes.add?type=photo&owner_id=' . $id . "&item_id=" . $photoid . "&access_token=" . TOKEN . "&v=5.60"); // ставим лайки
	//sleep(1); // замораживаем действие после каждой итерации на 1 сек
}
<?php

set_time_limit(0);
ignore_user_abort(1);

file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'start_set_keitaro_ssl.txt', date("Y-m-d H:i:s"));

$result = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'result.txt');
$domain = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'domain.txt');
$id = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'id.txt');

if(preg_match('/^NOK\. There were errors/m', $result)){
	// Ошибка при выдаче сертификата Bash скриптом
	//echo 'error';
	file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'error.txt', '['.date("Y-m-d H:i:s").'] '.$domain.' ('.$id.'): '.$result.PHP_EOL.PHP_EOL);
}else{
	// Успешно выдан сертификат Bash скриптом
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://{YOUR_DOMAIN}/admin_api/v1/domains/'.$id);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Key: {YOUR_API_KEY}'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POST, 1);
	$params = [
		'is_ssl' => true,
	];
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params)); 
	$response = curl_exec($ch);
	file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'success'.DIRECTORY_SEPARATOR.$id.'_'.$domain, '['.date("Y-m-d H:i:s").'] API RESULT:'.PHP_EOL.$response);
}

?>
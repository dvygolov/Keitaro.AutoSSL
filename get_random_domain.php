<?php

set_time_limit(0);
ignore_user_abort(1);

file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'start_get_random_domain.txt', date("Y-m-d H:i:s"));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://{YOUR_DOMAIN}/admin_api/v1/domains');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Api-Key: {YOUR_API_KEY}'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch), true);

$massive_nossl = [];

foreach($response as $i){
	if($i['is_ssl'] != 1){
		// Получаем список доменов, которые без сертификата в кейтаро
		$massive_nossl[] = $i;
	}
}

if(!empty($massive_nossl)){
	$key = array_rand($massive_nossl);
	$domain = $massive_nossl[$key]['name'];
	$id = $massive_nossl[$key]['id'];
	
	file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'id.txt', $id);
	
}else $domain = 'NO';
//var_dump($domain);
echo $domain;

?>
<?php 

require_once __DIR__ . '/vendor/autoload.php';  
use Phpforelastic\Elastic;  
$data = [
'user'=>'袁',
'title'=>'我我就分手连接方式 ',
'des'=>'暗室逢灯sad',
];
//Elastic::add('http://192.168.3.181','yuan',"tweet",2,$data);
 echo Elastic::search('http://192.168.3.181','www',"门窗",20);
 //Elastic::delete('http://192.168.3.181/','twitter',"twee23t",'AV9St7UOUUgqCZdgC8DV');
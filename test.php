<?php 

require_once __DIR__ . '/vendor/autoload.php';  
use Phpforelastic\Elastic;  
$data = [
'user'=>'袁',
'title'=>'我我就分手连接方式 ',
'des'=>'暗室逢灯sad',
];
//Elastic::add('http://192.168.3.181','yuan',"tweet",2,$data);
$fields = ['title','content','id','images'];
$table = ['ask','article'];
// $table = "article";
 echo Elastic::getDetailSearch('http://192.168.3.181',$table,"装修",20,0,"desc",$fields);
 //Elastic::delete('http://192.168.3.181/','twitter',"twee23t",'AV9St7UOUUgqCZdgC8DV');
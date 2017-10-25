<?php 
namespace Phpforelastic; 
 
class Elastic
{   
    public static function search($url,$table,$word,$size=20,$from=1,$fields=false,$sort="asc")
    {   
      if(!$fields){
        $fields = [
            "title","content"
          ];
      }
      $post_data = [
        "query"=>[
          "filtered"=>[
            "query"=>[
              "query_string"=>[
                "query"=>$word
              ]
            ]
          ]
        ],
        "fields"=>$fields,
        "from"=>$from,
        "size"=>$size,
        "sort"=>[
          "_score"=>[
            "order"=>$sort,
          ]
        ],
        "explain"=>1
      ];
      $body = json_encode($post_data);
      $url_data[] = $url;
      $url_data[] = $table;
      $url_data[] = '_search';       
      $url = Elastic::get_url($url_data);
      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );//地址
      curl_setopt ( $ch, CURLOPT_POST, 1 );//请求方式为post
      curl_setopt ( $ch, CURLOPT_HEADER, 0 );//不打印header信息
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );//返回结果转成字符串
      curl_setopt ( $ch, CURLOPT_TIMEOUT,15);   //超时设置
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $body );//post传输的数据。
      $return = curl_exec ( $ch );
      curl_close ( $ch );
      $return = json_decode($return,true); 
      return json_encode($return['hits']);
    }
    public static function add($url,$table,$type,$id,$content)
    { 
      $url_data[] = $url;
      $url_data[] = $table;
      $url_data[] = $type;
      if($id){
        $url_data[] = $id;
      }
      $url = Elastic::get_url($url_data);
      $content = json_encode($content);
      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt ( $ch, CURLOPT_POST, 1 );//请求方式为post
      curl_setopt ( $ch, CURLOPT_HEADER, 0 );//不打印header信息
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );//返回结果转成字符串
      curl_setopt ( $ch, CURLOPT_TIMEOUT,15);   //超时设置
      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $content );//post传输的数据。
      $return = curl_exec ( $ch );
      curl_close ( $ch );
      $return = json_decode($return,true);  
      print_r($return);
    }
    public static function delete($url,$table,$type,$id)
    { 
      $url_data[] = $url;
      $url_data[] = $table;
      $url_data[] = $type;
      $url_data[] = $id;
      $url = Elastic::get_url($url_data);
      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $url );
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); //delete 请求
      curl_setopt ( $ch, CURLOPT_HEADER, 0 );//不打印header信息
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );//返回结果转成字符串
      curl_setopt ( $ch, CURLOPT_TIMEOUT,15);   //超时设置
      $return = curl_exec ( $ch );
      curl_close ( $ch );
      $return = json_decode($return,true);  
      print_r($return);
    }
    private function get_url($url_data){
      foreach ($url_data as $key => &$value) {
        $value = Elastic::check_param($value);
      }
      return implode("/", $url_data);
    }
    private function check_param($word){
      if(substr($word, -1)=='/'){
          return substr($word, 0,-1);
      }else{
        return $word;
      }
    
    }
}
<?php

return [
    // 'adminEmail' => 'admin@example.com',
   	'domain'=>[
   		'www'	=>	'http://yangfan.tunnel.echomod.cn',
   		'web'	=>	'http://yangfan.tunnel.echomod.cn/web',
   		'm'	=>	'http://yangfan.tunnel.echomod.cn/m',
   	],

   	'upload'=>[
   		'avatar' => '/upload/avatar',
   		'brand' => '/upload/brand',
   		'book' => '/upload/book',
   	],
      // id wx3dbcc87433ff8562
      // key 5DbU2smXd8wOlGSvpenesMDO7i5Mg7Fxi0f8Z7CRKDk
      'wx'=>[
      'appid' => 'wx3dbcc87433ff8562',
      'sk' => '82cb817129214cb982f42e17b03fa6d4',
      'token' => 'weixin',
      'aeskey' => '82cb817129214cb982f42e17b03fa6d4',
      'pay'=>[
            'key'=>'huaxingongshe1111122222333334444',
            'mch_id'=>'1313158701',
            'notify_url'=>[
               'm'=>'/pay/callback',
            ],
         ],
      ],

      'title'=>[
            'name'=>'敲程序的代码楊',
            'image'=>'/web/images/common/qrcode_for_gh_ca3d3993e573_430.jpg',
      ],

];

<?php

namespace app\modules\wx\controllers;

use yii\web\Controller;

use app\common\components\BaseController;
use yii\log\FileTarget;
use app\common\services\UrlService;
use app\models\Book;
/**
 * Msg controller for the `wx` module
 */
class MsgController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(!$this->checkSignate())
        {
            $xml_data =   'error signature~~~';
            $this->record_log( 'xml_data:'.$xml_data );
        }

        if( array_key_exists("echostr", $_GET) && $_GET['echostr'] )
        {
            return $_GET['echostr'];
        }

                                // $xml_data = $GLOBALS["HTTP_RAW_POST_DATA"];
        $xml_data = file_get_contents( "php://input" );

        $this->record_log( 'xml_data:'.$xml_data );
//       $xml_data = '<xml><ToUserName><![CDATA[gh_145ef59e8751]]></ToUserName>
// <FromUserName><![CDATA[oFEXjwovyNo4lFkjJUrr4Fn4wW6k]]></FromUserName>
// <CreateTime>1498106448</CreateTime>
// <MsgType><![CDATA[text]]></MsgType>
// <Content><![CDATA[1111]]></Content>
// <MsgId>6434318200514836861</MsgId>
// </xml>';

        $xml_Obj = simplexml_load_string($xml_data, "simpleXMLElement", LIBXML_NOCDATA);

        if( !$xml_data )
        {
             $this->record_log( 'xml_data:error xml~~');
        }
        
        // 默认返回结果
        $result = [ 'type'=>'text', 'data'=>$this->defaultTpl() ];

        $ToUserName     = $xml_Obj->FromUserName;
        $FromUserName   = $xml_Obj->ToUserName;
        $MsgType        = $xml_Obj->MsgType; 

        switch ($MsgType) {
            case 'text':
                $Content = trim( $xml_Obj->Content );
                $result  = $this->sereach( $Content );
                break;

            case 'event':
                
                break;
        }

        switch ($result['type']) {
            case 'text':
              return  $this->textTpl( $ToUserName, $FromUserName, $result['data'] );
                break;
            
            case 'rich':
               return $this->RichTpl( $ToUserName, $FromUserName, $result['data'] );
                break;

        }

    }

    // 默认提示
    private function defaultTpl()
    {
        $tpl= <<<EOT
亲，没找到你想要的东西:(\n
EOT;
    return $tpl;
    }

    // 文本消息模板 
    private function textTpl( $ToUserName, $FromUserName, $Content )
    {
        $tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml> 
EOT;

        return    sprintf($tpl, $ToUserName, $FromUserName, time(), 'text', $Content);
    }

    // 图文消息模板
    private function RichTpl( $ToUserName, $FromUserName, $Content )
    {
        $tpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
%s
</xml>
EOT;
        return sprintf( $tpl, $ToUserName, $FromUserName, time(), $Content );
    }

    private function getRichXml( $data )
    {
        $num = count( $data );
        $items = '';
        foreach( $data as $key => $val )
        {   
            $tmp_title       = $val['name'];
            $tmp_description = mb_substr( strip_tags( $val['summary'] ), 0, 20,'UTF-8');
            $tmp_picurl      = UrlService::buildImgUrl( 'book', $val['main_image']  );
            $tmp_url         = UrlService::buildMUrl( '/product/info' ,[ 'id'=>$val['id'] ]);

            $items .="<item>
<Title><![CDATA[".$tmp_title."]]></Title> 
<Description><![CDATA[".$tmp_description."]]></Description>
<PicUrl><![CDATA[".$tmp_picurl."]]></PicUrl>
<Url><![CDATA[".$tmp_url."]]></Url>
</item>
<item>";
        }
        $article = '<ArticleCount>%s</ArticleCount><Articles>%s</Articles></xml>';
        $content = sprintf( $article, $num, $items);

        return $content;
    }

    // 图书搜索
    private function sereach( $Content )
    {
        $query = Book::find()->where([ 'status' => 1 ]);

        $where_name = [ 'LIKE','name','%'.strtr( $Content ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
        $where_tag  = [ 'LIKE','tags','%'.strtr( $Content ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
     
        $query->andWhere([ 'OR',$where_name,$where_tag ]);

        $data_info =  $query->orderBy( ['id'=>SORT_DESC ] )->limit( 3 )->all();

        $data =  $data_info ? $this->getRichXml( $data_info ) :$this->defaultTpl();
       
        $type =  $data_info ? 'rich' :'text';

         return [ 'type'=>$type, 'data'=>$data ];
    }

    // 验证token
    public function checkSignate()
    {
    	$signature = trim( $this->get('signature' ,'') );
    	$timestamp = trim( $this->get('timestamp' ,'') );
    	$nonce     = trim( $this->get('nonce' ,'') );
    	// $echostr   = trim( $this->get('echostr' ,'') );
    
        $tmpArr = array( \Yii::$app->params['wx']['token'] ,$timestamp,$nonce);

        sort($tmpArr,SORT_STRING);

        $tmpArr = implode($tmpArr);

        $tmpStr = sha1( $tmpArr );

        if( $tmpStr == $signature )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    // 写入 消息日志
    public function record_log( $msg )
    {
        $log = new FileTarget();

        $log->logFile  = \Yii::$app->getRuntimePath() . '/logs/wx_msg_log' . date('Ymd') . '.log';

        $request_url  = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] :'';

        $err_msg      = "【Url：{$request_url}】【POST_DATA：".http_build_query( $_POST )."】【msg：{$msg}】";

        $log->messages[] = [
                $err_msg,
                1,
                "application",
                microtime( true ),
            ];

        // 写入文件
        $log->export();
    }

}

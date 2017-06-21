<?php 

namespace app\common\services;

use app\common\services\BaseService;
use app\common\services\ConstantMapService;
use app\common\services\BookService;

use app\models\PayOrder;
use app\models\PayOrderItem;
use app\models\Book;
use app\common\components\HttpClient;

 // 支付接口服务
class PayApiService  extends BaseService
{
	private $params = [];

	private $wxpay_params = [];

	private $prepay_id = null;

	private $prepay_info = null;


	public function __construct( $wxpay_params )
	{
		$this->wxpay_params = $wxpay_params;
	}

	public  function setWxpay_params( $wxpay_params )
	{
		$this->wxpay_params = $wxpay_params;
	}

	public  function Setparams( $parameter, $parameterVlue )
	{
		$this->params[ $parameter ] = $parameterVlue;
	}

	public   function getPrepayInfo()
	{
		$url= 'https://api.mch.weixin.qq.com/pay/unifiedorder';

		$this->params['nonce_str'] = $this->createdNoncestr();

		$this->params['sign'] = $this->getSign( $this->params );

		$xml_data = $this->converXML( $this->params );
	
		$ret = HttpClient::curl( $url, $xml_data );
		
		$retArray = $this->converArray( $ret );
		
		if( $retArray['return_code'] && $retArray['result_code'] == 'SUCCESS'  )
		{
			return $retArray;
		}

		return false;
	}	

	//	设置jsapi的参数
	public function getParams()
	{
		$jsapi = [];
			
		$jsapi['appid'] = $this->wx_params['appid'];
		$jsapi['timestamp'] = time();
		$jsapi['nonceStr'] = $this->createdNoncestr()  ;
		$jsapi['package'] = 'prepay_id='.$this->prepay_id;
		$jsapi['signType'] = 'MD5';
		$jsapi['paySign'] = $this->getSign( $jsapi );

		return $jsapi;
	}

	/**
	 * @param	string	
	 * @param	设置prepareid	
	 * @return	bool
	 */
	public function SetPrepareId( $prepareid )
	{

		$this->prepay_id = $prepareid;
	}

   /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	public function converArray($xml)
	{	
		if(!$xml){
			return false;
		}

        //将XML转为array
        //禁止引用外部xml实体
        // libxml_disable_entity_loader(true);
        $retArray = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $retArray;
	}
	

   /**
	 * @brief 从array到xml转换数据格式
	 * @param array $arrayData
	 * @return xml
	 */
  	 public function converXML( $dataArray )
   	{
   		if(!is_array($dataArray) 
			|| count($dataArray) <= 0)
		{
    		return false;
    	}
    	
    	$xml = "<xml>";
    	foreach ($dataArray as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
   	}


	public function getSignParams()
	{
		$this->params['nonce_str'] = $this->createdNoncestr();

		$this->params['sign'] = $this->getSign( $this->params );
		
		return $this->params;
	}


	private function getSign($Obj){

		$buff = $this->formattingParameter( $Obj );

		//签名步骤二：在string后加入KEY
		$string = $buff . "&key=".$this->wxpay_params['pay']['key'];

		//签名步骤三：MD5加密
		$string = md5($string);

		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);

		return $result;
	}

	// 格式化参数，签名需要使用  //签名步骤一：按字典序排序参数
	public function  formattingParameter( $Obj, $urlencode = false )
	{
		ksort($Obj);

		$buff = "";
		foreach ($Obj as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}	

	/**
	 *生成随机字符串方法
	 */
    public function createdNoncestr( $length = 32 )
    {	
    	$chars = 'qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM0123456789';
    	
    	$str = '';
    	
    	for ($i=0; $i < $length ;  $i++) 
    	{ 
    		$str.=substr($chars, mt_rand(0, strlen($chars) - 1 ), 1 );
    	}

    	return $str;

    }




}
 ?>
<?php
//打开的文件都没有关闭操作
header("Content-type:text/html;charset=utf-8");//中文乱码解决
define ( PAGESIZE, 5 );
class AssetCheckController extends Controller
{
	function actionAddConsume()
	{
		$clientData = file_get_contents("php://input");
		//$clientData = json_decode($ClientData,TURE);
		$handle=fopen('addConusme.txt','w');
		fwrite($handle, $clientData);	
	}

	public function actionTest()
	{
		$fileData=file_get_contents('codeOut.txt');
		$fileData=json_decode($fileData,true);

		echo $fileData['assetId'];
	}

	//借出/归还时将从客户端发来的num存入文件
	public function actionNum(){
		$clientData=file_get_contents("php://input");
		$handle=fopen('num.txt','w');
		fwrite($handle, $clientData);
	}

	function strToHex($string)//字符串转十六进制
	{ 
		$hex="";
		for($i=0;$i<strlen($string);$i++)
			$hex.=dechex(ord($string[$i]));
		$hex=strtoupper($hex);
		return $hex;
	} 

	function hexToStr($hex)//十六进制转字符串
	{   
		$string=""; 
		for($i=0;$i<strlen($hex)-1;$i+=2)
		$string.=chr(hexdec($hex[$i].$hex[$i+1]));
		return  $string;
	}

	//从客户端接受RFID扫描信息
	public function actionRFID()
	{
		//客户端接受数据
		$clientData = file_get_contents("php://input");
		$clientData = split(';',$clientData);
		//array_splice($clientData,count($clientData)-1,1);//截取数组最后的空数据
		//处理数据至期望的格式
		for($i=0;$i<count($clientData);$i++)
			$clientData[$i]=json_decode ($clientData[$i],TRUE);
		//打开当日二维码文件
		$time=date('Y-m-d',time());
		$fileName='log/'.$time.'-rfid.txt';//当日二维码文件名
		$this->writeToFile($clientData,$fileName);
	}

	//接受从客户端传来的二维码数据存入文件中，此时没有与数据库进行比对
	public function actionQrCode()
	{
		//客户端接受数据
		$clientData = file_get_contents("php://input");
		$clientData = split(';',$clientData);
		//处理数据至期望的格式
		for($i=0;$i<count($clientData);$i++)
			$clientData[$i]=json_decode ($clientData[$i],TRUE);
		//打开当日二维码文件
		$time=date('Y-m-d',time());
		$fileName='log/'.$time.'-code.txt';//当日二维码文件名
		$this->writeToFile($clientData,$fileName);
	}

	public function writeToFile($clientData,$fileName)
	{
		if(file_exists($fileName)==null)//文件不存在
		{
			$handle=fopen($fileName,'w');//若文件存在则打开文件，否则创建文件
		}
		//获取文件内容
		$fileData=file_get_contents($fileName);
		$fileData=json_decode($fileData,true);
		//初始化存入文件中的数据
		$dataToFile=array();
		$index=0;
		//检测重复
		for($i=0;$i<count($clientData);$i++)
		{
			$flag=false;//判断是否重复标志
			for($j=0;$j<count($fileData);$j++)
			{
				if($clientData[$i]==$fileData[$j])
				{
					$flag=true;
					break;
				}
			}
			if($flag==false)//不重复
			{
				$dataToFile[$index]=$clientData[$i];//为数组赋值
				$index++;
			}
		}
		if($fileData=="")
			$finalData=$dataToFile;
		else
			$finalData=array_merge($dataToFile,$fileData);
		$handle=fopen($fileName,'w');
		fwrite($handle,json_encode($finalData));//转化为json字符串写入文件
	}
}	
?>

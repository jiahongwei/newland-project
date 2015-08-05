<?php
date_default_timezone_set('prc');
header("Content-type: text/html; charset=utf-8");//中文乱码解决
class BoardController extends Controller
{
	public function actionIndex()
	{
		$arr=array('course_name'=>'中文');
		echo json_encode($arr);
	}

	public function actionTransfer()
	{
		//从服务器端接收电子班牌标识
		//$classNum=file_get_contents("php://input");
		//$handle=fopen('login.txt','w');	
		//fwrite($handle, $clientData);
		$classNum='1';
		//获取当前时间进行秒的清零
		$time=date('H:i',time());
		$time=$time.':00';
		$sql="SELECT fileType,fileName FROM boardschedule WHERE startTime='$time' AND classNum='$classNum'";
		//$sql="SELECT fileType,fileName FROM boardschedule";
		$pdata =Yii::app()->db->createCommand($sql);
		$res = $pdata->queryAll();//普通数组
		echo $res[0]['fileType'].'/'.$res[0]['fileName'];
	}
}
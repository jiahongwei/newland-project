<?php
header("Content-type: text/html; charset=utf-8");//中文乱码解决
class StuClientController extends Controller
{
	public function actionTest()
	{
		echo "helloworld";
	}

	public function actionLogin()
	{
		$username=$_REQUEST['username'];
		$password=$_REQUEST['password'];
		$temp = StAdmin::model ()->findByPk ( $username );
		$temp = json_decode ( CJSON::encode ( $temp ), TRUE );
		if($password==$temp['password'])
			$retArr=array('flag'=>1,'username'=>$username);
		else
			$retArr=array('flag'=>0);
		exit(json_encode($retArr));
	}

	public function actionAsset()
	{
		//接收客户端传来的condition
		$condition=$_POST['condition'];
		//从数据库表asset中获取数据
		$criteria = new CDbCriteria ();
		$sql = "SELECT assetName,specification,brwPhone,COUNT(IF(state='in',TRUE,NULL)) AS inNum,COUNT(IF(state='out',TRUE,NULL)) AS outNum FROM as_asset WHERE assetName>'$condition' GROUP BY assetName,specification ORDER BY assetName LIMIT 5";
		$pdata =Yii::app()->db->createCommand($sql);
		$dbData = $pdata->queryAll();
		$dbData = json_decode ( CJSON::encode ( $dbData ), TRUE );
		exit(json_encode($dbData));
	}

	public function actionConsume()
	{
		//接受服务端传来的condition
		$condition=$_POST['condition'];
		//从数据库表consume中获取数据
		$criteria = new CDbCriteria ();
		$sql = "SELECT assetName,specification,brwPhone,COUNT(IF(state='in',TRUE,NULL)) AS inNum,COUNT(IF(state='out',TRUE,NULL)) AS outNum from as_consume WHERE assetName>'$condition' GROUP BY assetName,specification ORDER BY assetName LIMIT 5";
		$pdata =Yii::app()->db->createCommand($sql);
		$dbData = $pdata->queryAll();
		$dbData = json_decode ( CJSON::encode ( $dbData ), TRUE );
		exit(json_encode($dbData));
	}

	public function actionApply()
	{
		//获取客户端POST过来的数据
		$stuId=$_POST['stuId'];
		$assetName=$_POST['assetName'];
		$specification=$_POST['specification'];
		$loanTime=$_POST['loanTime'];
		$returnTime=$_POST['returnTime'];
		//计算申请时间
		$applyTime=date('Y-m-d H:m:s',time());
		//通过stuId查找学生信息
		$stuData =StStudent::model ()->findByPk($stuId);
		$stuData = json_decode ( CJSON::encode ( $stuData ), TRUE );
		//插入数据库
		$apply = new AsApply (); // 资产申请数据库表
		$apply->stuId = $stuId;
		$apply->stuName = $stuData['stuName'];
		$apply->assetName = $assetName;
		$apply->specification = $specification;
		$apply->applyTime = $applyTime;
		$apply->RFID="123";
		$apply->borrowTime = $loanTime;
		$apply->returnTime = $returnTime;
		$apply->stuTelNum = '123';
		$apply->type='static';
		if ($apply->save () > 0) { // 数据库表类的函数save（），存储是否成功，来自yii框架
			$retArr=array('flag'=>1);
			exit(json_encode($retArr));
		} else {
			$retArr=array('flag'=>0);
			exit(json_encode($retArr));
		}
	}

	public function actionShowInfo()
	{
		$stuId=$_POST['stuId'];
		$sql="SELECT assetName,specification,applyTime from as_apply WHERE stuId=$stuId";
		$pdata =Yii::app()->db->createCommand($sql);
		$assetData = $pdata->queryAll();
		$assetData = json_decode ( CJSON::encode ( $assetData ), TRUE );
		for($i=0;$i<count($assetData);$i++)
		{

			$sql="SELECT COUNT(*) AS queueNum from as_apply WHERE assetName='".$assetData[$i]['assetName']."'and 
				specification='".$assetData[$i]['specification']."' and applyTime<'".$assetData[$i]['applyTime']."'";
			//echo $sql."<br>";
			$pdata =Yii::app()->db->createCommand($sql);
			$countData = $pdata->queryAll();
			$countData = json_decode ( CJSON::encode ( $countData ), TRUE );
			$assetData[$i]['num']=$countData[0]['queueNum'];
		}
		exit(json_encode($assetData));
	}

	public function actionSearch()
	{
		$searchName=$_REQUEST['searchName'];
		//对数据库as_asset进行关键字的模糊查询
		$assetSql="select RFID,assetName,specification,brwPhone,COUNT(IF(state='in',TRUE,NULL)) AS inNum from (select * from as_asset where assetName like '%".$searchName."%')temp1 GROUP BY assetName,specification";
		//$assetSql="select * from as_asset where assetName like '%".$searchName."%'";
		$assetDb =Yii::app()->db->createCommand($assetSql);
		$assetData = $assetDb->queryAll();
		$assetData = json_decode ( CJSON::encode ( $assetData ), TRUE );
		//对数据库as_consume进行关键字的模糊查询
		$consumeSql="select assetId,assetName,specification,brwPhone,COUNT(IF(state='in',TRUE,NULL)) AS inNum from (select * from as_consume where assetName like '%".$searchName."%')temp2 GROUP BY assetName,specification";
		//$consumeSql="select * from as_consume where assetName like '%".$searchName."%'";
		$consumeDb =Yii::app()->db->createCommand($consumeSql);
		$consumeData = $consumeDb->queryAll();
		$consumeData = json_decode ( CJSON::encode ( $consumeData ), TRUE );

		//合并数据
		$searchData=array_merge($assetData,$consumeData);
		exit(json_encode($searchData));
	}
}
?>
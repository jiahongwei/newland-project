<?php
//打开的文件都没有关闭操作
header("Content-type:text/html;charset=utf-8");//中文乱码解决
define ( PAGESIZE, 5 );
class AssetCheckController extends XAdminiBase
{
	//从汇总文件中拿出数据并在view中展示
	public function actionIndex()
	{
		$time=date('Y-m-d',time());
		$finalFile='log/'.$time.'.txt';//二维码、RFID盘点结果汇总文件
		$codeFile='log/'.$time.'-code.txt';//二维码文件名
		$rfidFile='log/'.$time.'-rfid.txt';//rfid文件名
		fopen($finalFile,'w');//每次比对都进行覆盖
		fopen($codeFile,'a');
		fopen($rfidFile,'a');

		$this->computeData($codeFile,'assetId');//比对二维码数据
		$this->computeData($rfidFile,'RFID');//比对rfid数据

		//从最终的汇总文件中拿出数据放入view中展示
		$data=file_get_contents($finalFile);
		$data=json_decode($data,true);
		//print_r($data);
		is_array ( $data ) ? null : $content = array (); // 防止空数组
		$this->render ( 'index', array (
			'data' => $data,
		) );
	}

	//数据比对
	function computeData($fileName,$condition)
	{
		//从文件中拿出数据并进行decode
		$clientData=file_get_contents($fileName);
		$clientData=json_decode($clientData,true);

		//从数据库中取出数据
		if($condition=='RFID')
		{
			$criteria = new CDbCriteria ();
			$dbData = AsAsset::model ()->findAll ( $criteria );
			$dbData = json_decode ( CJSON::encode ( $dbData ), TRUE );
		}else{
			$criteria = new CDbCriteria ();
			$dbData = AsConsume::model ()->findAll ( $criteria );
			$dbData = json_decode ( CJSON::encode ( $dbData ), TRUE );
		}

		//获取新增数据和正常数据
		$normalData=array();$normalIndex=0;//正常数据及其下标
		$newData=array();$newIndex=0;//新增数据及其下标
		for($i=0;$i<count($clientData);$i++)
		{
			$item=$clientData[$i];
			//$item=json_decode ($clientData[$i],TRUE);//json格式转成数组
			$flag=false;//标识RFID是否相同
			for($j=0;$j<count($dbData);$j++)
			{
				if($item[$condition]==$dbData[$j][$condition])//正常数据
				{
					$flag=true;
					$normalData[$normalIndex]=$dbData[$j];//存放在正常数据数组内
					$normalIndex++;
					break;
				}
			}
			if($flag==false)//新增数据
			{
				$item['flag']='新增';
				$newData[$newIndex]=$item;//存放在新增数据数组内
				$newIndex++;
			}
		}
		//获取丢失数据
		$lostData=array();
		$lostIndex=0;//丢失数据下标
		for($i=0;$i<count($dbData);$i++)
		{
			$flag=false;//标识RFID是否相同
			for($j=0;$j<count($normalData);$j++)
			{
				if($normalData[$j][$condition]==$dbData[$i][$condition])//未丢失数据
				{
					$flag=true;
					break;
				}
			}
			if($flag==false)//丢失数据
			{
				$dbData[$i]['flag']='丢失';
				$lostData[$lostIndex]=$dbData[$i];//存放在丢失数据数组内
				$lostIndex++;
			}
		}
		//存入操作文件
		$time=date('Y-m-d',time());
		$fileName='log/'.$time.'.txt';
		if(file_exists($fileName)==null)
		{
			$handle=fopen($fileName,'w');
			fclose($handle);
		};
		$lastData=file_get_contents($fileName);
		$lastData=json_decode($lastData,true);
		$currentData=array_merge($lostData,$newData);
		$handle=fopen($fileName,'w');
		if($lastData=='')//转化为json字符串写入文件
			fwrite($handle,json_encode($currentData));
		else
			fwrite($handle,json_encode(array_merge($currentData,$lastData)));
		//日志文件
		$logName=$time.'.log';
		$logHandle=fopen('log/'.$logName,'a');
		fwrite($logHandle,"RFID/assetId:(物品名称 型号 价格 所在仓库 入库时间 外借许可 外界电话 状态 标志)\r\n");
		$criteria = new CDbCriteria ();
		$dbData = AsConsume::model ()->findAll ( $criteria );
		$dbData = json_decode ( CJSON::encode ( $dbData ), TRUE );
		for($i=0;$i<count($currentData);$i++)
		{
			$value=$currentData[$i];
			if($value['RFID']=='')//assetId
				fwrite($logHandle,$value['assetId']);
			else
				fwrite($logHandle,$value['RFID']);
			fwrite($logHandle,':('.$value['specification'].' '.$value['Price'].' '
				.$value['storageId'].' '.$value['inTime'].' '.$value['outPrm'].' '.$value['brwPhone'].' '
				.$value['state'].' '.$value['flag'].')'."\r\n");
		}
	}

	//更新
	public function actionUpdate($sign,$condition) 
	{
		//向日志文件中写入更新信息
		$time=date('Y-m-d',time());
		$logName=$time.'.log';
		$logHandle=fopen('log/'.$logName,'a');

		if (XUtils::method () == 'POST') {
			if($sign=='RFID')
			{
				$asset = new AsAsset ();	
				$asset->RFID = $conditon;
				$asset->assetName = $_POST ['assetName'];
				$specification = $_POST ['specification'];
				if($specification=="小型"){
					$asset->specification="small";
				}elseif ($specification=="中型") {
					$asset->specification="middle";
				}else{
					$asset->specification="big";
				}
				$asset->state = $_POST ['state'];
				$asset->Price = $_POST ['Price'];
				$asset->storageId = $_POST ['storageId'];
				$asset->inTime = $_POST ['inTime'];
				$asset->outPrm = $_POST ['outPrm'];
				$asset->brwPhone = $_POST ['brwPhone'];
				$count = AsAsset::model ()->updateByPk ( $condition, array (
					'assetName' => $asset->assetName,
					'specification' => $asset->specification,
					'state' => $asset->state,
					'Price' => $asset->Price,
					'storageId' => $asset->storageId,
					'inTime' => $asset->inTime,
					'brwPhone' => $asset->brwPhone 
				) );
				if ($count > 0) {
					//向日志中写入更新信息
					fwrite($logHandle,'更新了数据库中RFID为'.$condition.'的信息'."\r\n");
					echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
				} else {
					echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
				}
			}else{
				$consume = new AsConsume ();	
				$consume->assetId = $conditon;
				$consume->assetName = $_POST ['assetName'];
				$specification = $_POST ['specification'];
				if($specification=="小型"){
					$consume->specification="small";
				}elseif ($specification=="中型") {
					$consume->specification="middle";
				}else{
					$consume->specification="big";
				}
				$consume->state = $_POST ['state'];
				$consume->Price = $_POST ['Price'];
				$consume->storageId = $_POST ['storageId'];
				$consume->inTime = $_POST ['inTime'];
				$consume->outPrm = $_POST ['outPrm'];
				$consume->brwPhone = $_POST ['brwPhone'];
				$count = AsConsume::model ()->updateByPk ( $condition, array (
					'assetName' => $consume->assetName,
					'specification' => $consume->specification,
					'state' => $consume->state,
					'Price' => $consume->Price,
					'storageId' => $consume->storageId,
					'inTime' => $consume->inTime,
					'brwPhone' => $consume->brwPhone 
				) );
				if ($count > 0) {
					//向日志中写入更新信息
					fwrite($logHandle,'更新了数据库中assetId为'.$condition.'的信息'."\r\n");
					echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
				} else {
					echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
				}
			}
			//更新文件	
		}
		if($sign=='RFID')
			$data = AsAsset::model ()->findByPk ( $condition );	
		else
			$data = AsConsume::model ()->findByPk ( $condition );	
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'update', array (
				'data' => $data 
		) );
	}

	//从数据库中删除信息
	public function actionDelete($sign,$condition)
	{
		//向日志文件中写入删除信息
		$time=date('Y-m-d',time());
		$logName=$time.'.log';
		$logHandle=fopen('log/'.$logName,'a');

		if($sign=='RFID')//处理RFID
		{
			//从数据库里删除
			$data =	AsAsset::model ()->findByPk($condition);
			$data = AsAsset::model ()->deleteByPk ( $condition );
			//根据当前日期获取文件名
			$time=date('Y-m-d',time());
			$fileName='log/'.$time.'.txt';
			//从文件中删除
			$data=file_get_contents($fileName);
			$data=json_decode($data,true);
			$flag=0;
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]['RFID']==$condition)
				{
					$flag=$i;
					break;
				}
			}
			array_splice($data,$flag,1);
			$handle=fopen($fileName,"w");
			fwrite($handle,json_encode($data));//转化为json字符串写入文件
			//向日志中写入删除信息
			fwrite($logHandle,'从数据库中删除：RFID为'.$condition.'的信息'."\r\n");
		}else{//处理assetId
			//从数据库里删除
			$data =	AsConsume::model ()->findByPk($condition);
			$data = AsConsume::model ()->deleteByPk ( $condition );
			//根据当前日期获取文件名
			$time=date('Y-m-d',time());
			$fileName='log/'.$time.'.txt';
			//从文件中删除
			$data=file_get_contents($fileName);
			$data=json_decode($data,true);
			$flag=0;
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]['assetId']==$condition)
				{
					$flag=$i;
					break;
				}
			}
			array_splice($data,$flag,1);
			$handle=fopen($fileName,"w");
			fwrite($handle,json_encode($data));//转化为json字符串写入文件
			//向日志中写入删除信息
			fwrite($logHandle,'从数据库中删除：assetId为'.$condition.'的信息'."\r\n");
		}
		//重新加载页面
		echo "<script language=\"JavaScript\">alert(\"删除成功\");parent.location.href='/cms_new/index.php?r=asset/assetCheck/index';</script>";
	}

	public function actionAdd($sign,$condition)
	{
		//向日志文件中写入删除信息
		$time=date('Y-m-d',time());
		$logName=$time.'.log';
		$logHandle=fopen('log/'.$logName,'a');

		//根据当前日期获取文件名
		$time=date('Y-m-d',time());
		$fileName='log/'.$time.'.txt';
		if($sign=='RFID')//向RFID内添加信息
		{
			//获取该RFID的整条信息
			$data=file_get_contents($fileName);
			$data=json_decode($data,true);
			$flag=0;//标示该RFID所在数组中的下标
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]['RFID']==$condition)
				{
					$flag=$i;
					break;
				}
			}
			$value=$data[$flag];
			//插入数据库
			$asset = new AsAsset (); // 资产数据库表
			$asset->RFID = $value['RFID']; // 提交页面的RFID的值
			$asset->assetName = $value['assetName'];
			$asset->specification = $value['specification'];
			$asset->state = 'in';
			//$asset->state = $value['state'];
			$asset->Price = $value['Price'];
			$asset->storageId = $value['storageId'];
			$asset->inTime = 1;//需要有
			$asset->outPrm = $value['outPrm'];
			$asset->brwPhone = $value['brwPhone'];
			if ($asset->save () > 0) { // 数据库表类的函数save（），存储是否成功，来自yii框架
				//更改文件中该RFID的信息标志
				$data[$flag]['flag']='正常';
				//重新写入文件
				$handle=fopen($fileName,"w");
				fwrite($handle,json_encode($data));//转化为json字符串写入文件
				//向日志中写入添加信息
				fwrite($logHandle,'向数据库中添加：RFID为'.$condition.'的信息'."\r\n");
				//$this->actionIndex();//刷新存在问题
				echo "<script language=\"JavaScript\">alert(\"添加成功\");parent.location.href='/cms_new/index.php?r=asset/assetCheck/index';</script>";
				//$this->redirect('/cms_new/index.php?r=asset/assetCheck/index');
			} else {
				echo "<script language=\"JavaScript\">alert(\"添加失败\");</script>";
			}
		}else{//向assetId内添加信息
			//获取该条assetId的整条信息
			$data=file_get_contents($fileName);
			$data=json_decode($data,true);
			$flag=0;//标示该RFID所在数组中的下标
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]['assetId']==$condition)
				{
					$flag=$i;
					break;
				}
			}
			$value=$data[$flag];
			//插入数据库
			$consume = new AsConsume (); // 资产数据库表
			$consume->assetId = $value['assetId']; // 提交页面的RFID的值
			$consume->assetName = $value['assetName'];
			$consume->specification= $value['specification'];
			$consume->state = $value['state'];
			$consume->Price = $value['Price'];
			$consume->storageId = $value['storageId'];
			$consume->inTime = 1;
			$consume->outPrm = $value['outPrm'];
			$consume->brwPhone = $value['brwPhone'];
			if ($consume->save () > 0) { // 数据库表类的函数save（），存储是否成功，来自yii框架
				//更改文件中该RFID的信息标志
				$data[$flag]['flag']='正常';
				//重新写入文件
				$handle=fopen($fileName,"w");
				fwrite($handle,json_encode($data));//转化为json字符串写入文件
				//向日志中写入添加信息
				fwrite($logHandle,'向数据库中添加：assetId为'.$condition.'的信息'."\r\n");
				echo "<script language=\"JavaScript\">alert(\"添加成功\");parent.location.href='/cms_new/index.php?r=asset/assetCheck/index';</script>";
			} else {
				echo "<script language=\"JavaScript\">alert(\"添加失败\");</script>";
			}
		}
	}
}	
?>

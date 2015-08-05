<?php
include('phpqrcode.php');
define ( PAGESIZE, 15);
/**
 * 资产管理
 * 增删改查
 *
 * @author 徐晨阳 赵军 汤杰
 * @link localhost/index.php?r=asset/assetManage/findAll
 * @link localhost/index.php?r=asset/assetManage/add
 */
class AssetManageController extends XAdminiBase {
	// public function actionReadFile()
	// {
	// 	$data=file_get_contents("addConusme.txt");
	// 	$data=json_decode($data,true);	
	// 	print_r($data['assetName']);
	// }
	public function QrCode($assetId,$data,$display){
		//split出display中的内容
		$displayArr=split('/', $display);	
		$display='编号：'.$displayArr[0].PHP_EOL.'名称：'.$displayArr[1].PHP_EOL.'型号：'.$displayArr[2];

		// 二维码数据 
		// $data = 'helloworld'; 
		// 生成的文件名（路径） 
		$codeTemp = 'qrCode/codeTemp.png'; 
		// 纠错级别：L、M、Q、H 
		$errorCorrectionLevel = 'L';  
		// 点的大小：1到10 
		$matrixPointSize = 4;  
		//创建一个二维码文件 
		QRcode::png($data, $codeTemp, $errorCorrectionLevel, $matrixPointSize, 2);
		//输入二维码到浏览器
		//QRcode::png($data);
		//获取图片的宽高
		$size = getimagesize($codeTemp);
		$width=$size[0];
		$height = $size[1];

		//生成文本图片
		$textTemp='qrCode/textTemp.png';
		$im = imagecreate($width,60);//图片的宽度高度
		$black = ImageColorAllocate($im, 255,255,2555);//背景颜色
		$white = ImageColorAllocate($im, 0,0,0);//字体颜色
		ImageTTFText($im, 10, 0, 10, 20, $white, "simhei.ttf", $display);
		imagepng($im,$textTemp);

		//图片拼接
		$bigphoto = $codeTemp;
    	$footerphoto = $textTemp;
    	$biginfo = getimagesize($bigphoto);
    	$footerinfo = getimagesize($footerphoto);
     
    	$bigwidth = $biginfo[0];
    	$bigheight = $biginfo[1];
     
    	$footerwidth = $footerinfo[0];
    	$footerheight= $footerinfo[1];
     
    	$initwidth = max(array($bigwidth,$footerwidth));
    	$initheight = max(array($bigheight,$footerheight))+ min(array($bigheight,$footerheight));
     
    	// header("Content-type: image/png");     
    	$im = imagecreatetruecolor($initwidth,$initheight); 
    	imagecopyresized($im,imagecreatefrompng($bigphoto),0, 0, 0, 0,$bigwidth,$bigheight,$bigwidth,$bigheight);  
    	imagecopyresized($im,imagecreatefrompng($footerphoto),0,$bigheight, 0, 0,$footerwidth,$footerheight,$footerwidth,$footerheight);
    	$num = rand(0,1000);
		// echo var_dump($num);
		$finalQRCode = "qrCode/finalQRCode".$num.".jpeg";
		// session_start();
		// $_SESSION["finalQRCode"]=$finalQRCode;
    	imagepng($im,$finalQRCode);
    	return $finalQRCode;
    	// echo "<script language=\"JavaScript\">alert(\"添加成功\");</script>";
    	// $this->render('add',array('type' => $type));
	}
	public function actionAdd() 	// 资产添加
	{
		if (XUtils::method () == 'POST') {
			HDraw::deleteQRCode();
			// echo var_dump($_POST);
			if (isset($_POST['type'])) {
				$type = $_POST ['type'];
				if ($type=='static') {
					$test=AsAsset::model()->findByPk($_POST ['RFID']);
					// echo var_dump($test);
					if(is_null($test)){
						$asset = new AsAsset (); // 资产数据库表
						$asset->RFID = $_POST ['RFID']; // 提交页面的RFID的值
						$asset->assetName = $_POST ['assetName'];
						// $asset->state=$_POST['state'];
						$asset->specification = $_POST ['specification'];
						$asset->Price = $_POST ['Price'];
						$asset->storageId = $_POST ['storageId'];
						$asset->inTime = $_POST ['inTime'];
						$asset->outPrm = $_POST ['outPrm'];
						if ($asset->outPrm == 'n') {
							$asset->state = "in";
						}else{
							$asset->state=$_POST['state'];
						}
						$asset->brwPhone = "";
						$test=AsAsset::model()->findByPk($RFID);
						// echo var_dump($asset);
						if ($asset->save () > 0) { // 数据库表类的函数save（），存储是否成功，来自yii框架
							echo "<script language=\"JavaScript\">alert(\"添加成功\");</script>";
						} else {
							echo "<script language=\"JavaScript\">alert(\"添加失败\");</script>";
						}
					}else{
						echo "<script language=\"JavaScript\">alert(\"该标签已存在\");</script>";
					}
				}else if($type=='consume'){	
					$test=AsConsume::model()->findByPk($_POST ['assetId']);
					if(is_null($test)){
						$consume = new AsConsume (); // 资产数据库表
						$consume->assetId = $_POST['assetId'];
						$consume->assetName = $_POST ['assetName'];
						$consume->specification = $_POST ['specification'];
						$consume->Price = $_POST ['Price'];
						$consume->state=$_POST['state'];
						$consume->storageId = $_POST ['storageId'];
						$consume->inTime = $_POST ['inTime'];
						$consume->outPrm = "y";
						$consume->brwPhone = "";
						$content = "assetId:".$consume->assetId.";assetName:".$consume->assetName.";specification:".$consume->specification.";Price:".$consume->Price.";storageId:".$consume->storageId.";outPrm:".$consume->outPrm.";brwPhone:".$consume->brwPhone.";state:".$consume->state.";inTime:".$consume->inTime.";";
						$display = $consume->assetId.'/'.$consume->assetName.'/'.$consume->specification;
						// echo var_dump($consume);
						if ($consume->save () > 0) { // 数据库表类的函数save（），存储是否成功，来自yii框架
							echo "<script language=\"JavaScript\">alert(\"添加成功\");</script>";
						 	$finalQRCode = $this -> QRcode ( $consume->assetId , $content ,$display);
						} else {
							echo "<script language=\"JavaScript\">alert(\"添加失败\");</script>";
						}
					}else{
						echo "<script language=\"JavaScript\">alert(\"该编号已经存在\");</script>";
					}
				}
			}
		}
		if($type==""){
			$type="static";
		}
		// var_dump($consume['']);
		$this->render ( 'add' ,array ('type' => $type,'finalQRCode'=>$finalQRCode,'consume'=>$consume));

	}
	public function actionFindAll() {
		// 分页取数据
		// $criteria = new CDbCriteria ();
		// var_dump($_POST);
		$queryName = "按资产编号查询";
		if($name==""){
			$name="as_asset";
			$type="static";
			$queryName = "按RFID查询";
		}
		if(isset($_REQUEST['type'])){
			$type=$_REQUEST['type'];
			if($type=="static"){
				$name="as_asset";
				$quality =  "RFID";
				$queryName = "按RFID查询";
			}else{
				$name="as_consume";
				$quality =  "assetId";
				$queryName = "按资产编号查询";
			}
		}
		$sql = "SELECT assetName,specification,COUNT(IF(state='in',TRUE,NULL)) AS c1,COUNT(IF(state='out',TRUE,NULL)) AS c2 from ".$name." GROUP BY assetName,specification";

		//$criteria->select = 'assetName,specification,COUNT(IF(state="in",TRUE,NULL)) AS c1,COUNT(IF(state="out",TRUE,NULL)) AS c2';
		//$criteria->group = 'assetName,specification';	
		if (XUtils::method () == 'POST') {
			if (isset ( $_POST ['subQuery'] )) {
				// data改一下
				if (isset ( $_POST ['queryType'] ) && (($_POST ['content'] != null)||($_POST ['RFID'] != null))) {
					$queryType = $_POST ['queryType'];
					// var_dump($queryType);
					if ($queryType == 'queryByName') {
						//$criteria->addCondition ( "assetName=:assetName" ); // 查询条件，即where id = 1
						//$criteria->params [':assetName'] = $_POST ['content'];
						$sql = "SELECT assetName,specification,COUNT(IF(state='in',TRUE,NULL)) AS c1,COUNT(IF(state='out',TRUE,NULL)) AS c2 from ".$name." where assetName like '%".$_POST['content']."%' GROUP BY assetName,specification";
					} else if ($queryType == 'queryBySp') {
						//$criteria->addCondition ( "specification=:specification" ); // 查询条件，即where id = 1
						//$criteria->params [':specification'] = $_POST ['content'];
						$sql = "SELECT assetName,specification,COUNT(IF(state='in',TRUE,NULL)) AS c1,COUNT(IF(state='out',TRUE,NULL)) AS c2 from ".$name." where specification like '%".$_POST['content']."%' GROUP BY assetName,specification";
					} else if ($queryType == 'queryById') {
						$sql = "SELECT * FROM ".$name." WHERE ".$quality." = '".$_POST['RFID']."'";
					}
				}
			}
		}
		$result = Yii::app ()->db->createCommand ( $sql )->queryAll ();
		$count = count($result);
		// $sql1 = "SELECT COUNT(DISTINCT assetName,specification) FROM ".$name;
		// $count =  Yii::app ()->db->createCommand ( $sql1 )->queryScalar ();
		$pages = new CPagination ( $count );
		$pages->pageSize = PAGESIZE;
		$pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		$pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		$pdata->bindValue(':limit', $pages->pageSize);
		$data = $pdata->queryAll();
		// var_dump($data);
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'findAll', array (
				'data' => $data,
				'pages' => $pages,
				'type' =>$type,
				'queryType'=>$queryType,
				'queryName'=>$queryName,
				'content'=>$_POST['content'],
				'RFID'=>$_POST['RFID']
		) );
	}

	public function actionUpdate($RFID) {
		if (XUtils::method () == 'POST') {
			$asset = new AsAsset ();	
			$asset->RFID = $RFID;
			$asset->assetName = $_POST ['assetName'];
			$asset->specification = $_POST ['specification'];
			$asset->state = $_POST ['state'];
			$asset->Price = $_POST ['Price'];
			$asset->storageId = $_POST ['storageId'];
			$asset->inTime = $_POST ['inTime'];
			$asset->outPrm = $_POST ['outPrm'];
			$asset->brwPhone = $_POST ['brwPhone'];
			$count = AsAsset::model ()->updateByPk ( $RFID, array (
					'assetName' => $asset->assetName,
					'specification' => $asset->specification,
					'state' => $asset->state,
					'Price' => $asset->Price,
					'outPrm' => $asset->outPrm,
					'storageId' => $asset->storageId,
					'inTime' => $asset->inTime,
					'brwPhone' => $asset->brwPhone 
			) );
			if ($count > 0) {
				echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
			} else {
				echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
			}
		}
		$data = AsAsset::model ()->findByPk ( $RFID );
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'update', array (
				'data' => $data 
		) );
	}
	public function actionShowAsset($assetName,$specification,$type) {
		if ($type=="static") {
			$criteria = new CDbCriteria ();
			$criteria->select = '*';
			$criteria->addCondition ( 'assetName=:assetName' );
			$criteria->params [':assetName'] = $assetName;
			$criteria->addCondition ( 'specification=:specification' );
			$criteria->params [':specification'] = $specification;
			$count = AsAsset::model ()->count ( $criteria );
			$pages = new CPagination ( $count );
			$pages->pageSize = PAGESIZE;
			$pages->applyLimit ( $criteria );
			$data = AsAsset::model ()->findAll ( $criteria );
			$data = json_decode ( CJSON::encode ( $data ), TRUE );
			is_array ( $data ) ? null : $data = array ();
		}else{
			$criteria = new CDbCriteria ();
			$criteria->select = '*';
			$criteria->addCondition ( 'assetName=:assetName' );
			$criteria->params [':assetName'] = $assetName;
			$criteria->addCondition ( 'specification=:specification' );
			$criteria->params [':specification'] = $specification;
			$count = AsConsume::model ()->count ( $criteria );
			$pages = new CPagination ( $count );
			$pages->pageSize = PAGESIZE;
			$pages->applyLimit ( $criteria );
			$data = AsConsume::model ()->findAll ( $criteria );
			$data = json_decode ( CJSON::encode ( $data ), TRUE );
			is_array ( $data ) ? null : $data = array ();
		}
		// $data=AsAsset::model()->findAllByAttributes(array('assetName'=>$assetName,'specification'=>$specification));
		// $data = json_decode ( CJSON::encode ( $data ), TRUE );
		// //echo var_dump($data);
		// $count = count($data);
		// $pages = new CPagination ( $count );
		// $pages->pageSize = PAGESIZE;
		// $pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		// $pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		// $pdata->bindValue(':limit', $pages->pageSize);
		// $data = $pdata->queryAll();


		// is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'showAsset', array (
				'data' => $data,
				'pages' => $pages,
				'type' => $type
		) );
	}
	public function actionDeleteClass($assetName,$specification,$type) {
		if ($type == 'static') {
			$name = 'as_asset';
		}else{
			$name = 'as_consume';
		}
		$sql = "DELETE FROM ".$name." WHERE assetName=:assetName AND specification=:specification";
		$data =Yii::app ()->db->createCommand ( $sql )->execute(array (':assetName' => $assetName , ':specification' => $specification));
		if ($type=='static') {
			header("Location:index.php?r=asset/assetManage/findAll&type=static");
		}else{
			header("Location:index.php?r=asset/assetManage/findAll&type=consume");
		}
		//登陆成功在这里转向 
		// $data =	AsAsset::model ()->findByPk($RFID);
		// $assetName=$data['assetName'];
		// $specification=$data['specification'];
		// $data = AsAsset::model ()->deleteByPk ( $RFID );
		// echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
		// echo "<script>alert('删除成功!');history.back();</script>";
		// $sql = "SELECT assetName,specification,COUNT(IF(state='in',TRUE,NULL)) AS c1,COUNT(IF(state='out',TRUE,NULL)) AS c2 from ".$name." GROUP BY assetName,specification";
		// $sql1 = "SELECT COUNT(DISTINCT assetName,specification) FROM ".$name;
		// $count =  Yii::app ()->db->createCommand ( $sql1 )->queryScalar ();
		// $pages = new CPagination ( $count );
		// $pages->pageSize = PAGESIZE;
		// $pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
		// $pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
		// $pdata->bindValue(':limit', $pages->pageSize);
		// $data = $pdata->queryAll();

		// $data = json_decode ( CJSON::encode ( $data ), TRUE );
		// is_array ( $data ) ? null : $data = array (); // 防止空数组
		// $this->render ( 'findAll', array (
		// 		'data' => $data,
		// 		'pages' => $pages,
		// 		'type' =>$type
		// ) );
	}
	public function actionDelete($RFID) {
		$data =	AsAsset::model ()->findByPk($RFID);
		$assetName=$data['assetName'];
		$specification=$data['specification'];
		$data = AsAsset::model ()->deleteByPk ( $RFID );
		echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
		$data=AsAsset::model()->findAllByAttributes(array('assetName'=>$assetName,'specification'=>$specification));
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'showAsset', array (
				'data' => $data,
				'type' => 'static'
		) );
	}
	public function actionDeleteConsume($assetId) {
		$data =	AsConsume::model ()->findByPk($assetId);
		$assetName=$data['assetName'];
		$specification=$data['specification'];
		$data = AsConsume::model ()->deleteByPk ( $assetId );
		echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
		$data=AsConsume::model()->findAllByAttributes(array('assetName'=>$assetName,'specification'=>$specification));
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'showAsset', array (
				'data' => $data,
				'type' => 'consume'
		) );
	}

	/**
	 * 资产借出操作
	 *
	 * @author 张钰、徐晨阳
	 * @param
	 *        	资产名称
	 * @todo 显示资产借出页面，允许向AsApply表中增加新借出纪录，同时根据（资产名称-学生id）删除AsApply中已有的申请记录
	 */
	public function actionBorrow($assetName,$specification,$totalNum,$type,$applyId="",$assetId="",$RFID="") {
		if($type=="static"){
			$sql = "SELECT COUNT(IF(state='in',TRUE,NULL)) from as_asset where specification=:specification and assetName=:assetName";
		}else{
			$sql = "SELECT COUNT(IF(state='in',TRUE,NULL)) from as_consume where specification=:specification and assetName=:assetName";
		}
		$totalNum =  Yii::app ()->db->createCommand ( $sql )->queryScalar(array (':specification'=>$specification,':assetName'=>$assetName));
		
		if (XUtils::method () == 'POST') {
			// var_dump($_POST);
			$verify = "SELECT * FROM st_admin WHERE id = ".$_POST['userId']." AND name = '".$_POST['userName']."'";
			$userData =  Yii::app ()->db->createCommand($verify)->queryAll();
			$userData= json_decode ( CJSON::encode ( $userData ), TRUE );
			if (!empty($userData)) {
			
			// var_dump($userData);
			//添加借出信息到借出表中
			$borrow= new AsBorrow ();
			$borrow->assetName = $assetName;
			$borrow->assetSpecification = $specification;
			$borrow->userTeleNum=$_POST['userTeleNum'];
			$borrow->userId=$_POST['userId'];
			$borrow->userName=$_POST['userName'];
			$borrow->type=$type;
			$borrow->assetID=$_POST['assetId'];
			$borrow->borrowTime=$_POST['borrowTime'];
			$borrow->returnTime=$_POST['returnTime'];
			if($totalNum>0){
				if($type=="static"){
					$asset=AsAsset::model()->findByPk($borrow->assetID);
				  if (empty($asset)) {
						echo "<script language=\"JavaScript\">alert(\"改标签未注册！\");</script>";
				  }else{
					if($asset['outPrm']=='y'){
						if($asset['assetName']==$borrow->assetName && $asset['specification']==$borrow->assetSpecification){
							if($borrow->save () > 0){
								$count = AsAsset::model ()->updateByPk ($borrow->assetID,array('state'=>'out','brwPhone'=> $borrow->userTeleNum));
								if ($count > 0) {
									$data = AsApply::model ()->deleteByPk ( $applyId );
									echo "<script language=\"JavaScript\">alert(\"借出成功\");</script>";
								} else {
									echo "<script language=\"JavaScript\">alert(\"借出失败\");</script>";
								}
							}
						}else{
							echo "<script language=\"JavaScript\">alert(\"信息不符\");</script>";
						}
					}else{
						echo "<script language=\"JavaScript\">alert(\"该商品不允许被借出\");</script>";
					}
				  }
				}elseif ($type=="consume") {
				  $asset=AsConsume::model()->findByPk($borrow->assetID);
				  if (empty($asset)) {
						echo "<script language=\"JavaScript\">alert(\"改标签未注册！\");</script>";
				  }else{
					if($asset['outPrm']=='y'){
						if($asset['assetName']==$borrow->assetName && $asset['specification']==$borrow->assetSpecification){
							if($borrow->save () > 0){
								$count = AsConsume::model ()->updateByPk ($borrow->assetID,array('state'=>'out'));
								if ($count > 0) {
									$data = AsApply::model ()->deleteByPk ( $applyId );
									echo "<script language=\"JavaScript\">alert(\"借出成功\");</script>";
								} else {
									echo "<script language=\"JavaScript\">alert(\"借出失败\");</script>";
								}
							}
						}else{
							echo "<script language=\"JavaScript\">alert(\"信息不符\");</script>";
						}
					}else{
						echo "<script language=\"JavaScript\">alert(\"该商品不允许被借出\");</script>";
					}
				  }
				}
			}else{
				echo "<script language=\"JavaScript\">alert(\"该商品没有库存\");</script>";
			}
		}else{
				echo "<script language=\"JavaScript\">alert(\"借出人信息不符\");</script>";
		}
		}
		// echo var_dump($totalNum);
		// if($totalNum>0){
		$this->render ( 'borrow', array (
			'assetName' => $assetName,
			'specification' => $specification,
			'totalNum' => $totalNum,
			'type'=>$type,
			'assetID'=>$assetID,
			'RFID'=>$RFID,
			'userId'=>$borrow->userId,
			'userName'=>$borrow->userName,
			'userTeleNum'=>$borrow->userTeleNum,
			'applyId'=>$applyId
		) );
	}
	/**
	 * 资产归还操作
	 *
	 * @author 张钰,汤杰
	 * @param
	 *        	RFID
	 * @todo 删除AsApply表中的相关记录，添加到AsReturned表中
	 */
	public function actionReturn(){
		if (XUtils::method () == 'POST'&&$_POST['return']=='确认归还'){
			
			$RFID = $_POST['RFID'];
			
			
			// var_dump($_POST['RFID']);
			$asset = AsAsset::model ()->findByPk ($RFID);
			if($asset['state']=='out'){
				$count = AsAsset::model ()->updateByPk ($RFID,array('state'=>'in'));
				if ($count > 0) {
					date_default_timezone_set('UTC');
					$sql = "UPDATE as_borrow SET returnTime=:returnTime WHERE assetID =:assetID";
					Yii::app ()->db->createCommand ( $sql )->execute(array (':returnTime' => date('Y-m-d'),':assetID' => $RFID));
					// $sql = "SELECT * FROM as_borrow WHERE assetID =:assetID";
					// $data =Yii::app ()->db->createCommand ( $sql )->queryAll();
					// $data=AsBorrow::model()->findAll("assetID =:assetID",array (":assetID"=>$RFID));
					$data=AsBorrow::model()->findAll("assetID =:assetID",array (":assetID"=>$RFID));
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$mes = "借出号:".$data[0]['borrowId']." 借出人ID:".$data[0]['userId']." 借出人姓名:".$data[0]['userName']." 电话:".
					$data[0]['userTeleNum']." 资产名称:".$data[0]['assetName']." 资产ID:".$data[0]['assetID']." 借出时间:".$data[0]['borrowTime']." 归还时间:".$data[0]['returnTime']; 
					yii::log ($mes,"info","borrow.log");

					$analyse=new AsAnalyse();
					$analyse->assetID=$data[0]['assetID'];
					$analyse->assetName=$data[0]['assetName'];
					$analyse->type=$data[0]['type'];
					$analyse->assetSpecification=$data[0]['assetSpecification'];
					$analyse->borrowTime=$data[0]['borrowTime'];
					$analyse->returnTime=$data[0]['returnTime'];
					// echo var_dump($analyse);	
					if($analyse -> save()>0){
						$sql = "DELETE FROM as_borrow WHERE assetID=:assetID";
						$data =Yii::app ()->db->createCommand ( $sql )->execute(array (':assetID' => $RFID));
						//$borrow->updateAll(array('assetID'=>$RFID),'returnTime=:returnTime',array(':returnTime'=> date('Y-m-d')));
						echo "<script language=\"JavaScript\">alert(\"归还成功\");</script>";
					}else{
						echo "<script language=\"JavaScript\">alert(\"分析记录失败\");</script>";
					}
					// $sql = "DELETE FROM as_borrow WHERE assetID=:assetID";
					// $data =Yii::app ()->db->createCommand ( $sql )->execute(array (':assetID' => $RFID));
					// echo "<script language=\"JavaScript\">alert(\"归还成功\");</script>";
				} else {
					echo "<script language=\"JavaScript\">alert(\"归还失败\");</script>";
				}
			}else{
				echo "<script language=\"JavaScript\">alert(\"该设备未被借出\");</script>";
			}
		}
		elseif(XUtils::method () == 'POST'&&$_POST['return']=='查看')
		{
			$RFID = $_POST['RFID'];
			$sql = "SELECT * FROM as_asset,as_borrow WHERE as_asset.RFID = '".$RFID."' and as_borrow.assetID = '".$RFID."'";
			// echo $sql;
			$data =  Yii::app ()->db->createCommand($sql)->queryAll();
			$data= json_decode ( CJSON::encode ( $data ), TRUE );
			// var_dump($data);


		}
		$this->render('return',array('RFID'=>$_POST['RFID'],
									 'assetName'=>$data[0]['assetName'],
									 'specification'=>$data[0]['specification'],
									 'inTime'=>$data[0]['inTime'],
									 'storageId'=>$data[0]['storageId'],
									 'price'=>$data[0]['Price'],
									 'name'=>$data[0]['userName']
									));
	}

	public function actionSearch()
	{
		$type = 'static';
		if (XUtils::method () == 'POST'){
			// var_dump($_POST);
			if (isset($_POST['type']))
				$type = $_POST['type'];

			if ($type=='static') {
				$data = AsAsset::model ()->findByPk ( $_POST['RFID'] );
			}
			else
				$data = AsConsume::model ()->findByPk ( $_POST['assetID'] );

			$data = json_decode ( CJSON::encode ( $data ), TRUE );

			// is_array ( $data ) ? null : $data = array (); // 防止空数组
			// $this->render ( 'search', array (
			// 	'data' => $data 
			// ) );
		}
		$this->render ('search',array('data'=>$data,
									  'type'=>$type
									  ));

	}


}
?>
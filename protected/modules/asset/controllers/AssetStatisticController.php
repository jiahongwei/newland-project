<?php
define ( PAGESIZE, 5 );
define ( GRAGHSIZE, 14 );
define ( HEISIZE, 500 );
define ( LENHSIZE, 700 );
define ( UP, 70 );
define ( DOWN, 150 );
define ( LEFT, 100 );
define ( RIGHT, 70 );


define(x_name,"");
/**
 * 能耗数据统计
 * @author  赵军
 * @link localhost/index.php?r=asset/assetStatistic/index
 * 
 */
// error_reporting(0);
define('time', 86400);
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_bar.php");
include ("jpgraph/jpgraph_pie.php");
include ("jpgraph/jpgraph_line.php");  
include ("jpgraph/jpgraph_pie3d.php"); 
class assetStatisticController extends XAdminiBase
{

	
	

	public function actionIndex()
	{
		if (XUtils::method () == 'POST') {
			if (isset ( $_POST ['analyseType'] )){
				// echo  var_dump( $_POST ['analyseType']);
				 // echo var_dump($_SESSION["name"].".......");
				HDraw::deletePic();//删除历史图片
				$analyseType=$_POST['analyseType'];
				if($analyseType=="1"){
					$sql="SELECT assetName,COUNT(*) as c1 from as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND borrowTime<='".$_POST['outTime']."' GROUP BY assetName ORDER BY COUNT(*) DESC LIMIT 0,10";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$data_x=array ();
					$data_y=array ();
					foreach ($data as $key => $value) {
						$data_x[]=$value['assetName'];
						$data_y[]=$value['c1'];
						
					}
					// echo var_dump($data);
					$x_title = x_name;
					// $y_title = "                            数次出借";
					$graph_title = "借出次数排序图前十(单位:次)";
					// echo var_dump($data_x);
					// echo var_dump($data_y);
					// echo var_dump(empty($data_x));
					 if (empty($data_x)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					} else {
						$max_y = max($data_y);
						$name = HDraw::HistogramShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y);
					}

					
				}elseif ($analyseType=="2") {
					$sql="SELECT assetName,COUNT(*) as c1 from as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND borrowTime<='".$_POST['outTime']."' GROUP BY assetName ORDER BY COUNT(*) ASC LIMIT 10";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$data_x=array ();
					$data_y=array ();
					foreach ($data as $key => $value) {
						$data_x[]=$value['assetName'];
						$data_y[]=$value['c1'];
						
					}
					// echo var_dump($data);
					
					$x_title = x_name;
					// $y_title = "                            数次出借";
					$graph_title = "借出次数排序图后十(单位:次)";
					// echo var_dump($data_x);
					// echo var_dump($data_y);
					// echo var_dump(empty($data_x));
					 if (empty($data_x)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					} else {

						$max_y = max($data_y);
						$name = HDraw::HistogramShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y);
					}
					
				}elseif ($analyseType=="3") {
					$sql = "SELECT assetName,COUNT(*) as c1 from as_asset WHERE assetName in(SELECT assetName from as_analyse) GROUP BY assetName";
					$sql_ast = "SELECT assetName,borrowTime,returnTime from as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND borrowTime<='".$_POST['outTime']."'";
					$data1 =  Yii::app ()->db->createCommand($sql_ast)->queryAll();
					$data1 = json_decode ( CJSON::encode ( $data1 ), TRUE );
					// echo var_dump($data1);
					$data_x = array ();
					$data_y = array ();
					$data_name = array ();
					$data_num = array ();
					$date_each = array ();
					$date_sum = array ();
					if (empty($data1)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					} else {
					foreach ($data1 as $key => $value) {
						$data_name[]=$value['assetName'];
						if ($value['returnTime']<$_POST['outTime']) {
							$date_each[] = (strtotime($value['returnTime'])-strtotime($value['borrowTime']))/time+1;
						}
						else
							$date_each[] = (strtotime($_POST['outTime'])-strtotime($value['borrowTime']))/time+1;
										
					}
					// echo var_dump($data_name);
					// echo var_dump($date_each);
					$date = strtotime($_POST['outTime'])-strtotime($_POST['inTime']);
					$date = $date/time;
					// echo var_dump($date);
					$flog = 0;
					$data2 = Yii::app ()->db->createCommand($sql)->queryAll();
					$data2 = json_decode ( CJSON::encode ( $data2 ), TRUE );

					// echo var_dump($data2);

					foreach ($data2 as $key => $value) {
						if(in_array($value['assetName'], $data_name)){
								$data_x[]=$value['assetName'];
								$data_num[]=$value['c1'];
								foreach ($data1 as $key1 =>$value1) {
								// echo var_dump($date_each[$key]);
									if ($value1['assetName']==$data_x[$flog]) {
										// echo var_dump($key1);
										// echo var_dump($flog);
										$date_sum[$flog] +=$date_each[$key1];
										// echo var_dump($date_sum[$flog]);
									}
								}
								
								$data_y[$flog] = $date_sum[$flog]/($data_num[$flog]*$date);
								// echo var_dump($data_y[$key]);
								$flog++;				
							 }
						}

						
					array_multisort($data_y,SORT_DESC,$data_x);
					// echo var_dump($data_y);
					$max_y = max($data_y);
					$x_title = x_name;
					// $y_title = "                            率用占";
					$graph_title = "资产占用率排序图";
					 
						$name = HDraw::HistogramShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y);
					}
				}elseif ($analyseType=="4") {
					$sql="SELECT assetName,COUNT(*) as c1 from as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND returnTime<='".$_POST['outTime']."' GROUP BY assetName ORDER BY COUNT(*) LIMIT 0,10";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$piedata = array ();
					$piename = array ();
					// var_dump($data);
					$location = 9;
					$ages = array();
					foreach ($data as $value) {
					    $ages[] = $value['c1'];
					}
 
					array_multisort($ages, SORT_DESC, $data);
					// echo var_dump($data);
					foreach ($data as $key => $value) {
						if ($key<$location) {
							$piename[]=$value['assetName'];
							$piedata[]=$value['c1'];
						}
						else
						{
							$piedata[$location] += $value['c1'];
							$piename[$location] = "其他";
						}
						
						
					}

					
					// foreach ($data as $key => $value) {
					// 	$piename[]=$value['assetName'];
					// 	$piedata[]=$value['c1'];
						
					// }
					// echo var_dump($piedata);
					$title = "借出次数统计结果           ";
					if (empty($piedata)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					} else {
						$name = HDraw::pieShow($piedata,$piename,$title);
					}
				}
				elseif ($analyseType=="5") {
					$sql="SELECT assetName,borrowTime,COUNT(*) as c1 from as_analyse WHERE assetName='".$_POST ['assetName']."' GROUP BY DATE_FORMAT(borrowTime, '%Y%M')";
					// echo var_dump($_POST ['assetName']);
					$sql1 = "SELECT assetName FROM as_asset WHERE assetName='".$_POST ['assetName']."'";
					$name1 =  Yii::app ()->db->createCommand($sql)->queryAll();
					$name1 = json_decode ( CJSON::encode ( $name1 ), TRUE );
					
					$name2 =  Yii::app ()->db->createCommand($sql1)->queryAll();
					$name2 = json_decode ( CJSON::encode ( $name2 ), TRUE );

					$judge = 1;
					if (empty ( $name1)) {

						if (!empty ( $name2)) {
						echo "<script language=\"JavaScript\">alert(\"该资产年内没有接出！\");</script>";
						}
						else{
							$judge = 0;
						echo "<script language=\"JavaScript\">alert(\"资产名称输入有误，重新的输入！\");</script>";
					
						}
						// $judge = 0;
						// echo "<script language=\"JavaScript\">alert(\"资产名称输入有误，重新的输入！\");</script>";
					}
					else{
						$data_y = array(0,0,0,0,0,0,0,0,0,0,0,0);
					$months = array();
					foreach ($name1 as $key => $value) {
						
						$months[] = date("m",strtotime($value['borrowTime']));
						$data_y[(int)$months[$key]-1] =$value['c1'];
					}
					// echo var_dump($months);
					$x_title = "月份";
					$y_title = "次数";
					$graph_title = " ".$_POST ['assetName']."年内每月借出次数变化图(单位：次)";
					$data_x=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");
					$name = HDraw::linerShow($data_x,$data_y,$x_title,$y_title,$graph_title);
					}

					
					
				}
				elseif ($analyseType=="7") {

					if (empty($_POST['inTime'])||empty($_POST['outTime'])) {
						echo "<script language=\"JavaScript\">alert(\"请输入时间！\");</script>";
					}
					elseif ($_POST['inTime']>$_POST['outTime']) {
						echo "<script language=\"JavaScript\">alert(\"开始时间大于截止日期，请重新输入！\");</script>";
					}
					else{
						// $criteria = new CDbCriteria ();
					 	// $count = AsAsset::model ()->count ( $criteria );

					 	// $pages = new CPagination ( $count );
					 	// $pages->pageSize = PAGESIZE;
					 	// $pages->applyLimit ( $criteria );
						$flog = 7;
						$sql = "SELECT assetName,RFID,storageId,specification,inTime FROM as_asset WHERE assetName not in(SELECT assetName FROM as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND returnTime<='".$_POST['outTime']."') LIMIT 0,15";
						$data7 =  Yii::app ()->db->createCommand($sql)->queryAll();
						$data = json_decode ( CJSON::encode ( $data7 ), TRUE );
					}

					
					
				}
				elseif ($analyseType=="8") {
					$sql1="SELECT assetName,scrapeTime,specification,COUNT(*) as c2 FROM as_asset WHERE assetName='".$_POST ['assetName']."' and scrapeTime<=CURDATE() and scrapeTime >=DATE_SUB(CURDATE(),INTERVAL dayofyear(now())-1 DAY) GROUP BY specification";
					$test =  Yii::app ()->db->createCommand($sql1)->queryAll();
					$test = json_decode ( CJSON::encode ( $test ), TRUE );
					// echo var_dump($test);
					$data_x=array ();
					$data_y=array ();
					foreach ($test as $key => $value) {
						$data_x[]=$value['specification'];
						$data_y[]=$value['c2'];
						
					}
					
					$x_title = "";
					// $y_title = "                            量数";
					$graph_title = $_POST['assetName']."资产报废数据统计(单位：个)";
					// echo var_dump($data_x);
					// echo var_dump($data_y);
					// echo var_dump(empty($data_x));
					 if (empty($data_x)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"没有记录！\");</script>";
					} else {
						$max_y = max($data_y);
						$name = HDraw::HistogramShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y);
					}
				}
			}
			
		}
		$this->render('index',array( 'data' => $data, 'flog'=>$flog,'pages'=>$pages,'analyseType' => $analyseType, 'inTime' => $_POST['inTime'], 'outTime' => $_POST['outTime'],'assetName'=>$_POST['assetName'],'judge'=>$judge,'name'=>$name));
		
	}
}

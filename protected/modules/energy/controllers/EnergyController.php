<?php
define ( PAGESIZE, 5 );
define ( GRAGHSIZE, 14 );
define ( HEISIZE, 500 );
define ( LENHSIZE, 700 );
define ( UP, 50 );
define ( DOWN, 100 );
define ( LEFT, 40 );
define ( RIGHT, 30 );

define(x_name,"");
/**
 * 资产管理借出数据统计
 * @author 徐晨阳 赵军
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
include ("jpgraph/jpgraph_plotline.php"); 


class EnergyController extends Controller

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
					$sql="SELECT name,SUM(power) as c1 from energy_power WHERE time>='".$_POST['inTime']."' AND time<='".$_POST['outTime']."' GROUP BY name ORDER BY c1 DESC LIMIT 0,10";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$data_x=array ();
					$data_y=array ();
					foreach ($data as $key => $value) {
						$data_x[]=$value['name'];
						$data_y[]=$value['c1'];
						
					}
					// echo var_dump($data);
					$x_title = x_name;
					// $y_title = "n                            数度";
					$graph_title = "能耗排序图前十 (单位:度)";
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
					$sql="SELECT name,SUM(power) as c1 from energy_power WHERE time>='".$_POST['inTime']."' AND time<='".$_POST['outTime']."' GROUP BY name ORDER BY c1 ASC LIMIT 0,10";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$data_x=array ();
					$data_y=array ();
					foreach ($data as $key => $value) {
						$data_x[]=$value['name'];
						$data_y[]=$value['c1'];
						
					}
					// echo var_dump($data);
					
					$x_title = "房间号";
					// $y_title = "                            数度";
					$graph_title = "能耗排序图后十 (单位:度)";
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


					$sql = "SELECT roomId,SUM(power) as c1 FROM energy_power,energy_room WHERE energy_power.id in(SELECT energy_room.assetID FROM energy_room) GROUP BY energy_room.roomId DESC"; 
					// $sql = "SELECT roomId,SUM(energy_power.power)"
					$name1 =  Yii::app ()->db->createCommand($sql)->queryAll();
					$name1 = json_decode ( CJSON::encode ( $name1 ), TRUE );
					// echo var_dump($name1);
					// $max_y = max($data_y);
					foreach ($name1 as $key => $value) {
						$data_x[]="房间".$value['roomId']."";
						$data_y[]=$value['c1']/10;
						
					}

						$x_title = "房间号";
						// $y_title = "                            能耗占比";
						$graph_title = "房间能耗排序图前十(单位:度)";
					if (empty($name1)) {
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					}
					else{

						$max_y = max($data_y);
						$name = HDraw::horizontalBarShow($data_x,$data_y,$x_title,$y_title,$graph_title,$max_y);
					
					}
					
				}elseif ($analyseType=="4") {
					$sql="SELECT name,SUM(power) as c1 from energy_power WHERE time>='".$_POST['inTime']."' AND time<='".$_POST['outTime']."' GROUP BY name ORDER BY c1";
					$data =  Yii::app ()->db->createCommand($sql)->queryAll();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					$piedata = array ();
					$piename = array ();
					$location = 9;
					$ages = array();
					foreach ($data as $value) {
					    $ages[] = $value['c1'];
					}
 
					array_multisort($ages, SORT_DESC, $data);
					// echo var_dump($data);
					foreach ($data as $key => $value) {
						if ($key<$location) {
							$piename[]=$value['name'];
							$piedata[]=$value['c1'];
						}
						else
						{
							$piedata[$location] += $value['c1'];
							$piename[$location] = "其他";
						}
						
						
					}
					// echo var_dump($piedata);
					$title = "资产能耗占比           ";
					if (empty($piedata)) { // 数据库表类的函数save（），存储是否成功，来自yii框架
						echo "<script language=\"JavaScript\">alert(\"该段时间没有记录！\");</script>";
					} else {
						$name = HDraw::pieShow($piedata,$piename,$title);
					}
				}
				elseif ($analyseType=="5") {
					// echo var_dump($_POST['inTime']);
					if (!empty($_POST['month'])) 
						$month=$_POST['month'];
					$now = (int)$month; 
					$thismonth=date('Y');
					$thismonth .="-".$month; 
					// $now1 = DATE_FORMAT('2015-08-09', '%Y%M');
					// echo var_dump($thismonth);
					
					$sql="SELECT power,time from energy_power WHERE date_format(time,'%Y-%m') ='".$thismonth."' and name='".$_POST ['assetName']."' ORDER BY time";
					// echo var_dump($_POST ['assetName']);
					$sql1="SELECT power,time from energy_power WHERE date_format(time,'%Y-%m') ='".$thismonth."' and name='".$_POST ['assetName2']."' ORDER BY time";

					$name1 =  Yii::app ()->db->createCommand($sql)->queryAll();
					$name1 = json_decode ( CJSON::encode ( $name1 ), TRUE );
					$name2 =  Yii::app ()->db->createCommand($sql1)->queryAll();
					$name2 = json_decode ( CJSON::encode ( $name2 ), TRUE );
					// echo var_dump(empty ( $name2));
					
					
					$judge = 1;
					if (empty ( $name1)&&empty ( $name2)) {
						$judge = 0;
						echo "<script language=\"JavaScript\">alert(\"名称或时间输入有误，请重新输入！\");</script>";
					}
					else{
					
					foreach ($name1 as $key => $value) {
						
						$data_x[] = $value['time'];
						$data_y[] = $value['power'];
					}
					foreach ($name2 as $key => $value) {
						
						$data2_y[] = $value['power'];
					}
					// echo var_dump($months);
					$x_title = "日期";
					$y_title = "度数";
					$graph_title = " ".$_POST ['assetName']." ".$_POST['assetName2']." ".$now."月耗电量变化图(单位:度)";
					// $data_x=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");
					$name = HDraw::liner2Show($data_x,$data_y,$data2_y,$x_title,$y_title,$graph_title);
					}

					
					
				}
				elseif ($analyseType=="6") {


					$flog = 6;//设置开关，动态刷新资产能耗走势图

					
					// $thisTime = date("Y-m-d H:i:s",strtotime("- 45 minutes 2 seconds"));
					// echo var_dump($thisTime);
					// $now1 = DATE_FORMAT('2015-08-09', '%Y%M');
					// echo var_dump($thismonth);
					
					$sql=" SELECT electric,time from energy_day WHERE name='".$_POST ['assetName']."' ORDER BY time DESC LIMIT 0,50";

					// echo var_dump($_POST ['assetName']);
					// $sql1="SELECT power,time from energy_power WHERE date_format(time,'%Y-%m') ='".$thismonth."' and name='".$_POST ['assetName2']."' ORDER BY time";

					$name1 =  Yii::app ()->db->createCommand($sql)->queryAll();
					$name1 = json_decode ( CJSON::encode ( $name1 ), TRUE );
					// echo var_dump($name1);
					// $name2 =  Yii::app ()->db->createCommand($sql1)->queryAll();
					// $name2 = json_decode ( CJSON::encode ( $name2 ), TRUE );
					// echo var_dump(empty ( $name2));
					// echo var_dump($name1);
					// var_dump($name1);
					$judge = 1;
					if (empty ( $name1)) {
						$judge = 0;
						echo "<script language=\"JavaScript\">alert(\"名称输入有误，请重新输入！\");</script>";
					}
					else{
					
					foreach ($name1 as $key => $value) {
						
						$data_x[] = "";
						$data_y[] = $value['electric'];
						$t = $value['time'];
					}
					$data_y = array_reverse($data_y);
					$data_x[count($name1)-1] = $t;
					// echo var_dump($data_x[count($name1)-1]);
					$x_title = "日期";
					$y_title = "度数";
					$graph_title = " ".$_POST ['assetName'].$now." 实时电流值(单位:mA)";
					// $data_x=array("1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月");
					$name = HDraw::liner3Show($data_x,$data_y,$x_title,$y_title,$graph_title);
					}


					

					
					
				}
				
			}
			
		}
		$this->render('index',array( 'data' => $data, 'flog'=>$flog,'pages'=>$pages,'analyseType' => $analyseType,'month' => $month, 'inTime' => $_POST['inTime'], 'outTime' => $_POST['outTime'],'assetName'=>$_POST['assetName'],'assetName2'=>$_POST['assetName2'],'judge'=>$judge,'name'=>$name));
		
	}

}



// <?php

// /**
// * @author 赵军 <[email address]>
// */
// class mainController extends XAdminiBase
// {
	
// 	public function actionIndex()
// 	{						
// 		// $criteria = new CDbCriteria();
// 		// $criteria-> 
// 		// $sql = "SELECT assetName,RFID,storageId,specification,inTime FROM as_asset WHERE assetName not in(SELECT assetName FROM as_analyse WHERE borrowTime>='".$_POST['inTime']."' AND returnTime<='".$_POST['outTime']."')";
// 		// $data7 =  Yii::app ()->db->createCommand($sql)->queryAll();
// 		// $data = json_decode ( CJSON::encode ( $data7 ), TRUE );
// 		// 
// 		$this->render('index');
// 	}
// }
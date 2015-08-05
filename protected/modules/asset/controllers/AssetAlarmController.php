<?php
	/**
	 * 能耗数据统计
	 * @author  徐晨阳
	 * @link localhost/index.php?r=asset/assetAlarm/alarm
	 * 前端传送过来一个数据，后台进行处理，然后返回给前端一个信息是否报警
	 */
	class AssetAlarmController extends Controller{
		public function actionAlarm(){
			$mes=$_REQUEST['ids'];
			$mes=json_decode($mes,true);
			$res=array ();
			//获取的是一个RFID数组
			foreach ($mes as $key => $value) {
				$data =AsAsset::model()->findByPk($value);
				if(is_null($data)){
					$res[]=array ("id"=>$value,"name"=>'null',"alarm"=>0);
				}else{
					if ($data['outPrm']=='y') {
						if($data['state']=='out'){
							// echo "1";
							$res[]=array ("id"=>$data['RFID'],"name"=>$data['assetName'],"alarm"=>0);
						}elseif ($data['state']=='in') {
							// echo "2";
							$res[]=array ("id"=>$data['RFID'],"name"=>$data['assetName'],"alarm"=>1);
							$mes= "RFID:".$value."原因:该商品显示在库存中";
							yii::log ($mes,"info","alarm.log");//将报警信息写入日志
						}
					}else{
						$mes= "RFID:".$value."原因:该商品不允许外借";
						yii::log ($mes,"info","alarm.log");
						$res[]=array ("id"=>$data['RFID'],"name"=>$data['assetName'],"alarm"=>1);
					}
				}
			}
			//返回值的形式为RFID，assetName，alarm（1是报警，0是不报警）
			$res1=json_encode($res);
			echo $res1;
		}
	}
?>
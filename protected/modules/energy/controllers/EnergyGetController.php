<?php
define(THRESHOLD,500);
// date_default_timezone_set('prc');
	class EnergyGetController extends Controller{
		public function actionAlarm(){
			$mes=$_REQUEST['tags'];
			$mes=json_decode($mes,true);
			// var_dump($_REQUEST);
			// var_dump($_REQUEST['tags']);
			// var_dump($mes);
			$response=array ();
			foreach ($mes as $key => $value) {

				// var_dump($value['time']);
				// var_dump(date('h:i:s',strtotime($value['time'])));

				// if (date('h:i:s',strtotime($value['time'])))=='00:00:00') {
					
				// }

				$energy_day = new EnergyDay();
				// var_dump($value['electric']);
				$energy_day->electric = $value['electric'];
				$energy_day->time = $value['time'];
				// var_dump($value['time']);
				$energy_day->tagId = $value['id'];
				// var_dump($value['id']);
				$sql = "SELECT assetId,name FROM energy_asset WHERE  tagId = '".$value['id']."'";
				$data =  Yii::app ()->db->createCommand($sql)->queryAll();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				// $energy_day->id = $res['']
				
				// $data =EnergyAsset::model()->findByPk($value['id']);
				// var_dump($data);
				foreach ($data as $key => $value) {
					$energy_day->name = $value['name'];
					$energy_day->assetId = $value['assetId'];
				}
				// $energy_day->name = $data['name'];
				// $energy_day->assetId = $data['assetId'];
				
				// if ($energy_day->save ()>0) {
					
				// }
				
				if ($value['electric']>THRESHOLD)
					$flog = 1;
				else 
					$flog = 0;

				$response[] = array("id"=>(string)$energy_day->tagId,"name"=>(string)$energy_day->name,"alarm"=>(int)$flog);
				
				
			}
			$response=json_encode($response);
			echo $response;
		}
	}
?>
<?php
define ( PAGESIZE, 5 );
class AssetApplyController extends XAdminiBase {
	public function actionShowDetail() {
	}
	
	/**
	 * 外借资产查询
	 *
	 * @author 张钰 徐晨阳
	 * 该模块主要负责对申请资产进行显示，删除
	 */
	public function actionIndex() {
		// 分页取数据
		$criteria = new CDbCriteria ();
		
		$criteria->select = '*';

		if (XUtils::method () == 'POST') {
			// 查询按钮
			if (isset ( $_POST ['subQuery'] )) {
				// 判断是否获取content中的内容，内容为空是显示全部申请
				if (isset ( $_POST ['queryType'] ) && isset ( $_POST ['content'] ) && ($_POST ['content'] != null)) {
					$queryType = $_POST ['queryType'];
					if ($queryType == 'ByApplyId') {
						$criteria->addCondition ( 'applyId=:applyId'); // 查询条件，即where id = 1
						$criteria->params [':applyId'] = $_POST ['content'];
					} else if ($queryType == 'ByStuId') {
						$criteria->addCondition ( 'stuId=:stuId'); // 查询条件，即where id = 1
						$criteria->params [':stuId'] = $_POST ['content'];
					} else if ($queryType == 'ByAssetName') {
						$criteria->addCondition ( 'assetName=:assetName'); // 查询条件，即where id = 1
						$criteria->params [':assetName'] = $_POST ['content'];
					} else {
						echo "ERROR";
					}
				}
			}
		}
		//分页获取
	
		$count = AsApply::model ()->count ( $criteria );
		$pages = new CPagination ( $count );
		$pages->pageSize = PAGESIZE;
		$pages->applyLimit ( $criteria );
		//echo var_dump($pages);
		$data = AsApply::model ()->findAll ( $criteria );
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'index', array (
				'data' => $data,
				'pages' => $pages, 
		) );
		// $this->render ( 'index' );
	}
	/**
	*主要是删除该功能
	*/
	public function actionDelete($applyId){
		$data = AsApply::model ()->deleteByPk ( $applyId );
		echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
		$criteria = new CDbCriteria ();
		$criteria->select = '*';// 处理提交数据
		$count = AsApply::model ()->count ( $criteria );
		$pages = new CPagination ( $count );
		// results per page
		$pages->pageSize = PAGESIZE;
		$pages->applyLimit ( $criteria );
		//echo var_dump($pages);
		$data = AsApply::model ()->findAll ( $criteria );
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'index', array (
				'data' => $data,
				'pages' => $pages 
		) );
	}
	
	// Uncomment the following methods and override them if needed
	/*
	 * public function filters() { // return the filter configuration for this controller, e.g.: return array( 'inlineFilterName', array( 'class'=>'path.to.FilterClass', 'propertyName'=>'propertyValue', ), ); } public function actions() { // return external action classes, e.g.: return array( 'action1'=>'path.to.ActionClass', 'action2'=>array( 'class'=>'path.to.AnotherActionClass', 'propertyName'=>'propertyValue', ), ); }
	 */
}
<?php
// localhost/cms_new/index.php?r=student的默认接口
class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
<?php
/*进入localhost/cms_new/index.php?r=asset的入口函数*/
class DefaultController extends XAdminiBase
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
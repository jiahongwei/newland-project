<?php
/**
 * 公共登录
 * 
 * @author        汤杰 <4024507217@qq.com>
 * @version       v1
 */

class PublicController extends Controller
{

    /**
     * 会员登录
     */
    public function actionLogin ()
    {
      try {
        $model = new AsAdmin();
        if (XUtils::method() == 'POST') {
          $model->adminId = $_POST['adminId'];
          $model->password = $_POST['password'];
          $data = $model->find('adminId=:adminId', array ('adminId' => $model->adminId ));

          if ($data === null) {
            $model->addError('adminId', '用户不存在');
            AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '登录失败，用户不存在:' . CHtml::encode($model->adminId) , 'user_id' => 0 ));
          } elseif (! $model->validatePassword($data->password)) {
            $model->addError('password', '密码不正确');
            AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '登录失败，密码不正确:' . CHtml::encode($model->adminId). '，使用密码：'.CHtml::encode($model->password) , 'user_id' => 0 ));
          } else {
            parent::_stateWrite(
              array(
                'userId'=>$data->adminId,
                'userName'=>$data->adminName
              ),array('prefix'=>'_admini')
            );
            $data->save();
            AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '用户登录成功:'.CHtml::encode($model->adminId) ));
            $this->redirect(array('AssetManage/FindAll'));
          }
        }

        $this->render('login', array ('model' => $model ));
        
      } catch (Exception $e) {
        echo var_dump($e);
      }
    }

    /**
     * 退出登录
     */
    public function actionLogout ()
    {
        parent::_sessionRemove('_admini');
        $this->redirect(array ('public/login' ));
    }
}

?>
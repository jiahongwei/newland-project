<?php
/**
 * 公共登录
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class PublicController extends Controller
{

    /**
     * 会员登录
     */
    public function actionLogin ()
    {
      try {
        $model = new EnergyAdmin('login');
        if (XUtils::method() == 'POST') {
            $model->id = $_POST['id'];
            $model->password = $_POST['password'];
            $data = $model->find('id=:id', array ('id' => $model->id ));
            
            if ($data === null) {
                $model->addError('id', '用户不存在');
                AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '登录失败，用户不存在:' . CHtml::encode($model->id) , 'user_id' => 0 ));
            } elseif (! $model->validatePassword($data->password)) {
                $model->addError('password', '密码不正确');
                 AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '登录失败，密码不正确:' . CHtml::encode($model->id). '，使用密码：'.CHtml::encode($model->password) , 'user_id' => 0 ));
            } else {
                parent::_stateWrite(
                    array(
                        'userId'=>$data->id,
                        'userName'=>$data->name
                    ),array('prefix'=>'_admini')
                );
                // $data->save();
                AdminLogger::_create(array ('catalog' => 'login' , 'intro' => '用户登录成功:'.CHtml::encode($model->id) ));
                $this->redirect(array('energy/index'));
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
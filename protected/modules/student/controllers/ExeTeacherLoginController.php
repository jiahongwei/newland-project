<?php
	// 该模块主要是行政班主任的登陆模块，其中包含行政班主任对于自己班级学生的考勤查询与请假申请
	define ( PAGESIZE, 15);//控制分页每页15条记录
	class ExeTeacherLoginController extends XAdminiBase{
		//行政班主任登陆成功后登录的主界面
		public function actionIndex(){
			$this->render('index');
		}
		//行政班主任修改密码
		public function actionOwnerUpdate (){
			try {
				$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
				$data = StAdmin::model()->findByPk($this->_admini['userId']);
				if (XUtils::method () == 'POST') {
		        	$id = $data['id'];
		        	$name = $data['name'];
		        	$password = $_POST['password'];
		            $count = StAdmin::model ()->updateByPk ( $id, array (
						'name' => $name,
						'password' => $password
					) );
					if ($count > 0) {
						AdminLogger::_create(array ('catalog' => 'update' , 'intro' => '修改密码:' . CHtml::encode($data['name']))); //日志
                		XUtils::message('success', '修改完成', $this->createUrl('exeTeacherLogin/index'));
					} else {
						XUtils::message('fail', '修改失败', $this->createUrl('exeTeacherLogin/ownerUpdate'));
					}
		        }
	        	$this->render('ownerUpdate', array ('data' => $data));
			} catch (Exception $e) {
				echo var_dump($e);		
			}
    	}
    	//行政班主任进行申请查询，查询班级学生的请假查询
		public function actionApplyQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$teacherId = $model->id;
			$sql = "SELECT * FROM st_exe_class,st_apply,st_student,st_class_time,st_course WHERE  st_student.classId = st_exe_class.exeClassId AND st_exe_class.teacherId='$teacherId' AND st_apply.classTimeId = st_class_time.classTimeId AND st_course.courseId=st_class_time.courseId AND st_apply.stuId = st_student.stuId";
			try {
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断条件
						if ( $_POST ['ByState'] != "3") {
							$sql = $sql." AND st_apply.state ='".$_POST ['ByState']."'";
						}
						if ( $_POST ['ByStuName'] != "学生姓名") {
							$name ="'%".$_POST ['ByStuName']."%'";
							$sql = $sql." AND st_student.stuName LIKE ".$name."";
						}
						if ( $_POST ['ByStuId'] != "学生学号") {
							$sql = $sql." AND st_student.stuId = '".$_POST ['ByStuId']."'";
						}
						if ( $_POST ['ByClassId'] != "行政班级") {
							$sql = $sql." AND st_exe_class.exeClassId = '".$_POST ['ByClassId']."'";
						}
						if ( $_POST ['ByClassDate'] != "上课时间") {
							$date ="'%".$_POST ['ByClassDate']."%'";	//对上课时间进行模糊查询
							$sql = $sql." AND classDate LIKE ".$date."";
						}
					}
				}
				// echo var_dump($sql);
				$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
			    // echo var_dump($data);
				$this->render ( 'applyQuery', array (
						'data' => $data,
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 查询该老师所管辖的行政班级学生的缺勤记录
		public function actionAbsentQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$teacherId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_absent,st_class_time,st_student,st_teacher,st_course,st_exe_class WHERE st_absent.classTimeId=st_class_time.classTimeId AND st_absent.stuId=st_student.stuId AND st_class_time.courseId=st_course.courseId AND st_exe_class.teacherId ='$teacherId' AND st_course.teacherId=st_teacher.teacherId AND st_exe_class.exeClassId = st_student.classId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 查询内容
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$name ="'%".$_POST ['ByCourseName']."%'";
							$sql = $sql." AND st_course.courseName LIKE ".$name."";
						}
						if ( $_POST ['ByStuName'] != "学生姓名") {
							$name ="'%".$_POST ['ByStuName']."%'";
							$sql = $sql." AND st_student.stuName LIKE ".$name."";
						}
						if ( $_POST ['ByClassId'] != "行政班级") {
							$sql = $sql." AND st_student.classId = ".$_POST ['ByClassId'];
						}
						if ( $_POST ['ByClassStart'] != "起始时间") {
							$date = $_POST ['ByClassStart']." 00:00:00";
							// echo $date;
							$sql = $sql." AND st_class_time.classDate >= '".$date."'";
						}
						if ( $_POST ['ByClassEnd'] != "终止时间") {
							$date = $_POST ['ByClassEnd']." 00:00:00";
							$sql = $sql." AND st_class_time.classDate <= '".$date."'";
						}
					}
				}
				// echo var_dump($sql);

				//分页获取
				$result = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$count = count($result);
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
				$pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
				$pdata->bindValue(':limit', $pages->pageSize);
				$data = $pdata->queryAll();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'absentQuery', array (
						'data' => $data
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 行政版老师对于学生申请的审批操作
		public function actionAccess($applyId){

			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$teacherId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_course,st_class_time,st_apply WHERE st_class_time.classTimeId = st_apply.classTimeId AND st_course.courseId=st_class_time.courseId AND st_apply.applyId='$applyId'";
				if (XUtils::method () == 'POST') {
					if( $_POST['approve'] == "同意"){
					 	$state = 1;
					}
					if( $_POST['approve'] == "不同意"){
						$state =2;
					}
					$count = StApply::model ()->updateByPk ( $applyId, array (
						'state' => $state
					));
					if ($count > 0) {
                		XUtils::message('success', '审批成功', $this->createUrl('exeTeacherLogin/applyQuery'));
					} else {
						XUtils::message('fail', '修改失败', $this->createUrl('exeTeacherLogin/access'));
					}
				}
				$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
			    // echo var_dump($data);
				$this->render ( 'access', array (
						'data' => $data
				) );
			}catch (Exception $e) {
				echo var_dump($e);
			}
		}
	}
?>
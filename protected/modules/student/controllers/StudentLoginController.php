<?php
	// 该模块主要是学生角色的模块，主要包含学生的缺勤查询、课程查询、请假等功能
	define ( PAGESIZE, 15);//控制分页每页15条记录
	class StudentLoginController extends XAdminiBase{
		// 学生登陆成功后进入的主界面
		public function actionIndex(){
			$this->render('index');
		}
		// 学生修改密码操作
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
                		XUtils::message('success', '修改完成', $this->createUrl('studentLogin/index'));
					} else {
						XUtils::message('fail', '修改失败', $this->createUrl('studentLogin/ownerUpdate'));
					}
		        }
	        	$this->render('ownerUpdate', array ('data' => $data));
			} catch (Exception $e) {
				echo var_dump($e);		
			}
    	}
    	// 查询自己的缺勤记录
    	public function actionAbsentQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$stuId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_absent,st_class_time,st_student,st_teacher,st_course WHERE st_absent.classTimeId=st_class_time.classTimeId AND st_absent.stuId=st_student.stuId AND st_class_time.courseId=st_course.courseId AND st_student.stuId ='$stuId' AND st_course.teacherId=st_teacher.teacherId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 查询内容
						if ( $_POST ['ByCourseId'] != "课程编号") {
							$sql = $sql." AND st_class_time.courseId ='".$_POST ['ByCourseId']."'";
						}
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$name ="'%".$_POST ['ByCourseName']."%'";
							$sql = $sql." AND st_course.courseName LIKE ".$name."";
						}
						if ( $_POST ['ByRoomId'] != "上课教室" ) {
							$sql = $sql." AND st_class_time.roomId = '".$_POST ['ByRoomId']."'";
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
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}

		}
		// 查询自己的课程信息
		public function actionCourseQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$stuId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_course,st_student,st_student_course WHERE st_student.stuId ='$stuId' AND st_course.courseId=st_student_course.courseId AND st_student_course.stuId=st_student.stuId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断条件
						if ( $_POST ['ByCourseId'] != "课程编号") {
							$sql = $sql." AND st_course.courseId ='".$_POST ['ByCourseId']."'";
						}
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$name ="'%".$_POST ['ByCourseName']."%'";
							$sql = $sql." AND st_course.courseName LIKE ".$name."";
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
				$this->render ( 'courseQuery', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 查询课程的详细信息，包括具体上课时间以及教室等内容，并可以对该时间的课程进行请假
		public function actionCourseDetail($courseId,$courseName){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$stuId = $model->id;
			// echo var_dump($model);
			try {
				date_default_timezone_set('PRC'); //设置中国时区
				$date1 = date('y-m-d H:i:s',time());
				$sql = "SELECT * FROM st_class_time WHERE courseId ='$courseId' AND classDate >='".$date1."'";//控制不显示已经上过的课程信息
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断条件
						if ( $_POST ['ByClassDate'] != "上课时间") {
							$name ="'%".$_POST ['ByClassDate']."%'";
							$sql = $sql." AND classDate LIKE ".$name."";

						}
						if ( $_POST ['ByRoomId'] != "上课教室") {
							$sql = $sql." AND roomId = ".$_POST ['ByRoomId']."";
						}
					}
				}
				// echo var_dump($sql);
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
				$this->render ( 'courseDetail', array (
						'data' => $data,
						'pages' => $pages,
						'courseName' => $courseName 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 学生进行申请流程
		public function actionApply($classTimeId){

			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$stuId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_course,st_class_time WHERE st_class_time.classTimeId ='$classTimeId' AND st_course.courseId=st_class_time.courseId";
				if (XUtils::method () == 'POST') {
					// 提交按钮
					$data=StApply::model()->findAllByAttributes(array('stuId'=>$stuId,'classTimeId'=>$classTimeId));
					// echo empty($data);
					if (empty($data)) {
						$model = new StApply();
						$model->stuId = $stuId;
						$model->classTimeId = $classTimeId;
						$model->reason =  $_POST['reason'];
						$model->state = 0;
						if( $model->save()>0){
							XUtils::message('success', '提交成功', $this->createUrl('studentLogin/courseQuery'));
						}else{
							XUtils::message('fail', '申请失败', $this->createUrl('studentLogin/apply'));
						}
					}else{
						XUtils::message('fail', '申请已存在', $this->createUrl('studentLogin/courseQuery'));
					}
				}
				// echo var_dump($sql);

				//分页获取
				$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				// echo var_dump($data);
				$this->render ( 'apply', array (
						'data' => $data[0],
						'stuId' => $stuId
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 学生查看申请结果，包含待审批，审批通过以及审批不通过的记录
		public function actionApplyQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$stuId = $model->id;
			try {
				$sql = "SELECT * FROM st_apply,st_class_time,st_course WHERE st_apply.stuId ='$stuId' AND st_course.courseId=st_class_time.courseId AND st_class_time.classTimeId=st_apply.classTimeId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断条件
						if ( $_POST ['ByState'] != "3") {
							$sql = $sql." AND st_apply.state ='".$_POST ['ByState']."'";
						}
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$sql = $sql." AND st_course.courseName = '".$_POST ['ByCourseName']."'";
						}
						if ( $_POST ['ByCourseId'] != "课程编号") {
							$sql = $sql." AND st_course.courseId = '".$_POST ['ByCourseId']."'";
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
	}
?>
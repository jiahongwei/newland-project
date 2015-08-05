<?php
	// 该模块主要是任课老师模块，其中包含任课老师所需要上的课程信息、课程内容、对该课程进行手动考勤、查询该课程的学生缺勤情况等功能
	define ( PAGESIZE, 15);//控制分页每页15条记录
	class TeacherLoginController extends XAdminiBase{
		// 任课老师登陆成功后的主界面
		public function actionIndex(){
			$this->render('index');
		}
		// 任课老师修改密码函数
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
                		XUtils::message('success', '修改完成', $this->createUrl('teacherLogin/index'));
					} else {
						XUtils::message('fail', '修改失败', $this->createUrl('teacherLogin/ownerUpdate'));
					}
		        }
	        	$this->render('ownerUpdate', array ('data' => $data));
			} catch (Exception $e) {
				echo var_dump($e);		
			}
    	}
    	// 任课老师查询所教授课程的学生缺勤情况
		public function actionAbsentQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$teacherId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_absent,st_class_time,st_student,st_teacher,st_course WHERE st_absent.classTimeId=st_class_time.classTimeId AND st_absent.stuId=st_student.stuId AND st_class_time.courseId=st_course.courseId AND st_teacher.teacherId ='$teacherId' AND st_course.teacherId=st_teacher.teacherId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 查询内容
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$name ="'%".$_POST ['ByCourseName']."%'";
							$sql = $sql." AND st_course.courseName LIKE ".$name."";
						}
						if ( $_POST ['ByRoomId'] != "上课教室" ) {
							$sql = $sql." AND st_class_time.roomId = '".$_POST ['ByRoomId']."'";
						}
						if ( $_POST ['ByStuId'] != "学生学号") {
							$sql = $sql." AND st_student.stuId = '".$_POST ['ByStuId']."'";
						}
						if ( $_POST ['ByStuName'] != "学生姓名") {
							$name ="'%".$_POST ['ByStuName']."%'";
							$sql = $sql." AND st_student.stuName LIKE ".$name."";
						}
						if ( $_POST ['ByProfession'] != "专业") {
							$name ="'%".$_POST ['ByProfession']."%'";
							$sql = $sql." AND st_student.profession LIKE ".$name."";
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
		// 任课老师查询所需上课的课程信息
		public function actionCourseQuery(){
			$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);
			$teacherId = $model->id;
			// echo var_dump($model);
			try {
				$sql = "SELECT * FROM st_course,st_teacher WHERE st_teacher.teacherId ='$teacherId' AND st_course.teacherId=st_teacher.teacherId";
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
		// 任课老师查询上课学生名单
		public function actionCourseNumberQuery($courseId,$courseName){
			try {
				$sql = "SELECT * FROM st_student,st_student_course WHERE st_student_course.courseId = '".$courseId."' AND st_student_course.stuId = st_student.stuId";
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
				// echo var_dump($data);
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'courseNumberQuery', array (
						'data' => $data,
						'pages' => $pages,
						'courseName' => $courseName
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		// 任课老师查询某一学生的缺勤情况
		public function actionAbsentDetail($courseId,$stuId){
			try {
				$sql = "SELECT * FROM st_class_time,st_absent WHERE st_class_time.courseId = '".$courseId."' AND st_absent.stuId = '".$stuId."' AND st_class_time.classTimeId = st_absent.classTimeId";
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
				$course = StCourse::model ()->findByPk ( $courseId );
				// echo var_dump($course);
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'absentDetail',array (
						'data' => $data,
						'pages' => $pages,
						'stuId' => $stuId,
						'courseName' => $course['courseName']
				) );
			} catch (Exception $e) {
				var_dump($e);
			}
		}
		// 任课老师今天所需要上的课程查询，并可以对该堂课进行手动考勤
		public function actionTodayClass(){
			try {
				date_default_timezone_set('PRC'); //设置中国时区
				$date ="'%".date('Y-m-d')."%'";
				$date1 = date('y-m-d H:i:s',time());
				$sql = "SELECT * FROM st_class_time,st_course WHERE classDate LIKE ".$date." AND st_class_time.classEnd > '".$date1."' AND st_class_time.courseId=st_course.courseId";
				// echo $sql;
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
				$result = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$count = count($result);
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
				$pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
				$pdata->bindValue(':limit', $pages->pageSize);
				$data = $pdata->queryAll();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				// echo var_dump($data);
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'todayClass', array (
						'data' => $data,
						'pages' => $pages,
				) );
			} catch (Exception $e) {
				var_dump($e);
			}
		}
		// 老师对某一堂课进行手动考勤，考勤成功后将该堂课所对应的数据库表st_class_time的flag标记为1，这样考勤机将做废掉该堂课的数据，以老师手动考勤结果为主
		public function actionAttendance($classTimeId){
			try {
				$sql = "SELECT * FROM st_class_time,st_course WHERE st_class_time.classTimeId = ".$classTimeId." AND st_class_time.courseId=st_course.courseId";
				$course = Yii::app ()->db->createCommand ( $sql )->queryAll ();

				$sql = "SELECT * FROM st_student,st_student_course WHERE st_student_course.courseId = '".$course[0]['courseId']."' AND st_student_course.stuId = st_student.stuId";
				//分页获取
				if (XUtils::method () == 'POST') {
					$data = $_POST;
					$class = StClassTime::model() ->findByPk($classTimeId);
					if($class->flag == 1){
						$delete = "DELETE FROM st_absent WHERE st_absent.classTimeId = ".$classTimeId;
						$result = Yii::app ()->db->createCommand ( $sql )->execute ();
					}
					foreach ($data as $key => $value) {
						if ($value == 'on'){
							$model = new StAbsent();
							$model->stuId = $key;
							$model->classTimeId = $classTimeId;
							$model->state = "旷课";
							$model->reason = "--";
							$model->save();
							// echo var_dump($model);
						}
					}
					StClassTime::model ()->updateByPk ( $classTimeId, array ('flag' => '1') );
					// XUtils::message('success', '考勤成功', $this->createUrl('teacherLogin/todayClass'));

				}

				$result = Yii::app ()->db->createCommand ( $sql )->queryAll ();
				$count = count($result);
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pdata =Yii::app()->db->createCommand($sql." LIMIT :offset,:limit");
				$pdata->bindValue(':offset', $pages->currentPage*$pages->pageSize);
				$pdata->bindValue(':limit', $pages->pageSize);
				$data = $pdata->queryAll();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				// echo var_dump($data);
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'attendance', array (
						'data' => $data,
						'pages' => $pages,
						'courseName' => $course[0]['courseName']
				) );
			} catch (Exception $e) {
				var_dump($e);
			}
		}
	}
?>
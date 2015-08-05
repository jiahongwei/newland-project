<?php
	/*
	该模块主要是管理员模块，里面的主要负责的是管理员的功能，
	其中包括管理员修改密码、进行学生注册、学生管理、教师管理、设备管理、课程管理、考勤管理等内容
	*/
	define ( PAGESIZE, 15);//控制分页每页15条记录
	class AdminLoginController extends XAdminiBase{
		/*该函数是管理员进入后的登陆成功界面*/
		public function actionIndex(){
			$this->render('index');
		}
		/*该函数主要是管理员修改用户密码*/
		public function actionOwnerUpdate (){
			try {
				$model = parent::_dataLoad(new StAdmin(), $this->_admini['userId']);//首先从session中获取登录是的id号（yii框架自带）
				$data = StAdmin::model()->findByPk($this->_admini['userId']);//查询该用户并对该用户的密码进行更新
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
                		XUtils::message('success', '修改完成', $this->createUrl('adminLogin/index'));
					} else {
						XUtils::message('fail', '修改失败', $this->createUrl('adminLogin/ownerUpdate'));
					}
		        }
	        	$this->render('ownerUpdate', array ('data' => $data));
			} catch (Exception $e) {
				echo var_dump($e);		
			}
    	}
    	/*登陆考勤连接窗口，目的是连接到考勤机*/
    	public function actionRegisterLink(){
    		$data = "";
    		if (XUtils::method () == 'POST') {
    			$sn=$_POST['deviceSn'];
    			$data = StSn::model()->findByPk($sn);
    			$data = json_decode ( CJSON::encode ( $data ), TRUE );
    		}
    		is_array ( $data ) ? null : $data = array (); // 防止空数组
    		$this->render('registerLink',array ('data' => $data));
    	}
    	/*进行学生注册,与考勤机进行连接*/
    	public function actionRegister(){
    		try {
    			// echo var_dump($_POST['getClassMember']);
    			$sql = "SELECT stuId FROM st_student";
    			if (XUtils::method () == 'POST') { 
    			    if (isset($_POST['classId'])) {
	    				$sql = $sql." WHERE classId = ".$_POST['classId'];//获取输入班级的学生名单
    			    }		
	    			if(isset($_POST['upLoad'])){//获取学生的人脸信息，并将该信息更新到数据库中
	    				$stuId = $_POST['stuId'];
	    				$feature = $_POST['studentFeature'];
	    				$url = $stuId.".jpg";	
	    				$photo=$_POST['studentPhoto'];
				        $Filename= (string)"photo/".$stuId.".jpg";//由于获取的是图片的字符串信息，需要把字符串转换为图片，获取的图片存放在根目录的photo路径下
					    $ifp = fopen( $Filename, "wb" ); 
				        fwrite( $ifp, base64_decode($photo)); 
				        fclose( $ifp );
						// echo "<img src=$Filename></img>";
	    				$count = StStudent::model ()->updateByPk ( $stuId, array ('feature' => $feature,'photo' => $url));
		    			if ($count > 0) {
							echo "<script language=\"JavaScript\">alert(\"上传成功\");</script>";
						} else {
							echo "<script language=\"JavaScript\">alert(\"上传失败\");</script>";
						}
		    		}
			    }
			    $data = Yii::app ()->db->createCommand ( $sql )->queryAll();
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				// var_dump($data);
				is_array ( $data ) ? null : $data = array (); // 防止空数组
    			$this->render('register',array('data' => $data, 'classId' => $_POST['classId']));    			
    		} catch (Exception $e) {
    			echo var_dump($e);
    			// echo $e;

    		}
    	}
    	/*该模块是学生管理模块，主要是管理学生的个人信息，以及每个学生的出勤情况*/
    	public function actionStudentManageFindAll(){
    		try {
			// 分页取数据
				$criteria = new CDbCriteria ();
				$criteria->select = '*';

				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断查询条件
						if ( $_POST ['ByStuName'] != "学生姓名") {
							$criteria->addCondition ( 'stuName=:stuName'); // 查询条件，即where id = 1
							$criteria->params [':stuName'] = $_POST ['ByStuName'];
						}
						if ( $_POST ['ByStuClass'] != "学生班级") {
							$criteria->addCondition ( 'classId=:classId'); // 查询条件，即where id = 1
							$criteria->params [':classId'] = $_POST ['ByStuClass'];
						}
						if ( $_POST ['ByGrade'] != "学生年级") {
							$criteria->addCondition ( 'grade=:grade'); // 查询条件，即where id = 1
							$criteria->params [':grade'] = $_POST ['ByGrade'];
						}
						if ( $_POST ['ByProfession'] != "学生专业" ) {
							$criteria->addCondition ( 'profession=:profession'); // 查询条件，即where id = 1
							$criteria->params [':profession'] = $_POST ['ByProfession'];
						}
						if ( $_POST ['ByStuId'] != "学生学号") {
							$criteria->addCondition ( 'stuId=:stuId'); // 查询条件，即where id = 1
							$criteria->params [':stuId'] = $_POST ['ByStuId'];
						}
					}
				}
				//分页获取
				$count = StStudent::model ()->count ( $criteria );
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pages->applyLimit ( $criteria );
				//echo var_dump($pages);
				$data = StStudent::model ()->findAll ( $criteria );
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'studentManageFindAll', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
    	}
    	/*对学生信息的更新操作*/
    	public function actionStudentManageUpdate($stuId) {
			if (XUtils::method () == 'POST') {
				$student = new StStudent ();	
				$student->stuId = $stuId;
				$student->stuName = $_POST ['stuName'];
				$student->profession = $_POST ['profession'];
				$student->grade = $_POST ['grade'];
				$student->phone = $_POST ['phone'];
				$student->classId = $_POST ['classId'];
				$count = StStudent::model ()->updateByPk ( $stuId, array (
						'stuName' => $student->stuName,
						'profession' => $student->profession,
						'grade' => $student->grade,
						'phone' => $student->phone,
						'classId' => $student->classId,
				) );
				if ($count > 0) {
					echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
				} else {
					echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
				}
			}
			$data = StStudent::model ()->findByPk ( $stuId );
			$data = json_decode ( CJSON::encode ( $data ), TRUE );
			is_array ( $data ) ? null : $data = array (); // 防止空数组
			$this->render ( 'studentManageUpdate', array (
					'data' => $data 
			) );
		}
		/*对学生信息的删除操作*/
		public function actionStudentManageDelete($stuId) {
			$data = StStudent::model ()->deleteByPk ( $stuId );
			echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
			header("Location:index.php?r=student/adminLogin/studentManageFindAll");
		}
		/*该函数主要是负责查询学生的缺勤记录*/
		public function actionStudentManageAbsent($stuId,$stuName) {
			$sql = "SELECT * FROM st_absent,st_class_time,st_course,st_teacher WHERE st_absent.stuId = '".$stuId."' AND st_absent.classTimeId=st_class_time.classTimeId AND st_class_time.courseId=st_course.courseId AND st_course.teacherId=st_teacher.teacherId";
			$sqlnew = "SELECT * FROM st_attendance_info,st_class_time WHERE st_attendance_info.studentId = '".$stuId."' AND st_attendance_info.classTimeId =  st_class_time.classTimeId AND st_class_time.courseId = st_course.courseId AND st_course.teacherId = st_teacher.teacherId";
			$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
			$data = json_decode ( CJSON::encode ( $data ), TRUE );
			is_array ( $data ) ? null : $data = array (); // 防止空数组
			$this->render ( 'studentManageAbsent', array (
					'data' => $data,
					'stuName' => $stuName
			) );	
		}
		/*对所有教师的查询操作*/
		public function actionTeacherManageFindAll() {
			try {
				// 分页取数据
				$criteria = new CDbCriteria ();
				
				$criteria->select = '*';

				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断是否获取content中的内容，内容为空是显示全部申请
						if (isset ( $_POST ['queryType'] ) && isset ( $_POST ['content'] ) && ($_POST ['content'] != null)) {
							$queryType = $_POST ['queryType'];
							if ($queryType == 'ByteacherId') {
								$criteria->addCondition ( 'teacherId=:teacherId'); // 查询条件，即where id = 1
								$criteria->params [':teacherId'] = $_POST ['content'];
							} else if ($queryType == 'ByteacherName') {
								$criteria->addCondition ( 'teacherName=:teacherName'); // 查询条件，即where id = 1
								$criteria->params [':teacherName'] = $_POST ['content'];
							} else if($queryType == 'ByteacherType') {
								$criteria->addCondition ( 'type=:type'); // 查询条件，即where id = 1
								$criteria->params [':type'] = $_POST ['content'];
							}else{
								echo "ERROR";
							}
						}
					}
				}
				//分页获取
				$count = StTeacher::model ()->count ( $criteria );
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pages->applyLimit ( $criteria );
				//echo var_dump($pages);
				$data = StTeacher::model ()->findAll ( $criteria );
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'teacherManageFindAll', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*对老师进行删除操作的函数*/
		public function actionTeacherManageTeacherDelete($teacherId) {
			$data = StTeacher::model ()->deleteByPk ( $teacherId );
			echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
			header("Location:index.php?r=student/adminLogin/teacherManageFindAll");
		}
		/*所有学生的缺勤查询*/
		public function actionAbsentFindAll() {
			try {
				$sql = "SELECT * FROM st_absent,st_class_time,st_student,st_teacher,st_course WHERE st_absent.classTimeId=st_class_time.classTimeId AND st_absent.stuId=st_student.stuId AND st_class_time.courseId=st_course.courseId AND st_course.teacherId=st_teacher.teacherId";
				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 查询内容
						if ( $_POST ['ByCourseId'] != "课程编号") {
							$sql = $sql." AND st_class_time.courseId ='".$_POST ['ByCourseId']."'";
						}
						if ( $_POST ['ByCourseName'] != "课程名称") {
							$sql = $sql." AND st_course.courseName = '".$_POST ['ByCourseName']."'";
						}
						if ( $_POST ['ByRoomId'] != "上课教室" ) {
							$sql = $sql." AND st_class_time.roomId = '".$_POST ['ByRoomId']."'";
						}
						if ( $_POST ['ByStuId'] != "学生学号") {
							$sql = $sql." AND st_student.stuId = '".$_POST ['ByStuId']."'";
						}
						if ( $_POST ['ByStuName'] != "学生姓名") {
							$sql = $sql." AND st_student.stuName = '".$_POST ['ByStuName']."'";
						}
						if ( $_POST ['ByProfession'] != "专业") {
							$sql = $sql." AND st_student.profession = '".$_POST ['ByProfession']."'";
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
				$this->render ( 'absentFindAll', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*删除缺勤记录操作*/
		public function actionAbsentDelete($stuAbsentId) {
			$data = StAbsent::model ()->deleteByPk ( $stuAbsentId );
			echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
			header("Location:index.php?r=student/adminLogin/absentFindAll");
		}
		/*对所有课程管理操作*/
		public function actionCourseManageFindAll() {
			try {

				$sql = "SELECT * FROM st_course,st_teacher WHERE st_course.teacherId=st_teacher.teacherId";
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
						if ( $_POST ['ByTeacherName'] != "授课教师") {
							$name ="'%".$_POST ['ByTeacherName']."%'";
							$sql = $sql." AND st_teacher.teacherName LIKE ".$name."";
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
				$this->render ( 'courseManagefindAll', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*删除某一门课程操作*/
		public function actionCourseManageDelete($courseId) {
			$data = StCourse::model ()->deleteByPk ( $courseId );
			echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
			header("Location:index.php?r=student/adminLogin/courseManageFindAll");
		}
		/*显示该门课程的全部学生以及该学生的缺勤记录*/
		public function actionCourseManageDetail($courseId,$courseName){
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
				$this->render ( 'courseManageDetail', array (
						'data' => $data,
						'pages' => $pages,
						'courseName' => $courseName
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*更新该课程基本信息*/
		public function actionCourseManageUpdate($courseId){
			try {
				if (XUtils::method () == 'POST') {
					$course = new StCourse ();	
					$course->courseId = $courseId;
					$course->courseName = $_POST ['courseName'];
					$course->teacherId = $_POST ['teacherId'];
					$course->total = $_POST ['total'];
					$count = StCourse::model ()->updateByPk ( $courseId, array (
							'courseName' => $course->courseName,
							'teacherId' => $course->teacherId,
							'total' => $course->total
					) );
					if ($count > 0) {
						echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
					} else {
						echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
					}
				}
				$data = StCourse::model ()->findByPk ( $courseId );
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'courseManageUpdate', array (
						'data' => $data 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*显示某一门课程某一个学生的缺勤记录*/
		public function actionCourseManageShowAbsent($courseId,$stuId){
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
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'courseManageShowAbsent',array (
						'data' => $data,
						'pages' => $pages,
						'stuId' => $stuId,
						'courseName' => $course['courseName']
				) );	
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		/*对设备管理函数（有待完善）*/
		public function actionEquManageFindAll(){
			try {
				// 分页取数据
				$criteria = new CDbCriteria ();
				
				$criteria->select = '*';

				if (XUtils::method () == 'POST') {
					// 查询按钮
					if (isset ( $_POST ['subQuery'] )) {
						// 判断是否获取content中的内容，内容为空是显示全部申请
						if (isset ( $_POST ['queryType'] ) && isset ( $_POST ['content'] ) && ($_POST ['content'] != null)) {
							$queryType = $_POST ['queryType'];
							if ($queryType == 'ByDeviceId') {
								$criteria->addCondition ( 'deviceId=:deviceId'); // 查询条件，即where id = 1
								$criteria->params [':deviceId'] = $_POST ['content'];
							} else if ($queryType == 'ByDeviceName') {
								$criteria->addCondition ( 'deviceName=:deviceName'); // 查询条件，即where id = 1
								$criteria->params [':deviceName'] = $_POST ['content'];
							} else {
								echo "ERROR";
							}
						}
					}
				}
				//分页获取
				$count = StDevice::model ()->count ( $criteria );
				$pages = new CPagination ( $count );
				$pages->pageSize = PAGESIZE;
				$pages->applyLimit ( $criteria );
				//echo var_dump($pages);
				$data = StDevice::model ()->findAll ( $criteria );
				$data = json_decode ( CJSON::encode ( $data ), TRUE );
				is_array ( $data ) ? null : $data = array (); // 防止空数组
				$this->render ( 'equManageFindAll', array (
						'data' => $data,
						'pages' => $pages 
				) );
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
	}
?>
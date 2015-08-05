<?php
define ( PAGESIZE, 15);
/**
 * 学生管理
 * 增删改查
 *
 * @author 徐晨阳
 * @link localhost/index.php?r=student/teacherManage/findAll
 * @link localhost/index.php?r=student/teacherManage/add
 */

class StudentManageController extends XAdminiBase
{
	public function actionFindAll() {
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
			$this->render ( 'findAll', array (
					'data' => $data,
					'pages' => $pages 
			) );
		} catch (Exception $e) {
			echo var_dump($e);
		}
	}
	public function actionUpdate($stuId) {
		if (XUtils::method () == 'POST') {
			$student = new StStudent ();	
			$student->stuId = $stuId;
			$student->stuName = $_POST ['stuName'];
			$student->profession = $_POST ['profession'];
			$student->grade = $_POST ['grade'];
			$student->phone = $_POST ['phone'];
			$student->classId = $_POST ['classId'];
			$count = AsAsset::model ()->updateByPk ( $stuId, array (
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
		$this->render ( 'update', array (
				'data' => $data 
		) );
	}
	public function actionDelete($stuId) {
		$data = StStudent::model ()->deleteByPk ( $stuId );
		echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
		header("Location:index.php?r=student/studentManage/findAll");
	}
	public function actionAbsent($stuId,$stuName) {
		$sql = "SELECT * FROM st_absent,st_class_time,st_course,st_teacher WHERE st_absent.stuId = '".$stuId."' AND st_absent.classTimeId=st_class_time.classTimeId AND st_class_time.courseId=st_course.courseId AND st_course.teacherId=st_teacher.teacherId";
		$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render ( 'Absent', array (
				'data' => $data,
				'stuName' => $stuName
		) );	
	}
}
?>
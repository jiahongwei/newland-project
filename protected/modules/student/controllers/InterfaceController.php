<?php 
/**
* @author 赵军 <[email address]>
*/
class InterfaceController extends Controller
{
	######从考勤机获取实时学生出勤记录########
	public function actionAttendanceAdd()
	{
		$flog = -1;//返回参数，用于表示数据是否保存成功,1位保存成功，-1为保存失败;
		$attendanceinfo = new StAttendanceInfo();
		$attendanceinfo->studentId = $_POST['ID_Student'];
		$attendanceinfo->classTimeId = $_POST['ID_Lesson'];
		$attendanceinfo->time = $_POST['Time'];

		if ($attendanceinfo->save()>0)
			$flog = 1;
		echo $flog;



	}

	#######
	
}


?>
<?php

/**
* @author 赵军 
*/
define ( PAGESIZE, 5 );
define ( GRAGHSIZE, 14 );
define ( HEISIZE, 600 );
define ( LENHSIZE, 700 );
define ( UP, 70 );
define ( DOWN, 200 );
define ( LEFT, 100 );
define ( RIGHT, 60 );
define(x_name,"");
define('time', 86400);
require_once ("jpgraph/jpgraph.php");
require_once ("jpgraph/jpgraph_bar.php");
require_once ("jpgraph/jpgraph_pie.php");
require_once ("jpgraph/jpgraph_line.php");  
require_once ("jpgraph/jpgraph_pie3d.php");
require_once ("jpgraph/jpgraph_plotline.php"); 
class TeaStaShowController extends XAdminiBase
{
	
	public function actionIndex()
	{
		if (XUtils::method()=='POST') {
			// var_dump($_POST);
			if (isset($_POST['analyseType'])) {
				
				Statistics::deletePic();//删除历史图片
				$classId = $_POST['classId'];
				$teacherId = $_POST['teacherId'];
				$analyseType = $_POST['analyseType'];

				if ($analyseType=='1') {
					#########按出勤率最高查看###########################
					$sql="SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_course.teacherId=st_teacher.teacherId";
					$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					foreach ($data as $key => $value) {
						$info = $this->countRate($value['courseId']);
						$temp = (float)array_sum($info['rate'])/count($info['rate']);
						$rate[] = $temp;
						$courseName[] = $info['courseName'];
					}

					array_multisort($rate,SORT_DESC,$courseName);
					$data_y = array_slice($rate,0,10);
					$data_x = array_slice($courseName,0,10);
					$max_y = max($data_y);
					$graph_title = "出勤率前十课程";
					$name = Statistics::HistogramShow($data_x,$data_y,$max_y,$graph_title);
		
				}
				elseif ($analyseType=='2') {
					###########按出勤率最低查看#########################
					$sql="SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_course.teacherId=st_teacher.teacherId";
					$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
					$data = json_decode ( CJSON::encode ( $data ), TRUE );
					foreach ($data as $key => $value) {
						$info = $this->countRate($value['courseId']);
						$temp = (float)array_sum($info['rate'])/count($info['rate']);
						$rate[] = $temp;
						$courseName[] = $info['courseName'];
					}

					array_multisort($rate,SORT_ASC,$courseName);
					$data_y = array_slice($rate,0,10);
					$data_x = array_slice($courseName,0,10);
					$max_y = max($data_y);
					$graph_title = "出勤率后十课程";
					$name = Statistics::HistogramShow($data_x,$data_y,$max_y,$graph_title);
					
				}
				elseif ($analyseType=='3') {
					############按课程编号产看所教课程出勤率############
					$content = $_POST['classId'];
					$data = $this->countRate($content);
					$data_x = $data['date'];
					$data_y = $data['rate'];
					$graph_title = "".$data['courseName']." 出勤率变化图";
					if (empty($data_y)||empty($data_x)) {
						echo "<script language=\"JavaScript\">alert(\"没有考勤记录！\");</script>";
					}
					else{
						$max_y = max($data_y);
						$len = count($data_y);
						if (1<=$len&&$len<5) {
							//当数量少于5时用柱状图显示
							$name = Statistics::HistogramShow($data_x,$data_y,$max_y,$graph_title);
						}
						else{
							//当数量大于五是用折线图显示
							$name = Statistics::linerShow($data_x,$data_y,$graph_title);
						}
					}
								
				}
				elseif ($analyseType=='4') {
					#############按教师编号查看出勤率###################
					$content = $_POST['teacherId'];
					$criteria = new CDbCriteria();
					$criteria->select = '*';
					$criteria->addCondition('teacherId=:teacherId');
					$criteria->params[':teacherId'] = $content;
					$data = StCourse::model()->findAll($criteria);
					$data = json_decode(CJSON::encode($data),true);
					if (empty($data)) {
						echo "<script language=\"JavaScript\">alert(\"老师编号输入有误！\");</script>";
					}
					else{
						foreach ($data as $key => $value) {
							$courseId[] = $value['courseId'];
							$courseName[] = $value['courseName'];
						}
						foreach ($courseId as $key => $value) {
							$data = $this->countRate($value);
							$data_y = $data['rate'];
							$dataNew[$key] = $data_y;
							$count[] = count($dataNew[$key]);
							$flog[] = max($dataNew[$key]);

						}
						$x_num = max($count);
						$max_y = max($flog);
						$legend = $courseName;
						$data = $dataNew;
						$graph_title = "所教课程出勤率";
						for($key = 1;$key<=$x_num;$key++) {
							$data_x[$key-1] =  "第".$key."节课";
						}
						$name =Statistics::linerMoreShow($data,$x_num,$legend,$data_x,$max_y,$graph_title);

					}
				}
				elseif($analyseType=='5'){
					#################对比两个课程出勤率##############
					$courseId = array($_POST['id1'],$_POST['id2']);
					// var_dump($courseId);
					foreach ($courseId as $key => $value) {
						$criteria = new CDbCriteria();
						$criteria->select = 'courseName';
						$criteria->addCondition('courseId=:courseId');
						$criteria->params[':courseId'] = $courseId[$key];
						$data = StCourse::model()->findAll($criteria);
						$data = json_decode(CJSON::encode($data),true);
						$legend[] = $data[0]['courseName'];

						$data = $this->countRate($value);
						$data_y = $data['rate'];
						$dataNew[$key] = $data_y;
						$count[] = count($dataNew[$key]);
						$flog[] = max($dataNew[$key]);
					}
					$x_num = max($count);
					$max_y = max($flog);
					$data = $dataNew;
					$graph_title = "".$legend[0]." 与 ".$legend[1]." 出勤率对比图";
					for($key = 1;$key<=$x_num;$key++) {
						$data_x[$key-1] =  "第".$key."节课";
					}
					$name =Statistics::linerMoreShow($data,$x_num,$legend,$data_x,$max_y,$graph_title);

					
				}
				
			}
			
		}
		$this->render('index',array('analyseType' => $analyseType,
									'content'=>$content,
									'name'=>$name,
									'courseId'=>$courseId
									));
	}



/**************************每门课细节展示***************************************/
	public function actionShowDetail($courseId,$teacherId)
	{
		
		Statistics::deletePic();//删除历史图片
		$data = $this->countRate($courseId);
		$data_x = $data['date'];
		$data_y = $data['rate'];
		$x_title = "";
		$graph_title = "".$data['courseName']." 出勤率变化图";
		if (empty($data_y)||empty($data_x)) {
			echo "<script language=\"JavaScript\">alert(\"没有考勤记录！\");</script>";
		}
		else{
			$max_y = max($data_y);
			$len = count($data_y);
			if (1<=$len&&$len<5) {
				//当数量少于5时用柱状图显示
				$name = Statistics::HistogramShow($data_x,$data_y,$max_y,$graph_title);
			}
			else{
				//当数量大于五是用折线图显示
				$name = Statistics::linerShow($data_x,$data_y,$graph_title);
			}
			$this->render('showDetail',array('name'=>$name));
		}
		
	}




/**************************所有课程出勤情况展示***************************************/
	public function actionSumDetail()
	{
		$sql="SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_course.teacherId=st_teacher.teacherId";
		if (XUtils::method() == 'POST') {
			if (isset ( $_POST ['queryType'] ) && isset ( $_POST ['content'] ) && ($_POST ['content'] != null)) 
			{
				$queryType = $_POST['queryType'];
				$content = $_POST['content'];
				if ($queryType =='queryById') 
				{
					$sql = "SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_course.courseId like '%".$content."%' and st_course.teacherId=st_teacher.teacherId";
				}
				elseif ($queryType=='queryByName') 
				{
					$sql = "SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_course.courseName like '%".$content."%' and st_course.teacherId=st_teacher.teacherId";
				}
				elseif($queryType=='queryByTeaName')
				{
					$sql = "SELECT st_course.courseId,st_course.courseName,st_teacher.teacherName,st_teacher.teacherId FROM st_course,st_teacher WHERE st_teacher.teacherName like '%".$content."%' and st_course.teacherId=st_teacher.teacherId";
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
		$rate = array();
		foreach ($data as $key => $value) {
			$info = $this->countRate($value['courseId']);
			$temp = (float)array_sum($info['rate'])/count($info['rate']);
			$rate[] = $temp;
		}
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		is_array ( $data ) ? null : $data = array (); // 防止空数组
		$this->render('sumDetail',array('data'=>$data,'pages'=>$pages,'type'=>$queryType,'content'=>$content,'rate'=>$rate));
	}




/**************************根据课程编号计算学期内到课率***************************************/
	public  function compute($courseId,$teacherId="")
	{
		$sql = "SELECT st_class_time.classDate,st_class_time.classTimeId,COUNT(st_class_time.classTimeId) AS num FROM st_class_time,st_absent WHERE st_class_time.courseId = '".$courseId."' AND st_absent.classTimeId = st_class_time.classTimeId AND classDate<NOW() GROUP BY st_class_time.classTimeId";
		$sql2 = "SELECT total,courseName FROM st_course WHERE courseId = '".$courseId."'";
		$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		$total = Yii::app ()->db->createCommand ( $sql2 )->queryAll ();
		$total = json_decode ( CJSON::encode ( $total ), TRUE );
		$courseName = $total[0]['courseName'];	
		$date = array();
		$rate = array();
		foreach ($data as $key => $value) {
			$date[] = $value['classDate'];
			$rate[] =1- $value['num']/$total[0]['total'];
		}
		return array('date'=>$date,'rate'=>$rate,'courseName'=>$courseName);


	}



/****************************根据缺勤率，计算所有课的到课率***********************************/
	public  function countRate($courseId)
	{

		$criteria = new CDbCriteria();
		$criteria->addCondition('courseId=:courseId');
		$criteria->params[':courseId'] = $courseId;
		$data = StClassTime::model()->findAll($criteria);
		$data = json_decode ( CJSON::encode ( $data ), TRUE );
		$dateNew = array();
		$rateNew = array();
		$dataOld = $this->compute($courseId);
		foreach ($data as $key => $value) {
			$dateNew[] = $value['classDate'];
			$rateNew[$key] = 1;
			foreach ($dataOld['date'] as $keyOld => $valueOld) {
				if ($value['classDate']==$valueOld) {
					$rateNew[$key] = $dataOld['rate'][$keyOld]; 
				}

			}
		}
		return array('date'=>$dateNew,'rate'=>$rateNew,'courseName'=>$dataOld['courseName']);
		

	}
}




?>
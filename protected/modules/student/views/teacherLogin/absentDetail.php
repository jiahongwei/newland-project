<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<?php echo $this->renderPartial('/_include/teacher_left')?>
	<div class="right rightContent">
	<center>
		 <form name="" action="" method="post">
			<div style="height:40px;">
				<p>学生学号:<?php echo $stuId;?>&nbsp;&nbsp;课程名称:<?php echo $courseName;?></p>
			</div>
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>课程编号</td>
						<td>上课时间</td>
						<td>上课教室</td>
						<td>缺勤类型</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td><?php echo $value['courseId']; ?></td>
						<td><?php echo $value['classDate']; ?></td>
						<td><?php echo $value['roomId']; ?></td>
						<td><?php echo $value['state']; ?></td>
					</tr>
					<?php }}?>
				</table>
			</div>
			<div style="height:20px;">
				<?php
				$this->widget ( 'CLinkPager', array (
						'header' => '',
						'firstPageLabel' => '首页',
						'lastPageLabel' => '末页',
						'prevPageLabel' => '上一页',
						'nextPageLabel' => '下一页',
						'pages' => $pages,
						'maxButtonCount' => 8 
				) );
				?>
			</div>
			<div>
				<a href="<?php echo  $this->createUrl('courseNumberQuery',array('courseId'=>$_GET['courseId'],'courseName' => $courseName))?>">返回</a>
			</div> 
		</form>
		</center>
	</div>
	<?php echo $this->renderPartial('/_include/footer')?>
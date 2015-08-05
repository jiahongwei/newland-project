<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<?php echo $this->renderPartial('/_include/exe_teacher_left')?>
	<div class="right rightContent">
	<center>
		<div style="height:40px;"></div>
		 <form name="" action="" method="post">
			<div style="height:40px; width:100%;">
				<input type="text" name="ByClassId" value="行政班级" onblur="if(this.value==''){this.value='行政班级';}" onclick="if(this.value='专业'){this.value='';}">
				<input type="text" name="ByStuName" value="学生姓名" onblur="if(this.value==''){this.value='学生姓名';}" onclick="if(this.value='学生姓名'){this.value='';}">
				<input type="text" name="ByCourseName" value="课程名称" onblur="if(this.value==''){this.value='课程名称';}" onclick="if(this.value='课程名称'){this.value='';}">
				<input type="text" name="ByClassStart" value="起始时间" onclick="WdatePicker()" autocomplete="off" onblur="if(this.value==''){this.value='起始时间';}" onclick="if(this.value='起始时间'){this.value='';}">
				<input type="text" name="ByClassEnd" value="终止时间" onclick="WdatePicker()" autocomplete="off" onblur="if(this.value==''){this.value='终止时间';}" onclick="if(this.value='终止时间'){this.value='';}">
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>学生学号</td>
						<td>学生姓名</td>
						<td>学生班级</td>
						<td>课程编号</td>
						<td>课程名称</td>
						<td>教授老师</td>
						<td>学生专业</td>
						<td>上课教室</td>
						<td>缺勤类型</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td><?php echo $value['stuId']; ?></td>
						<td><?php echo $value['stuName']; ?></td>
						<td><?php echo $value['classId']; ?></td>
						<td style="color:blue;"><?php echo $value['courseId']; ?></td>
						<td style="color:blue;"><?php echo $value['courseName']; ?></td>
						<td><?php echo $value['teacherName']; ?></td>
						<td><?php echo $value['profession'];?></td>
						<td><?php echo $value['roomId'];?></td>
						<td style="color:blue;"><?php echo $value['state'];?></td>
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
		</form>
		</center>
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
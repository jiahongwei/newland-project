<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="2" id="flag"/>
	<?php echo $this->renderPartial('/_include/student_left')?>
	<div class="right rightContent">
	<center>
		<div style="height:40px;"></div>
		 <form name="" action="" method="post">
			<div style="height:40px; width:100%;">
				<input type="text" name="ByCourseId" value="课程编号" onblur="if(this.value==''){this.value='课程编号';}" onclick="if(this.value='课程编号'){this.value='';}">
				<input type="text" name="ByCourseName" value="课程名称" onblur="if(this.value==''){this.value='课程名称';}" onclick="if(this.value='课程名称'){this.value='';}">
				<input type="text" name="ByRoomId" value="上课教室" onblur="if(this.value==''){this.value='上课教室';}" onclick="if(this.value='上课教室'){this.value='';}">
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>课程编号</td>
						<td>课程名称</td>
						<td>上课时间</td>
						<td>上课教室</td>
						<td>缺勤类型</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td style="color:blue;"><?php echo $value['courseId']; ?></td>
						<td style="color:blue;"><?php echo $value['courseName']; ?></td>
						<td><?php echo $value['classDate'];?></td>
						<td><?php echo $value['roomId']; ?></td>
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
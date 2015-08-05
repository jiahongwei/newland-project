<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="3" id="flag"/>
	<?php echo $this->renderPartial('/_include/teacher_left')?>
	<div class="right rightContent">
	<center>
		 <form name="" action="" method="post">
			<div style="height:40px;">
				<p>课程名称:<?php echo $courseName;?></p>
			</div>
			<div style="height:550px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>学生学号</td>
						<td>学生姓名</td>
						<td>学生班级</td>
						<td>是否缺勤</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>
					<tr class="tb_header">
						<td><?php echo $value['stuId']; ?></td>
						<td><?php echo $value['stuName']; ?></td>
						<td><?php echo $value['classId']; ?></td>
						<td><input type="checkbox" name="<?php echo $value['stuId']; ?>"></td>
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
			<p><input type="submit" name="attendance" value="提交" class="button1" /><a href="<?php echo  $this->createUrl('todayClass')?>">返回</a></p>
			</div>
		</form>
		</center>
	</div>
	<?php echo $this->renderPartial('/_include/footer')?>
<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<?php echo $this->renderPartial('/_include/left')?>
	<div class="right">
	<div class="rightContent">
	<div style="height:40px; width:100%;">
		<p>学生姓名:<?php echo $stuName;?></p>
	</div>
	<center>
		 <form name="" action="" method="post">
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>课程名称</td>
						<td>上课教师</td>
						<td>上课日期</td>
						<td>上课教室</td>
						<td>缺勤原因</td>
						<!-- <td>删除</td> -->
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td style="color:blue;"><?php echo $value['courseName']; ?></td>
						<td><?php echo $value['teacherName']; ?></td>
						<td><?php echo $value['classDate']; ?></td>
						<td><?php echo $value['roomId']; ?></td>
						<td style="color:blue;"><?php echo $value['reason'];?></td>
						<!-- <td><a href="<?php echo  $this->createUrl('deleteAbsent',array('stuAbsentId'=>$value['stuAbsentId']))?>" onclick="return confirm('确定要删除这条记录吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td> -->
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
		<div style="height:20px;width:350px;">
      		<a href="<?php echo  $this->createUrl('studentManageFindAll')?>">返回</a>
    	</div>
		</center>
	</div>
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
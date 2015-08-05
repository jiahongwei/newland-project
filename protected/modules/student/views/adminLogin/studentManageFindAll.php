<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<script>
	$(document).ready(function(){
		$("#manage").css("display","block");
	})
	</script>
	<?php echo $this->renderPartial('/_include/left')?>
	<div class="right rightContent">
	<center>
	<div style="height:40px;"></div>
		 <form name="" action="" method="post">
			<div style="height:40px; width:100%;">
				<input type="text" name="ByStuName" value="学生姓名" onblur="if(this.value==''){this.value='学生姓名';}" onclick="if(this.value='学生姓名'){this.value='';}">
				<input type="text" name="ByStuClass" value="学生班级" onblur="if(this.value==''){this.value='学生班级';}" onclick="if(this.value='学生班级'){this.value='';}">
				<input type="text" name="ByProfession" value="学生专业" onblur="if(this.value==''){this.value='学生专业';}" onclick="if(this.value='学生专业'){this.value='';}">
				<input type="text" name="ByGrade" value="学生年级" onblur="if(this.value==''){this.value='学生年级';}" onclick="if(this.value='学生年级'){this.value='';}">
				<input type="text" name="ByStuId" value="学生学号" onblur="if(this.value==''){this.value='学生学号';}" onclick="if(this.value='学生学号'){this.value='';}">
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:600px">		
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>学生学号</td>
						<td>学生姓名</td>
						<td>学生班级</td>
						<td>学生专业</td>
						<td>出勤查询</td>
						<td>编辑</td>
						<td>删除</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td style="color:blue;"><?php echo $value['stuId']; ?></td>
						<td><?php echo $value['stuName']; ?></td>
						<td style="color:blue;"><?php echo $value['classId']; ?></td>
						<td><?php echo $value['profession']; ?></td>
						<td><a href="<?php echo  $this->createUrl('studentManageAbsent',array('stuId'=>$value['stuId'],'stuName'=>$value['stuName']))?>">缺勤查询</a></td>
						<td><a href="<?php echo  $this->createUrl('studentManageUpdate',array('stuId'=>$value['stuId']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
						<td><a href="<?php echo  $this->createUrl('studentManageDelete',array('stuId'=>$value['stuId']))?>" onclick="return confirm('确定要删除这位学生吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
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
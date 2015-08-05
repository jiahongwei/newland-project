<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="2" id="flag"/>
	<?php echo $this->renderPartial('/_include/exe_teacher_left')?>
	<div class="right rightContent">
	<center>

		 <form name="" action="" method="post">
			<div style="height:40px;"></div>
			<div style="height:40px; width:100%;">
				<select name="ByState">
            		<option value='0'>待审核</option>
            		<option value='1'>已通过审核</option>
            		<option value='2'>未通过审核</option>
            		<option value="3" selected>--请选择状态--</option>
          		</select>
				<input type="text" name="ByStuId" value="学生学号" onblur="if(this.value==''){this.value='学生学号';}" onclick="if(this.value='学生学号'){this.value='';}">
				<input type="text" name="ByStuName" value="学生姓名" onblur="if(this.value==''){this.value='学生姓名';}" onclick="if(this.value='学生姓名'){this.value='';}">
				<input type="text" name="ByClassId" value="行政班级" onblur="if(this.value==''){this.value='行政班级';}" onclick="if(this.value='行政班级'){this.value='';}">
				<input type="text" name="ByClassDate" value="上课时间" onclick="WdatePicker()" autocomplete="off" onblur="if(this.value==''){this.value='上课时间';}" onclick="if(this.value='上课时间'){this.value='';}">
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:550px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>学生学号</td>
						<td>学生姓名</td>
						<td>学生班级</td>
						<td>课程编号</td>
						<td>课程名称</td>
						<td>上课时间</td>
						<td>上课教室</td>
						<td>申请状态</td>
						<td>审批</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>
					<tr class="tb_header">
						<td><?php echo $value['stuId']; ?></td>
						<td><?php echo $value['stuName']; ?></td>
						<td><?php echo $value['classId']; ?></td>
						<td><?php echo $value['courseId']; ?></td>
						<td><?php echo $value['courseName']; ?></td>
						<td><?php echo $value['classDate']; ?></td>
						<td><?php echo $value['roomId']; ?></td>
						<td><?php if ($value['state']==0) {echo "待审核";}elseif($value['state']==1){echo "已通过审核";}else{echo "未通过审核";}?></td>
						<?php if ($value['state']==0) {?>
						<td><a href="<?php echo  $this->createUrl('access',array('applyId'=>$value['applyId']))?>">审批</a></td>
						<?php }else{?>
						<td>--</td>
						<?php }?>
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
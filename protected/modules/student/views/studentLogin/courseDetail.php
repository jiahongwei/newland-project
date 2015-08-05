<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<?php echo $this->renderPartial('/_include/student_left')?>
	<div class="right rightContent">
	<center>
		 <form name="" action="" method="post">
			<div style="height:40px;">
				<p>课程名称:<?php echo $courseName;?></p>
			</div>
			<div style="height:40px; width:100%;">
				<input type="text" name="ByClassDate" value="上课时间" onclick="WdatePicker()" autocomplete="off" onblur="if(this.value==''){this.value='上课时间';}" onclick="if(this.value='上课时间'){this.value='';}">
				<input type="text" name="ByRoomId" value="上课教室" onblur="if(this.value==''){this.value='上课教室';}" onclick="if(this.value='上课教室'){this.value='';}">
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:550px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>上课时间</td>
						<td>上课教室</td>
						<td>结束时间</td>
						<td>请假</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>
					<tr class="tb_header">
						<td><?php echo $value['classDate']; ?></td>
						<td><?php echo $value['roomId']; ?></td>
						<td><?php echo $value['classEnd']; ?></td>
						<td><a href="<?php echo  $this->createUrl('apply',array('classTimeId'=>$value['classTimeId']))?>">请假</a></td>
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
			<a href="<?php echo  $this->createUrl('courseQuery')?>">返回</a>
			</div>
		</form>
		</center>
	</div>
	<?php echo $this->renderPartial('/_include/footer')?>
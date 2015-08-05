<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<script>
	$(document).ready(function(){
		$("#manage").css("display","block");
	})
	</script>
	<?php echo $this->renderPartial('/_include/left')?>
	<div class="right">
	<div class="rightContent">
	<center>
		 <form name="" action="" method="post">
			<div style="height:40px; width:400px;">
				<select name="queryType" id="queryType">
					<option value="ByteacherId">按教师号查询</option>
					<option value="ByteacherName">按教师姓名查询</option>
					<option value="ByteacherType">按教师类型查询</option>
					<!-- <option value="queryByRFID" id="queryByRFID">按资产编号查询</option> -->
				</select>
				<input name="content" type="text" id="content" />
				<!-- <input type="button" value="扫描" id="queryRFID">  -->
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>教师编号</td>
						<td>教师姓名</td>
						<td>教师类型</td>
						<td>教师电话</td>
						<!-- <td>编辑</td> -->
						<td>删除</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td style="color:blue;"><?php echo $value['teacherId']; ?></td>
						<td><?php echo $value['teacherName']; ?></td>
						<td style="color:blue;"><?php echo $value['type']; ?></td>
						<td><?php echo $value['phone']; ?></td>
						<!-- <td><a href="<?php echo  $this->createUrl('teacherUpdate',array('teacherId'=>$value['teacherId']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td> -->
						<td><a href="<?php echo  $this->createUrl('teacherManageTeacherDelete',array('teacherId'=>$value['teacherId']))?>" onclick="return confirm('确定要删除这位老师吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
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
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
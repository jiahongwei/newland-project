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
					<option value="ByDeviceName">按姓名查询</option>
					<option value="ByDeviceId">按编号查询</option>
					<!-- <option value="queryByRFID" id="queryByRFID">按资产编号查询</option> -->
				</select>
				<input name="content" type="text" id="content" />
				<!-- <input type="button" value="扫描" id="queryRFID">  -->
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>设备编号</td>
						<td>设备名称</td>
						<td>设备类型</td>
						<td>查询</td>
						<td>编辑</td>
						<td>删除</td>
					</tr>
					<?php
					if (is_array ( $data )) {
						foreach ( $data as $value ) {
					?>

					<tr class="tb_header">
						<td style="color:blue;"><?php echo $value['equId']; ?></td>
						<td><?php echo $value['equName']; ?></td>
						<td style="color:blue;"><?php echo $value['equType']; ?></td>
						<td><a href="<?php echo  $this->createUrl('equShow',array('equId'=>$value['equId']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
						<td><a href="<?php echo  $this->createUrl('equUpdate',array('equId'=>$value['equId']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
						<td><a href="<?php echo  $this->createUrl('equDelete',array('equId'=>$value['equId']))?>" onclick="return confirm('确定要删除该设备吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
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
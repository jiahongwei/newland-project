<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<input type="hidden" value="3" id="flag"/>
<center>
	<div class="right rightContent">
	<form name="" action="" method="post">
		<div style="height:50px;"></div>
		<div style="height:40px; width:500px;">
			<select name="queryType">
				<option value="ByApplyId">按申请编号查询</option>
				<option value="ByStuId">按申请人编号查询</option>
				<option value="ByAssetName">按资产名称查询</option>
			</select> <input name="content" type="text" /> <input name="subQuery"
				type="submit" value="查询" />
		</div>

		<div>
			<table class="content_list">
			<? var_dump($data);?>
				<tr class="s1">
					<td>申请编号</td>
					<td>申请资产名称</td>
					<td>申请资产型号</td>
					<td>申请人ID</td>
					<td>申请人姓名</td>
					<td>申请时间</td>
					<td>申请人手机号</td>

					<td>借出</td>
					
					<td>删除</td>
				</tr>	
				<?php
				if (is_array ( $data )) {
					foreach ( $data as $value ) {
						?>
				<tr class="tb_header">
					<td><?php echo $value['applyId']; ?></td>
					<td style="color:blue;"><?php echo $value['assetName']; ?></td>
					<td><?php echo $value['specification']; ?></td>
					<td><?php echo $value['stuId']; ?></td>
					<td><?php echo $value['stuName']; ?></td>
					<td><?php echo $value['applyTime']; ?></td>
					<td><?php echo $value['stuTelNum']; ?></td>
					
					<td><a href="<?php echo  $this->createUrl('/asset/assetManage/Borrow',array('assetName'=>$value['assetName'],'specification'=>$value['specification'],'applyId'=>$value['applyId'],'totalNum'=>$value['c1'],'type'=>$value['type'],'flog'=>1,'stuId'=>$value['stuId'],'stuName'=>$value['stuName'],'stuTelNum'=>$value['stuTelNum']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/borrow.png"></a></td>
					<td><a href="<?php echo  $this->createUrl('delete',array('applyId'=>$value['applyId']))?>" onclick="return confirm('确定要删除吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
				</tr>
				<?php }}?>
			</table>
			<div style="height:20px;"></div>
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
	</div>
</center>
<?php echo $this->renderPartial('/_include/footer')?>
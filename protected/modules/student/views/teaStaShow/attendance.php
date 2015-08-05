<?php echo $this->renderPartial('/_include/header')?>
<input type="hidden" value="6" id="flag"/>
<?php echo $this->renderPartial('/_include/left')?>
<div class="right">
<div class="rightContent">
<center>
<div style="height:300px">
	<table cellspacing="0px" class="content_list">
		<tr class="s1">
			<td>课程名称</td>
			<td>任课老师</td>
			<td>缺勤次数</td>
			<td>到课率</td>
			<td>详情</td>
		</tr>
		<?php
		if (is_array ( $data )) {
			foreach ( $data as $value ) {
				?>

				<tr class="tb_header">
					<td style="color:blue;"><?php echo $value['assetName']; ?></td>
					<td><?php echo $value['specification']; ?></td>
					<td style="color:blue;"><?php echo $value['c1']; ?></td>
					<td><?php echo $value['c2']; ?></td>
					<td><?php echo $value['c2']; ?></td>
				</tr>
		<?php 
			}
		}
		?>
	</table>
</div>

<div>
	
</div>
	
</center>
</div>
</div>
</body>

<?php echo $this->renderPartial('/_include/footer')?>
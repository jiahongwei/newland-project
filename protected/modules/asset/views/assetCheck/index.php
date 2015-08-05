<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
	<input type="hidden" value="6" id="flag"/>
	<div class="right rightContent">
	<div style="height:3%;"></div>
	<center>
	<form name="" action="" method="post">
		<div style="height:40px; width:400px;">
				<select name="queryType" id="queryType">
					<option value="queryByName">按名称查询</option>
					<option value="queryBySp">按型号查询</option>
					<!-- <option value="queryByRFID" id="queryByRFID">按资产编号查询</option> -->
				</select>
				<input name="content" type="text" id="content" />
				<!-- <input type="button" value="扫描" id="queryRFID">  -->
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
		<!--<div style="height:20px;"></div>-->
		<div>
			<?php
					$pagesize = 5; //设置记录显示条数
					$rows = count($data); //计算数组所得到记录总数
					$pagecount = ceil($rows / $pagesize);
					$page=0;
					//初始化页码
					if(isset($page))
						$page=$_GET['page'];
					$offset = $page - 1; //初始化分页指针
					$start = $page * $pagesize; //初始化下限
					$end = $start + $pagesize; //初始化上限
					if($end>$rows)
						$end=$rows;
					$prev = $page -1; //初始化上一页
					$next = $page +1; //初始化下一页
			?>
		<div style="height:300px;width:100%;font-size:13px;">
			<table class="content_list">
				<tr class="s1">
					<td>编号</td>
					<td>资产名</td>
					<td>型号</td>
					<td>状态</td>
					<td>存储地点</td>
					<td>入库时间</td>
					<td>允许借出</td>
					<td>借出人电话</td>
					<td>状态</td>
					<td>增加</td>
					<td>删除</td>
					<td>修改</td>
				</tr>
				<!--从文件读取数据分页操作-->	
				<?php
					for($i=$start;$i<$end;$i++)
					{//输出数据
				?>
				<tr>
				<?php
					if($data[$i]['RFID']=='')//assetId
					{
				?>
					<td><?php echo $data[$i]['assetId']; ?></td>
				<?php
					}else{
				?>
					<td><?php echo $data[$i]['RFID']; ?></td>
				<?php
					}
				?>
					<td><?php echo $data[$i]['assetName']; ?></td>
					<td><?php echo $data[$i]['specification']; ?></td>
					<td><?php echo $data[$i]['state']; ?></td>
					<td><?php echo $data[$i]['storageId']; ?></td>
					<td><?php echo $data[$i]['inTime']; ?></td>
					<td><?php echo $data[$i]['outPrm']; ?></td>
					<td><?php echo $data[$i]['brwPhone']; ?></td>
					<td><?php echo $data[$i]['flag']; ?></td>
					<?php 
						if($data[$i]['flag']=='丢失'||$data[$i]['flag']=='正常')
						{
					?>
					<td>--</td>
					<?php
						}
						else
						{
							if($data[$i]['RFID']=='')//assetId
							{
					?>
					<td><a href="<?php echo  $this->createUrl('add',array('sign'=>'assetId','condition'=>$data[$i]['assetId']))?>" ><img align="absmiddle" src="/cms_new/static/admin/images/create.gif"></a></td>
					<?php
							}else
							{
					?>
					<td><a href="<?php echo  $this->createUrl('add',array('sign'=>'RFID','condition'=>$data[$i]['RFID']))?>" ><img align="absmiddle" src="/cms_new/static/admin/images/create.gif"></a></td>
					<?php
							}
						}
						if($data[$i]['RFID']=='')
						{
					?>
					<td><a href="<?php echo  $this->createUrl('delete',array('sign'=>'assetId','condition'=>$data[$i]['assetId']))?>" onclick="return confirm('确定要删除吗？')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
					<?php
						}else
						{
					?>
					<td><a href="<?php echo  $this->createUrl('delete',array('sign'=>'RFID','condition'=>$data[$i]['RFID']))?>" onclick="return confirm('确定要删除吗？')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
					<?php
						}
						if($data[$i]['flag']=='新增')
						{
					?>
					<td>--</td>
					<?php
						}
						else
						{
							if($data[$i]['RFID']=='')
							{
					?>
					<td><a href="<?php echo  $this->createUrl('update',array('sign'=>'assetId','condition'=>$data[$i]['assetId']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
					<?php
							}else
							{
					?>
					<td><a href="<?php echo  $this->createUrl('update',array('sign'=>'RFID','condition'=>$data[$i]['RFID']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
					<?php
							}
						}
					?>
				</tr>
				<?php } ?>
			</table>
			</div>
			<?php
					if($page >=1){
						echo "<a href='http://localhost/cms_new/index.php?r=asset/assetCheck/index&page=0'>第一页</a>";
						echo "<a href='http://localhost/cms_new/index.php?r=asset/assetCheck/index&page=".$prev."'>上一页</a>";
					}
					if($page < $pagecount-1&&$pagecount!=0){
						echo "<a href='http://localhost/cms_new/index.php?r=asset/assetCheck/index&page=".$next."'>下一页</a>";
						$finalPage=$pagecount-1;
						echo "<a href='http://localhost/cms_new/index.php?r=asset/assetCheck/index&page=".$finalPage."'>最后页</a>";
					}
					$temp=$page+1;
					echo '共['.$pagecount.']页&nbsp;当前第'.$temp.'页&nbsp;每页'.$pagesize.'条记录';
				?>
		</div>
	</form>	
	</center>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
  		$('#baidu').removeAttr('href');
	});
</script>
<?php echo $this->renderPartial('/_include/footer')?>

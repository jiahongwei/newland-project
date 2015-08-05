<!-- 
	查询资产:可以查询固定资产、耗材的库存量，剩余量，以及进行相应的操作 
-->
<?php echo $this->renderPartial('/_include/header')?>
	<input type="hidden" value="1" id="flag"/>
	<script>
	$(document).ready(function(){
		$("#one9").css("display","block");
		$("#one10").css("display","block");
		if ($("#queryType").val()!="queryById") {
			$("#content").show();
			$("#text").hide();
			$("#queryRFID").hide();
		}else{
			$("#content").hide();
			$("#text").show();
			$("#queryRFID").show();
		};
		

		$("#RFID").click(function() {
			$("#content").hide();
			$("#text").show();
			$("#queryRFID").show();
		});
		$("#name").click(function() {
			$("#content").show();
			$("#text").hide();
			$("#queryRFID").hide();
		});
		$("#specification").click(function() {
			$("#content").show();
			$("#text").hide();
			$("#queryRFID").hide();
		});

		$("#queryRFID").click(function() {
		    $.getJSON(
		          "num.txt?t="+new Date(),
		          function(data){
		              $.each(data, function(k, v) {
		                  if (k=='RFID'||k=='assetId') {
		                    $("#text").attr("value",v);
		                  }
		              })
		      })
    	});
	});
	</script>
	<?php if($type == 'static') {?>
	<input type="hidden" value="9" id="flag"/>
	<?php } ?>
	<?php if($type == 'consume') {?>
	<input type="hidden" value="10" id="flag"/>
	<?php } ?>
	<?php echo $this->renderPartial('/_include/left')?>
	<div class="right">
	<div class="rightContent">
	<center>
		 <form name="" action="" method="post">
			<div style="height:40px; width:700px;">
				<select name="queryType" id="queryType">
					<option value="queryByName" id="name" <?php if($queryType=="queryByName"){echo "selected";} ?>>按名称查询</option>
					<option value="queryBySp" id="specification" <?php if($queryType=="queryBySp"){echo "selected";} ?>>按型号查询</option>
					<option value="queryById" id="RFID" <?php if($queryType=="queryById"){echo "selected";} ?>><?php echo $queryName; ?></option>
					<!-- <option value="queryByRFID" id="queryByRFID">按资产编号查询</option> -->
				</select>
				<input name="content" type="text" id="content" value="<?php echo $content?>" />
				<input name="RFID" type="text" id="text" autocomplete="off" value="<?php echo $RFID ?>" style="width:250px"/>
				<input type="button" value="扫描" onclick="query();" id="queryRFID"> 
				<input name="subQuery" type="submit" value="查询" /> 
			</div>
			<?php if ($queryType!='queryById') {?>
				
			<div style="height:600px">
				<table cellspacing="0px" class="content_list">
					<tr class="s1">
						<td>资产名称</td>
						<td>资产型号</td>
						<td>库存数量</td>
						<td>借出数量</td>
						<td>编辑</td>
						<td>借出</td>
						<td>删除</td>
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
						<td><a href="<?php echo  $this->createUrl('showAsset',array('assetName'=>$value['assetName'],'specification'=>$value['specification'],'type'=>$type))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
						<?php 
						if($value['c1']>0){
						?>
							<td><a href="<?php echo  $this->createUrl('Borrow',array('assetName'=>$value['assetName'],'specification'=>$value['specification'],'totalNum'=>$value['c1'],'type'=>$type,'applyId'=>0))?>"><img align="absmiddle" src="/cms_new/static/admin/images/borrow.png"></a></td>
						<?php }else{ ?>
							<td style="color:grey;">空</td>
						<?php } ?>
						<td><a href="<?php echo  $this->createUrl('deleteClass',array('assetName'=>$value['assetName'],'specification'=>$value['specification'],'type'=>$type))?>" onclick="return confirm('确定要删除这一类资产吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
					</tr>
					<?php }}?>
				</table>
			</div>
			<?php } else{?>
			 <div style="height:230px;">
			    <table class="content_list">
			      <tr class="s1">
			        <td>资产编号</td>
			        <td>名称</td>
			        <td>规格</td>
			        <td>状态</td>
			        <td>入库时间</td>
			        <td>单价</td>
			        <td>存储仓库</td>
			        <td>允许带出</td>
			        <td>借出人电话</td>
			        <?php if($type=="static") {?>
			        <td>更新</td>
			        <?php }?>
			        <td>删除</td>
			      </tr>
			      <?php
			        if (is_array ( $data )) {
			          foreach ( $data as $value ) {
			        ?>
			      <tr class="tb_header">
			        <td><?php if($type=="static"){echo $value['RFID'];}else{echo $value['assetId'];}?></td>
			        <td><?php echo $value['assetName'];?></td>
			        <td><?php echo $value['specification'];?></td>
			        <td><?php if($value['state']=="in"){echo "存储中";}else{echo "借出";}?></td>
			        <td><?php echo $value['inTime'];?></td>
			        <td><?php echo $value['Price'];?></td>
			        <td><?php echo $value['storageId'];?></td>
			        <td><?php if($value['outPrm']=="y"){echo "允许";}else{echo "不允许";}?></td>
			        <td><?php echo $value['brwPhone'];?></td>
			        <?php if($type=="static") {?>
			        <td><a href="<?php echo  $this->createUrl('update',array('RFID'=>$value['RFID']))?>"><img align="absmiddle" src="/cms_new/static/admin/images/update.png"></a></td>
			        <?php }?>
			        <td><a href="<?php if($type=="static"){echo  $this->createUrl('delete',array('RFID'=>$value['RFID']));}else{echo  $this->createUrl('deleteConsume',array('assetId'=>$value['assetId']));}?>" onclick="return confirm('确定要删除吗?')"><img align="absmiddle" src="/cms_new/static/admin/images/delete.png"></a></td>
			      </tr>
			      <?php }} ?>
			    </table>
			  </div>
			  </div>
			  
			<?php }?>
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
		<div style="height:20px;width:100%;">
				<center>
			     <a href="<?php echo  $this->createUrl('findAll')?>">返回</a>
			     </center>
	</div>
	</center>
	</div>
	</div>
<?php echo $this->renderPartial('/_include/footer')?>
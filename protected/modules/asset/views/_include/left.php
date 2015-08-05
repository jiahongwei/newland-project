<script>
function initTab(name,cursel){
	cursel=cursel;
	for(var i=1; i<=links_len; i++){
		var menu = document.getElementById(name+i);
		if(i==cursel){
			menu.className="off";
		}
		else{
			menu.className="";
		}
	}
}
var name='one';
var cursel=1;
var links_len;
onload=function(){
	var links = document.getElementById("tab").getElementsByTagName('li');
	links_len=links.length;
	cursel=document.getElementById("flag").value;
	initTab(name,cursel);
}
$(document).ready(function(){
	$('#one1').click(function(){
		$('#one9').toggle();
		$('#one10').toggle();
	})
})
</script>
<script type="text/javascript"></script>
	<div class="left" id="tab">
		<div class="menu">
				<li id="one1" class="one1" class="Manage">资产管理</li>
				<dd class="asset" id="one9" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetManage/findAll',array ('type' => 'static'));?>'">固定资产</dd>
				<dd class="consume" id="one10" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetManage/findAll',array ('type' => 'consume'));?>'">耗材</dd>
				<li id="one2" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetManage/add');?>'">资产添加</li>
				<li id="one8" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetManage/search');?>'">资产借出</li>
				<li id="one3" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetApply/index');?>'">申请查询</li>
				<li id="one4" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetManage/Return');?>'">资产归还</li>
				<li id="one5" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetStatistic/index');?>'">数据统计</li>
				<li id="one6" onclick="javascript:window.location.href='<?php echo  $this->createUrl('assetCheck/index');?>'">资产盘点</li>
				<li id="one7" onclick="javascript:window.location.href='http://localhost/cms_new/index.php'">退出登录</li>
		</div>
	</div>
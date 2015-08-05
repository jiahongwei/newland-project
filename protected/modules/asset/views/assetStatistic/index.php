<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>

<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="initial-scale=1.0, width=device-width" name="viewport">

<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
 
<script>
  $(document).ready(function(){
    if($("#analyseType").val()!="5" && $("#analyseType").val()!="8"){
      $("#6").hide();
      $("#time").show();
      
    }else{
      $("#6").show();
      $("#time").hide();
      
    }
    $("#type4").click(function(){
      $("#6").hide();
      $("#time").show();
      
    });
    $("#type3").click(function(){
      $("#6").hide();
      $("#time").show();
      
    });
    $("#type2").click(function(){
      $("#6").hide();
      $("#time").show();
      
    });
     $("#type5").click(function(){
      $("#6").show();
      $("#time").hide();
    });
    $("#type1").click(function(){
      $("#6").hide();
      $("#time").show();
      
    });
    $("#type7").click(function(){
      $("#6").hide();
      $("#time").show();
      
    });
    $("#type8").click(function(){
      $("#6").show();
      $("#time").hide();
      
    });
  });
</script>
<body>
<input type="hidden" value="5" id="flag"/>
<div class="right">
<center>
  <div style="height:10px;" ></div>
  <form action="" method="post"  enctype="multipart/form-data" id="addForm">
    <select name="analyseType" id="analyseType">
      <option value="1" id="type1" <?php if($analyseType=="1"){echo "selected";} ?>>按借出次数最多查询</option>
      <option value="2" id="type2" <?php if($analyseType=="2"){echo "selected";} ?>>按借出次数最少查询</option>
      <option value="3" id="type3" <?php if($analyseType=="3"){echo "selected";} ?>>按借出占用率查询</option>
      <option value="4" id="type4" <?php if($analyseType=="4"){echo "selected";} ?>>按借出百分比查询</option>
      <option value="5" id="type5" <?php if($analyseType=="5"){echo "selected";} ?>>单个资产每月借出次数查询</option>
      <option value="7" id="type7" <?php if($analyseType=="7"){echo "selected";} ?>>借出次数为0资产查看</option>
      <option value="8" id="type8" <?php if($analyseType=="8"){echo "selected";} ?>>资产报废数据查看</option>
    </select>
    <input type="text" id="6" placeholder="请输入资产名称" name="assetName" value="<?php if($judge==1)echo $assetName;?>">
    <label id="time" style="font-size:12px; ">
    开始日期：<input type="text" name="inTime" id="inTime" onclick="WdatePicker()" autocomplete="off" value="<?php echo $inTime;?>" >
    截至日期：<input type="text" name="outTime" id="outTime" onclick="WdatePicker()" autocomplete="off" value="<?php echo $outTime;?>">
    </label>
    <input type="submit" value="查询"  name="analyseQuery" class="button" style="height:23px">
  </table>
  </form>
  <div></div>

<!-- onfocus="this.blur()"<form action="" method="post" enctype="multipart/form-data" id="linerShow">
  
  
  </form> -->
<div style="height:50px;"></div>
<?php if($flog==7): ?>
<?php //echo var_dump($flog);?>
<table  class="content_list">
  <tr class="s1">
    <td>RFID编号</td>
    <td>资产名称</td>
    <td>资产类型</td>
    <td>储存仓库编号</td>
    <td>入库时间</td>
  </tr>
    
  
  <?php foreach ($data as $value){?>
    <tr>
      <td><?php echo $value['RFID'];?></td>
      <td><?php echo $value['assetName'];?></td>
      <td><?php echo $value['specification'];?></td>
      <td><?php echo $value['storageId']; ?></td>
      <td><?php echo $value['inTime']; ?></td>
     </tr>
  
  <?php }?>


  </table>
  <?php
        // $this->widget ( 'CLinkPager', array (
        //     'header' => '',
        //     'firstPageLabel' => '首页',
        //     'lastPageLabel' => '末页',
        //     'prevPageLabel' => '上一页',
        //     'nextPageLabel' => '下一页',
        //     'pages' => $pages,
        //     'maxButtonCount' => 8 
        // ) );
  ?>


<?php else: ?>
<?php if (file_exists($name)):?>
  <img src="<?php echo $name ?>">
  <!-- <img src="Histogrm.png"> -->
<?php endif;?>
<?php endif;?>
</div>
</center>
</body>
<?php echo $this->renderPartial('/_include/footer')?>


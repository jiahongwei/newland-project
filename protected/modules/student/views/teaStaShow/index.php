<?php echo $this->renderPartial('/_include/header')?>
<input type="hidden" value="6" id="flag"/>
<?php echo $this->renderPartial('/_include/left')?>

<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="initial-scale=1.0, width=device-width" name="viewport">

<script src="<?php echo $this->_baseUrl?>/static/asset/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
 
<script>
  $(document).ready(function(){
    if($("#analyseType").val()!="3"&& $("#analyseType").val()!="4" && $("#analyseType").val()!="5"){
      $("#6").hide();
      $("#7").hide();
      $("#type8").hide();
    }else if($("#analyseType").val()=="3"&& $("#analyseType").val()!="4" && $("#analyseType").val()!="5" ){
      $("#6").show();
      $("#7").hide();
      $("#type8").hide();

    }else if($("#analyseType").val()!="3"&& $("#analyseType").val()=="4" && $("#analyseType").val()!="5"){
      $("#6").hide();
      $("#7").show();
      $("#type8").hide();
    }else if($("#analyseType").val()!="3"&& $("#analyseType").val()!="4" && $("#analyseType").val()=="5"){
      $("#6").hide();
      $("#7").hide();
      $("#type8").show();
    };
    $("#type4").click(function(){
      $("#6").hide();
      $("#7").show();
      $("#type8").hide();

    });
    $("#type3").click(function(){
      $("#6").show();
      $("#7").hide();
      $("#type8").hide();
    });
    $("#type2").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#type8").hide();
    });
    $("#type1").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#type8").hide();
    });
    $("#type5").click(function(){
      $("#6").hide();
      $("#7").hide();
      $("#type8").show();
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
      <option value="1" id="type1" <?php if($analyseType=="1"){echo "selected";} ?>>平均到课率最高课程查看</option>
      <option value="2" id="type2" <?php if($analyseType=="2"){echo "selected";} ?>>平均到课率最低课程查看</option>
      <option value="3" id="type3" <?php if($analyseType=="3"){echo "selected";} ?>>查看某课程出勤率走势图</option>
      <option value="4" id="type4" <?php if($analyseType=="4"){echo "selected";} ?>>查看单个老师上课出勤率查看</option>
      <option value="5" id="type5" <?php if($analyseType=="5"){echo "selected";} ?>>对比课程出勤率</option>
    </select>
    <label value="8" id="type8" >
      <input type="text" id="8" placeholder="请输入课程编号" name="id1" value="<?php if ($analyseType=="5")echo $courseId[0];?>">
      <input type="text" id="9" placeholder="请输入课程编号" name="id2" value="<?php if ($analyseType=="5")echo $courseId[1];?>">
    </label>
    <input type="text" id="6" placeholder="请输入课程编号" name="classId" value="<?php if ($analyseType=="3")echo $content;?>">
    <input type="text" id="7" placeholder="请输入老师编号" name="teacherId" value="<?php if ($analyseType=="4")echo $content;?>">
    <input type="submit" value="查询"  name="analyseQuery" class="button" style="height:23px">
  </table>
  </form>
  <div></div>
<div style="height:50px;"></div>
<?php if (file_exists($name)):?>
  <img id="pic" src="<?php echo $name ?>">
<?php endif;?>
</div>
</center>
</body>

<?php echo $this->renderPartial('/_include/footer')?>
<!-- 添加资产：添加资产分别为固定资产和耗材两类，分开添加 -->
<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<style type="text/css">
.divcss5_list_title{background:#eeeeee; border:1px solid #cccccc; padding:1em;}
.divcss5_list_content{padding:1em;}
#tinybox{position:absolute; display:none; padding:10px; background:#ffffff url(image/preload.gif) no-repeat 50% 50%; border:10px solid #e3e3e3; z-index:2000;}
#tinymask{position:absolute; display:none; top:0; left:0; height:100%; width:100%; background:#000000; z-index:1500;}
#tinycontent{background:#ffffff; font-size:1.1em;}

#n{margin:10px auto; width:920px; border:1px solid #CCC;font-size:12px; line-height:30px;}
#n a{ padding:0 4px; color:#333}
</style>
<script>

 $(document).ready(function(){

  $("#picShow").click(function() {

      var content2 = "<img width='200' height='250' src='<?php echo $finalQRCode ?>' />";//弹出图片
      TINY.box.show(content2,0,0,0,1);
    });
  $("#hello").click(function() {
    $.getJSON(
          "num.txt?t="+new Date(),
          function(data){
              $.each(data, function(k, v) {
                  if (k=='assetId') {
                    $("#consume_id").attr("value",v);
                  }
              })
      })
    });
 });

 $(document).ready(function(){
  $("#RFID").click(function() {
    $.getJSON(
          "num.txt?t="+new Date(),
          function(data){
              $.each(data, function(k, v) {
                  if (k=='RFID') {
                    $("#text").attr("value",v);
                  }
              })
      })
    });
 });
</script>
<script>
  function showQrCode() {
      var obj = new Object();       
      obj.name="所生成资产二维码";
      window.showModalDialog("qrCode/1.jpeg", obj, "resizable:yes");
  }
  $(document).ready(function(){
    /*切换到固定资产时更改属性*/
    $("#s1").click(function(){
      $("#go1").show();
      $("#go2").hide();
      $("#picShow").hide();
      $("#outPrm").css("background-color","#FFFFFF");
      $("#outPrm").attr("disabled",false); 
      $("#text").attr("required",true);
      $("#assetId").attr("required",false);
    }); 
    /*切换到耗材时更改属性*/
    $("#s2").click(function(){
      $("#go1").hide();
      $("#go2").show();
      $("#picShow").show();
      $("#outPrm").val('y');
      $("#outPrm").css("background-color","#FFFFCC");
      $("#outPrm").attr("disabled",true);
      $("#assetId").attr("required",true);
      $("#text").attr("required",false);
    });
    /*初始化设置属性*/
    var s= $("input[type='radio'][name ='type']:checked").val();
    if (s=="static") {
      $("#go1").show();
      $("#go2").hide();
      $("#picShow").hide();
      $("#text").attr("required",true);
      $("#assetId").attr("required",false);
    }else{
      $("#go1").hide();
      $("#go2").show();
      $("#picShow").show();
      $("#outPrm").val('y');
      $("#outPrm").css("background-color","#FFFFCC");
      $("#outPrm").attr("disabled",true);
      $("#assetId").attr("required",true);
      $("#text").attr("required",false);
    };
    $("#outPrm").click(function(){
      var m = $("#outPrm").val();
      // alert(m);
      if (m == 'n'){
        $("#state").val('in');
        $("#state").css("background-color","#FFFFCC");
        $("#state").attr("disabled",true);   
      }else{
        $("#state").css("background-color","#FFFFFF");
        $("#state").attr("disabled",false);   
      }
    })
});
</script>
  <input type="hidden" value="2" id="flag"/>
  <div class="right rightContent">
    <center>
    <form action="" method="post"  enctype="multipart/form-data" id="addForm">
    <div style="height:30px;"></div>
    <input type="radio" name="type" onClick="doReset();" value="static" id="s1" <?php if($type=="static"){echo "checked";} ?> >固定资产</input>
    <input type="radio" name="type" onClick="doReset();" value="consume" id="s2" <?php if($type=="consume"){echo "checked";} ?> >耗材</input>
    <div style="height:10px;"></div>
    <table class="addForm">
      <tr id="go1">
        <td>RFID编号:</td>
        <td><input type="text" name="RFID" id="text" autocomplete="off"></td>
        <td><input type="button" id="RFID" value="扫描" onclick="query();" class="button" style="width:75px;height:20px;font-size:13px;"></td>
      </tr>
      <tr id="go2">
        <td>资产编号:</td>
        <td ><input type="text" id="consume_id" name="assetId" oninput="setCustomValidity('')" value="<?php echo $consume['assetId'];?>" oninvalid="setCustomValidity('资产编号不能为空')"></td>
      </tr>
      <tr>
        <td>资产名称:</td>
        <td><input type="text" name="assetName" id="assetName" value="<?php echo $consume['assetName'];?>" autocomplete="off" required></td>
      </tr>
      <tr>
        <td>资产型号:</td>
        <td><input type="text" name="specification" id="specification" value="<?php echo $consume['specification'];?>" autocomplete="off" required></td>
      </tr>
      <tr>
        <td>资产状态:</td>
        <td>
          <select name="state" id="state" required>
            <option value="in">库存中</option>
            <option value="out">借出</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>资产价格(元):</td>
        <td><input type="text" name="Price" id="Price"  oninput="setCustomValidity('')" oninvalid="setCustomValidity('价格格式不正确(数字)')" autocomplete="off" required></td>
      </tr>
      <tr>
        <td>带出类型:</td>
        <td>
        <select name="outPrm" id="outPrm">
        <option value="y">允许</option>
        <option value="n">不允许</option>  
        </select>
      </tr>
      <tr> 
        <td>存储仓库:</td>
        <td><input type="text" name="storageId" id="storageId" value="<?php echo $consume['storageId'];?>" autocomplete="off" pattern="\d{1}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('仓库号码格式不对(1-3)')" required></td>
      </tr>
<!--       <tr>
        <td>借出人电话:</td>
        <td><input type="text" name="brwPhone" autocomplete="off"></td>
      </tr> -->
      <tr>
        <td>入库时间:</td>
        <td><input type="text" name="inTime" id="inTime" value="<?php echo $consume['inTime'];?>" onclick="WdatePicker()" autocomplete="off" required></td>
      </tr>
    </table>
    <input type="submit" value="添加" onclick="writeUSR();" class="button1">
    <input type="button" value="查看二维码"  class="button1" id="picShow" >
    <!-- <a class="ml20" href="#" id="picShow">生成二维码</a> -->
  </form>
  </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
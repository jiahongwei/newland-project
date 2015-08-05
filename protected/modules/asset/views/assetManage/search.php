<!-- 添加资产：添加资产分别为固定资产和耗材两类，分开添加 -->
<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>

<script>
 $(document).ready(function(){
  $("#hello").click(function() {
    $.getJSON(
          "num.txt?t="+new Date(),
          function(data){
              $.each(data, function(k, v) {
                  if (k=='assetId') {
                    // $("#assetId").attr("value",v);
                    document.getElementById("assetId").value=v;
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
                    // document.getElementById("text").value=v;

                  }
              })
      })
    });
 });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    /*切换到固定资产时更改属性*/
    $("#s1").click(function(){
      $("#go1").show();
      $("#go2").hide();
      $("#outPrm").css("background-color","#FFFFFF");
      $("#outPrm").attr("disabled",true); 
      $("#state").attr("disabled",true); 
      // $("#text").attr("required",true);
      $("#assetId").attr("required",false);
    }); 
    /*切换到耗材时更改属性*/
    $("#s2").click(function(){
      $("#go1").hide();
      $("#go2").show();
      $("#outPrm").val('y');
      $("#outPrm").css("background-color","#FFFFCC");
      $("#outPrm").attr("disabled",true);
      $("#state").attr("disabled",true); 
      // $("#assetId").attr("required",true);
      $("#text").attr("required",false);
    });
    /*初始化设置属性*/
    var s= $("input[type='radio'][name ='type']:checked").val();
    if (s=="static") {
      $("#go1").show();
      $("#go2").hide();
      // $("#text").attr("required",true);
      $("#outPrm").attr("disabled",true);
      $("#state").attr("disabled",true); 
      $("#assetId").attr("required",false);
    }else{
      $("#go1").hide();
      $("#go2").show();
      $("#outPrm").val('y');
      $("#state").attr("disabled",true); 
      $("#outPrm").css("background-color","#FFFFCC");
      $("#outPrm").attr("disabled",true);
      // $("#assetId").attr("required",true);
      $("#text").attr("required",false);
    };
   
});
function doReset(){  
    for(i=0;i<document.all.tags("input").length;i++){  
        if(document.all.tags("input")[i].type=="text"){  
            document.all.tags("input")[i].value="";  
        }  
    }  
} 
</script>
<?php  //var_dump($type);?>
  <input type="hidden" value="8" id="flag"/>
  <div class="right rightContent">
  <?php  //var_dump($data);?>
    <center>
    <form action="" method="post"  enctype="multipart/form-data" id="addForm">
    <div style="height:30px;"></div>
    <input type="radio" name="type" onClick="doReset();" value="static" id="s1" <?php if($type=="static"){echo "checked";} ?> >固定资产</input>
    <input type="radio" name="type" onClick="doReset();" value="consume" id="s2" <?php if($type=="consume"){echo "checked";} ?> >耗材</input>
    <div style="height:10px;"></div>
    <table class="addForm">
      <tr id="go1">
        <td>RFID编号:</td>
        <td><input type="text" name="RFID" id="text" autocomplete="off" value="<?php echo $data['RFID'] ?>" ></td>
        <td><input type="button" id="RFID" value="扫描RFID" onclick="query()" class="button" style="width:75px;height:20px;font-size:13px;"></td>
        <td><input type="submit" value="查看" class="button" style="width:75px;height:20px;font-size:13px;" ></td>
      </tr>
      <tr id="go2">
        <td>资产编号:</td>
        <td><input type="text" name="assetId" id="assetId" autocomplete="off" value="<?php echo $data['assetID'] ?>" ></td>
        <td><input type="button" value="扫描二维码  " id="hello" class="button" style="width:75px;height:20px;font-size:13px;"></td>
        <td><input type="submit" value="查看" class="button" style="width:75px;height:20px;font-size:13px;" ></td>
        <!-- <td><input type="button" value="扫描" id="hello" class="button" style="width:75px;height:20px;font-size:13px;"></td> --><!-- 扫描添加按键 -->
      </tr>
      <tr>
              <td>带出类型:</td>
              <td>  
              <select name="outPrm" id="outPrm">
              <option value="y" <?php if ($data['outPrm']=="y") {echo "selected";}?>>允许</option>
              <option value="n" <?php if ($data['outPrm']=="n") {echo "selected";}?>>不允许</option>  
              </select>
              </td>
            </tr>
            <tr>
              <td>资产名称:</td>
              <td><input type="text" name="assetName" id="assetName"  value="<?php echo $data['assetName'];?>" readOnly="true" ></td>
            </tr>
            <tr>
              <td>资产规格:</td>
              <td><input type="text" name="specification" id="specification"   value="<?php echo $data['specification'];?>" readOnly="true" ></td>
            </tr>
            <tr>
              <td>资产状态:</td>
              <td>
                <select name="state" id="state" >
                  <option value="in" <?php if ($data['state']=="in") {echo "selected";}?>>库存中</option>
                  <option value="out" <?php if ($data['state']=="out") {echo "selected";}?>>借出</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>价格:</td>
              <td><input type="text" name="Price" id="Price"   value="<?php echo $data['Price'];?>" readOnly="true" ></td>
            </tr>
            <tr>
              <td>借出人电话:</td>
              <td><input type="text" name="brwPhone" id="brwPhone" value="<?php echo $data['brwPhone'];?>" readOnly="true"></td>
            </tr>
            <tr>
              <td>存储仓库:</td>
              <td><input type="text" name="storageId" id="storageId"  value="<?php echo $data['storageId'];?>" readOnly="true" ></td>
            </tr>
            <tr>
              <td>入库时间:</td>
              <td><input type="text" name="inTime" id="inTime" value="<?php echo $data['inTime'];?>" autocomplete="off"  readOnly="true" ></td>
            </tr>
            <tr>
              <td><a href="<?php echo $this->createUrl('/asset/assetManage/Borrow',
              array('assetName'=>$data['assetName'],'specification'=>$data['specification'],'totalNum'=>'1','type'=>$type,'flog'=>2,'assetID' =>$data['assetID'],'RFID'=>$data['RFID']))?>">借出</a></td>
            </tr>
            <?php $data = array(); ?>
    </table>
  </form>
  </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
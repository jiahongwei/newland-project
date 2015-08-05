<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<script>
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
  if (document.getElementById("text").value!='') {
    document.getElementById("testDiv").style.display="block";
  };
 });


</script>
  <input type="hidden" value="4" id="flag"/>
  <div class="right">
  <div class="rightContent">
    <center>
    <form name="" action="" method="post" enctype="multipart/form-data" id="addForm">
        <div style="height:50px;"></div>
			  <div style="height:40px; width:600px;">
  				<input type="text" name="RFID" id="text"  value="<?php echo $RFID ?>" style="width:300px;height:25px" >
  				<input type="button" id="RFID" value="扫描" onclick="query()" class="button" style="height:25px;" /> 
          <input type="submit" name="return"  value="查看"  class="button" style="height:25px;" /> 
  				<input name="return" type="submit" value="确认归还" class="button" style="height:25px;" /> 
			  </div>
        <div style="height:50px;"></div>
        <div  id="testDiv" style="width:500px;display:none;">
          <td>资产名称：</td>
          <input type="text" name="assetName" id="assetName" style="" value="<?php echo $assetName; ?>" disabled="true">
          <td>资产规格：</td>
          <input type="text" name="specification" id="specification" style="" value="<?php echo $specification; ?>" disabled="true">
          <td>存储仓库：</td>
          <input type="text" name="storageId" id="storageId" style="" value="<?php echo $storageId; ?>" disabled="true">
          <td>入库时间：</td>
          <input type="text" name="inTime" id="inTime" style="" value="<?php echo $inTime; ?>" disabled="true">
          <td>借出姓名：</td>
          <input type="text" name="name" id="name" style="" value="<?php echo $name; ?>" disabled="true">
          <td>资产价格：</td>
          <input type="text" name="price" id="price" style="" value="<?php echo $price; ?>" disabled="true">
        </div>
    </form>
    <!-- <h4 id="message" ></h4> -->
    </center>
  </div>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<script>
  $(document).ready(function(){
    // $("#updateForm").validate();
    // $("#updateForm").validate({
    //   rules:{
    //     assetName:"required",
    //     inTime:{
    //       required:true,
    //       date:true
    //     },
    //     storageId:{
    //       required:true,
    //       digits:true,
    //       min:0
    //     },
    //     Price:{
    //       required:true,
    //       number:true,
    //       min:0
    //     }
    //   }
    // });
  });
</script>
  <div class="right">
    <center>
      <div style="height:20px;"></div>
        <form name="" action="" method="post" id="updateForm">
        <div>
       
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>编号:</td>
              <?php
                if($data['RFID']=='')//assetId
                {
              ?>
              <td><?php echo $data['assetId'];?></td>
              <?php
                }else{
              ?>
              <td><?php echo $data['RFID'];?></td>
              <?php
                }
              ?>
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
              <td><input type="text" name="assetName" id="assetName" autocomplete="off" value="<?php echo $data['assetName'];?>" oninput="setCustomValidity('')" oninvalid="setCustomValidity('资产名称不能为空')" required></td>
            </tr>
            <tr>
              <td>资产规格:</td>
              <td><input type="text" name="specification" id="specification" autocomplete="off" oninput="setCustomValidity('')" oninvalid="setCustomValidity('资产型号不能为空')" required></td>
            </tr>
            <tr>
              <td>资产状态:</td>
              <td>
                <select name="state" id="state" required>
                  <option value="in" <?php if ($data['state']=="in") {echo "selected";}?>>库存中</option>
                  <option value="out" <?php if ($data['state']=="out") {echo "selected";}?>>借出</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>价格:</td>
              <td><input type="text" name="Price" id="Price" autocomplete="off" autocomplete="off" value="<?php echo $data['Price'];?>" pattern="\d{1,8}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('价格格式不正确(数字)')" required></td>
            </tr>
            <tr>
              <td>借出人电话:</td>
              <td><input type="text" name="brwPhone" id="brwPhone" autocomplete="off" value="<?php echo $data['brwPhone'];?>" pattern="\d{11}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('手机号码格式不对(11位)')" required></td>
            </tr>
            <tr>
              <td>存储仓库:</td>
              <td><input type="text" name="storageId" id="storageId" autocomplete="off" value="<?php echo $data['storageId'];?>" pattern="\d{1,3}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('仓库号码格式不对(1-3)')" required></td>
            </tr>
            <tr>
              <td>入库时间:</td>
              <td><input type="text" name="inTime" id="inTime" value="<?php echo $data['inTime'];?>" onclick="WdatePicker()" class="Wdate" autocomplete="off" required></td>
            </tr>
          </table>
          <div>
            <p><input type="submit" value="更新" name="update" onclick="writeUSR();" class="button1"></p>
            <a href="<?php echo  $this->createUrl('index')?>">返回</a>
          </div>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
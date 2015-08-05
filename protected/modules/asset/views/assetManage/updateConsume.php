<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<input type="hidden" value="1" id="flag"/>
  <div class="right">
    <center>
      <div style="height:50px;"></div>
        <form name="" action="" method="post" id="updateForm" onsubmit="return check()">
        <div>
          <? var_dump($data)?>
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>资产编号:</td>
              <td id="text"><?php echo $data['assetId'];?></td>
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
              <td><input type="text" name="assetName" id="assetName" oninput="setCustomValidity('')" oninvalid="setCustomValidity('资产名称不能为空')" value="<?php echo $data['assetName'];?>" required></td>
            </tr>
            <tr>
              <td>资产规格:</td>
              <td><input type="text" name="specification" id="specification" oninput="setCustomValidity('')" oninvalid="setCustomValidity('资产规格不能为空')" value="<?php echo $data['specification'];?>" required></td>
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
              <td><input type="text" name="Price" id="Price" pattern="\d{1,8}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('价格格式不正确(数字)')" value="<?php echo $data['Price'];?>" required></td>
            </tr>
            <tr>
              <td>借出人电话:</td>
              <td><input type="text" name="brwPhone" id="brwPhone" value="<?php echo $data['brwPhone'];?>"></td>
            </tr>
            <tr>
              <td>存储仓库:</td>
              <td><input type="text" name="storageId" id="storageId" pattern="\d{1,3}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('仓库号码格式不对(1-3)')" value="<?php echo $data['storageId'];?>" required></td>
            </tr>
            <tr>
              <td>入库时间:</td>
              <td><input type="text" name="inTime" id="inTime" value="<?php echo $data['inTime'];?>" autocomplete="off" onclick="WdatePicker()" required></td>
            </tr>
          </table>
        </div>
        <div>
          <p><input type="submit" value="更新" name="update" onclick="writeUSR();" class="button1"></p>
          <a href="<?php echo  $this->createUrl('findAll&type=consume')?>">返回</a>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
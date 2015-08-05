<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<input type="hidden" value="2" id="flag"/>
  <div class="right">
    <center>
      <div style="height:50px;"></div>
        <form name="" action="" method="post" id="updateForm" onsubmit="return check()">
        <div>
          <? var_dump($data)?>
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>课程编号:</td>
              <td><?php echo $data['courseId'];?></td>
            </tr>
            <tr>
              <td>课程名称:</td>
               <td><input type="text" name="courseName" id="courseName" oninput="setCustomValidity('')" oninvalid="setCustomValidity('课程名称不能为空')" value="<?php echo $data['courseName'];?>" required></td>
            </tr>
            <tr>
              <td>授课教师工号:</td>
              <td><input type="text" name="teacherId" id="teacherId" oninput="setCustomValidity('')" oninvalid="setCustomValidity('教师工号不能为空')" value="<?php echo $data['teacherId'];?>" required></td>
            </tr>
            <tr>
              <td>上课人数:</td>
              <td><input type="text" name="total" id="total" oninput="setCustomValidity('')" oninvalid="setCustomValidity('上课人数不能为空')" value="<?php echo $data['total'];?>" required></td>
            </tr>
          </table>
        </div>
        <div>
          <p><input type="submit" value="更新" name="update" class="button1"></p>
          <a href="<?php echo  $this->createUrl('courseManageFindAll')?>">返回</a>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
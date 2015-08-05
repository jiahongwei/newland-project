<?php echo $this->renderPartial('/_include/header')?>
<?php echo $this->renderPartial('/_include/left')?>
<input type="hidden" value="1" id="flag"/>
  <div class="right">
    <center>
      <div style="height:50px;"></div>
        <form name="" action="" method="post" id="updateForm">
        <div>
          <table border="0px" cellspacing="0px" class="addForm">
            <tr>
              <td>学号:</td>
              <td><?php echo $data['stuId'];?></td>
            </tr>
            <tr>
              <td>姓名:</td>
               <td><input type="text" name="stuName" id="stuName" oninput="setCustomValidity('')" oninvalid="setCustomValidity('学生姓名不能为空')" value="<?php echo $data['stuName'];?>" required></td>
            </tr>
            <tr>
              <td>专业:</td>
              <td><input type="text" name="profession" id="profession" oninput="setCustomValidity('')" oninvalid="setCustomValidity('专业不能为空')" value="<?php echo $data['profession'];?>" required></td>
            </tr>
            <tr>
              <td>年级:</td>
              <td><input type="text" name="grade" id="grade" oninput="setCustomValidity('')" oninvalid="setCustomValidity('年级不能为空')" value="<?php echo $data['grade'];?>" required></td>
            </tr>
            <tr>
              <td>班级:</td>
              <td><input type="text" name="classId" id="classId" oninput="setCustomValidity('')" oninvalid="setCustomValidity('班级不能为空')" value="<?php echo $data['classId'];?>" required></td>
            </tr>
            <tr>
              <td>电话:</td>
              <td><input type="text" name="phone" id="phone" oninput="setCustomValidity('')" oninvalid="setCustomValidity('电话不能为空')" value="<?php echo $data['phone'];?>" required></td>
            </tr>
          </table>
        </div>
        <div>
          <p><input type="submit" value="更新" name="update" class="button1"></p>
          <a href="<?php echo  $this->createUrl('studentManageFindAll')?>">返回</a>
        </div>
        </form>
      </center>
  </div>
<?php echo $this->renderPartial('/_include/footer')?>
<?php
include_once('top.php');

//$msg='';
$id='';
$name='';
$email='';
$mobile='';
$password='';
if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
     $row = mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$id'"));
     $name=$row['name'];
     $email=$row['email'];
     $mobile=$row['mobile'];
     $password=$row['password'];
     
      //redirect('categories.php');
  }


if(isset($_POST['submit'])){
    $name=get_safe_value($_POST['name']);
    $email=get_safe_value($_POST['email']);
    $mobile=get_safe_value($_POST['mobile']);
    $password=get_safe_value($_POST['password']);
    date_default_timezone_set('Asia/Kolkata');
    $date=date('Y-m-d h:i:s');
    if($id==''){
      $sql="select * from users where email='$email'";
    }
    else {
      $sql="select * from users where email='$email' and id!='$id'";
    }
    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $msg='Users is already added';
    }
    else {
      if($id==''){
        $sql=mysqli_query($con,"INSERT INTO users(`name`,email,`mobile`,`password`,`status`,added_on) values('$name','$email','$mobile',$password,'1','$date')");
        $msg="Users added successfully.";
      }
      else {
        $sql=mysqli_query($con,"UPDATE users set `name`='$name',email='$email',`password`='$password' where id='$id'");
        $msg="Users updated successfully.";
      }
      
    
    }
    
}

$sql="select * from users order by id desc";
$res=mysqli_query($con,$sql);

?>

  
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <?php
          if(isset($msg)){
              echo '<span class="alert bg-success text-white mb-5 block">'. $msg.'</span>';
          }
          ?>
        
      <a href="users.php" class="btn btn-primary float-right mb-4">View Users</a>
          <div class="row">
			<h1 class="card-title ml10">Manage Users</h1>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?=$name?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Add order number" value="<?=$email?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Add order number" value="<?=$mobile?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Password</label>
                      <input type="text" class="form-control" id="password" name="password" placeholder="Add order number" value="<?=$password?>">
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
        
		</div>  
      <!-- main-panel ends -->
        
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       
        <?php
include_once('footer.php');
?>
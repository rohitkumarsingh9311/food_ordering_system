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
     $row = mysqli_fetch_assoc(mysqli_query($con,"select * from delivery_boy where id='$id'"));
     $name=$row['name'];
     $mobile=$row['mobile'];
     $password=$row['password'];
     
      //redirect('categories.php');
  }


if(isset($_POST['submit'])){
    $name=get_safe_value($_POST['name']);
    $mobile=get_safe_value($_POST['mobile']);
    $password=get_safe_value($_POST['password']);
    
    date_default_timezone_set('Asia/Kolkata');
    $date=date('Y-m-d h:i:s');
    if($id==''){
      $sql="select * from delivery_boy where mobile='$mobile'";
    }
    else {
      $sql="select * from delivery_boy where mobile='$mobile' and id!='$id'";
    }
    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $msg='Delivery boy is already added';
    }
    else {
      if($id==''){
         $sql=mysqli_query($con,"INSERT INTO delivery_boy(`name`,`mobile`,`password`,`status`,added_on) values('$name','$mobile','$password','1','$date')");
         $id='';
          $name='';
          $email='';
          $mobile='';
          $password='';
         
        $msg="Delivery boy added successfully.";
      }
      else {
        $sql=mysqli_query($con,"UPDATE delivery_boy set `name`='$name',`mobile`='$mobile',`password`='$password' where id='$id'");
        header('location:delivery_boy.php');
        $msg="Delivery boy updated successfully.";
      }
      
    
    }
    
}


?>

  
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <?php
          if(isset($msg)){
              echo '<span class="alert bg-success text-white mb-5 block">'. $msg.'</span>';
          }
          ?>
        
      <a href="delivery_boy.php" class="btn btn-primary float-right mb-4">View Users</a>
          <div class="row">
			<h1 class="card-title ml10">Manage Delivery Boy</h1>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?=$name?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Add mobile number" value="<?=$mobile?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Password</label>
                      <input type="text" class="form-control" id="password" name="password" placeholder="Add password" value="<?=$password?>">
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
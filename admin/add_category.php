<?php
include_once('top.php');

//$msg='';
$id='';
$category='';
$order_number='';
if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
     $row = mysqli_fetch_assoc(mysqli_query($con,"select * from categories where id='$id'"));
     $category=$row['category'];
     $order_number=$row['order_number'];
     
      //redirect('categories.php');
  }


if(isset($_POST['submit'])){
    $category=get_safe_value($_POST['category']);
    $order_number=get_safe_value($_POST['order_number']);
    date_default_timezone_set('Asia/Kolkata');
    $date=date('Y-m-d h:i:s');
    if($id==''){
      $sql="select * from categories where category='$category'";
    }
    else {
      $sql="select * from categories where category='$category' and id!='$id'";
    }
    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $msg='Category is already added';
    }
    else {
      if($id==''){
        $sql=mysqli_query($con,"INSERT INTO categories(category,order_number,`status`,added_on) values('$category','$order_number','1','$date')");
        $msg="Catogory Added successfully.";
      }
      else {
        $sql=mysqli_query($con,"UPDATE categories set category='$category',order_number='$order_number' where id='$id'");
        $msg="Catogory Updated successfully.";
      }
      
    
    }
    
}

$sql="select * from categories order by order_number";
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
        
      <a href="categories.php" class="btn btn-primary float-right mb-4">View Category +</a>
          <div class="row">
			<h1 class="card-title ml10">Manage Category</h1>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Category</label>
                      <input type="text" class="form-control" name="category" id="exampleInputName1" placeholder="Name" value="<?=$category?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Order Number</label>
                      <input type="text" class="form-control" id="order_number" name="order_number" placeholder="Add order number" value="<?=$order_number?>">
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
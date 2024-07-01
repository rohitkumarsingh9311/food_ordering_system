<?php
include_once('top.php');
//$msg='';
$id='';
$category_id='';
$dish='';
$dish_detail='';
$image='';
$image_required='required';
$image_error='';
if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
     $row = mysqli_fetch_assoc(mysqli_query($con,"select * from dish where id='$id'"));
     $category_id=$row['category_id'];
     $dish=$row['dish'];
     $dish_detail=$row['dish_detail'];
     $image=$row['image'];
     $image_required='';
     
      //redirect('categories.php');
  }


if(isset($_POST['submit'])){
    $category_id=get_safe_value($_POST['category_id']);
    $dish=get_safe_value($_POST['dish']);
    $dish_detail=get_safe_value($_POST['dish_detail']);
    
    date_default_timezone_set('Asia/Kolkata');
    $date=date('Y-m-d h:i:s');
    if($id==''){
      $sql="select * from dish where dish='$dish'";
    }
    else {
      $sql="select * from dish where dish='$dish' and id!='$id'";
    }
    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $msg='Dish is already added';
    }
    else {
      if($id==''){
        $image_type=$_FILES['image']['type'];
        //if($image_type="")
        $image=$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],SERVER_DISH_IMAGE.$_FILES['image']['name']);
         $sql=mysqli_query($con,"INSERT INTO dish(`category_id`,`dish`,`dish_detail`,`image`,`status`,added_on) values('$category_id','$dish','$dish_detail','$image','1','$date')");
         $id='';
          $category_id='';
          $dish='';
          $dish_detail='';
          $image='';
         
        $msg="Dish added successfully.";
      }
      else {
        if($_FILES['image']['name']!=''){  
          $image=$_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],SERVER_DISH_IMAGE.$_FILES['image']['name']);

          $sql=mysqli_query($con,"UPDATE dish set `category_id`='$category_id',`dish`='$dish',`dish_detail`='$dish_detail',`image`='$image' where id='$id'");
        }
        else {
          $sql=mysqli_query($con,"UPDATE dish set `category_id`='$category_id',`dish`='$dish',`dish_detail`='$dish_detail' where id='$id'");
        }
        redirect('dish.php');
        $msg="Dish updated successfully.";
      }
      
    
    }
    
}

$res_category=mysqli_query($con,"SELECT * FROM categories where status='1'");


?>

  
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <?php
          if(isset($msg)){
              echo '<span class="alert bg-success text-white mb-5 block">'. $msg.'</span>';
          }
          ?>
        
      <a href="dish.php" class="btn btn-primary float-right mb-4">View Dish</a>
          <div class="row">
			<h1 class="card-title ml10">Manage Dish</h1>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Category</label>
                    
                      <select  class="form-control" name="category_id" id="category_id">
                        <option value="">Select Category</option>
                          <?php
                          if(mysqli_num_rows($res_category)>0){
                            while($categories=mysqli_fetch_assoc($res_category)){
                              if($categories['id']==$category_id){
                                ?>
                                <option value="<?php echo $categories['id'] ?>" selected><?php echo $categories['category'] ?></option>
                                <?php
                              } else {
                                ?>
                                <option value="<?php echo $categories['id'] ?>"><?php echo $categories['category'] ?></option>
                                <?php
                              }
                            }
                          } else {
                            
                          }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="order_number">Dish Name</label>
                      <input type="text" class="form-control" id="dish" name="dish" placeholder="Add Dish Name" value="<?=$dish?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Dish Details</label>
                      <textarea class="form-control" id="dish_detail" name="dish_detail"><?=$dish_detail?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="order_number">Image</label>
                      <input type="file" class="form-control" id="image" name="image" <?php echo $image_required ?>/>
                      <p class="text-danger"><?php echo $image_error ?></p>
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
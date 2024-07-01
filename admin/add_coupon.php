<?php
include_once('top.php');

//$msg='';
$id='';
$coupon_code='';
$coupon_type='';
$coupon_value='';
$cart_min_value='';
$expired_on='';
if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
     $row = mysqli_fetch_assoc(mysqli_query($con,"select * from coupons where id='$id'"));
     $coupon_code=$row['coupon_code'];
     $coupon_type=$row['coupon_type'];
     $coupon_value=$row['coupon_value'];
     $cart_min_value=$row['cart_min_value'];
     $expired_on=$row['expired_on'];

    // value="<?php echo date('Y-m-d',strtotime($data["congestart"])) 
  }


if(isset($_POST['submit'])){
    $coupon_code=get_safe_value($_POST['coupon_code']);
    $coupon_type=get_safe_value($_POST['coupon_type']);
    $coupon_value=get_safe_value($_POST['coupon_value']);
    $cart_min_value=get_safe_value($_POST['cart_min_value']);
    $expired_on=get_safe_value($_POST['expired_on']);
    
    date_default_timezone_set('Asia/Kolkata');
    $date=date('Y-m-d h:i:s');
    $expired_on=strtotime($expired_on);
    $expired_on=date('Y-m-d',$expired_on);
    if($id==''){
      $sql="select * from coupons where coupon_code='$coupon_code'";
    }
    else {
      $sql="select * from coupons where coupon_code='$coupon_code' and id!='$id'";
    }
    if(mysqli_num_rows(mysqli_query($con,$sql))>0){
      $msg='Coupons is already added';
    }
    else {
      if($id==''){
         $sql=mysqli_query($con,"INSERT INTO coupons(`coupon_code`,coupon_type,`coupon_value`,`cart_min_value`,`expired_on`,`status`,added_on) values('$coupon_code','$coupon_type','$coupon_value','$cart_min_value','$expired_on','1','$date')");
                  
          $id='';
          $coupon_code='';
          $coupon_type='';
          $coupon_value='';
          $cart_min_value='';
          $expired_on='';
         
        $msg="Coupons added successfully.";
      }
      else {
        $sql=mysqli_query($con,"UPDATE coupons set `coupon_code`='$coupon_code',coupon_type='$coupon_type',`coupon_value`='$coupon_value',`cart_min_value`='$cart_min_value',`expired_on`='$expired_on' where id='$id'");
        $msg="Coupons updated successfully.";
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
        
      <a href="coupons.php" class="btn btn-primary float-right mb-4">View Coupons</a>
          <div class="row">
			<h1 class="card-title ml10">Manage Coupons</h1>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Coupon Name</label>
                      <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Name" value="<?=$coupon_code?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Coupon Type</label>
                      <select class="form-control" id="coupon_type" name="coupon_type">
                      <option value="">Select Type</option>
                      <?php 
                          $arr=array('P'=>'Precentage','F'=>'Fixed');
                          foreach($arr as $key=>$item) {
                            if($key==$coupon_type) {
                              
                      ?>
                        <option value="<?php echo $key ?>" selected><?php echo $item ?></option>
                       <?php 
                      }
                      else {
                        ?>
                        <option value="<?php echo $key ?>"><?php echo $item ?></option>
                        <?php
                      }
                      }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="order_number">Coupon Value</label>
                      <input type="text" class="form-control" id="coupon_value" name="coupon_value" placeholder="Add order number" value="<?=$coupon_value?>">
                    </div>
                    <div class="form-group">
                      <label for="order_number">Cart Minimum Order</label>
                      <input type="text" class="form-control" id="cart_min_value" name="cart_min_value" placeholder="Add order number" value="<?=$cart_min_value?>">
                    </div>
                    
                    <div class="form-group">
                      <label for="order_number">Expired On</label>
                      <input type="date" class="form-control" id="expired_on" name="expired_on" placeholder="Add order number" value="<?= date('Y-m-d',strtotime($expired_on))?>">
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
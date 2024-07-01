<?php
include_once('top.php');
$msg='';
if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']!=''){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='delete'){
        mysqli_query($con,"delete from coupons where id='$id'");
        $msg='Coupons deleted successfully';
        //redirect('categories.php');
    }
    if($type=='active' || $type=='deactive'){
        $status=1;
        if($type=='deactive') {
            $status=0;
        } else {
            $status=1;
        }
         $sql="update coupons set status='$status' where id='$id'";
        
        
        mysqli_query($con,$sql);
        redirect('coupons.php');
    }

}
$sql="select * from coupons order by id desc";
$res=mysqli_query($con,$sql);

?>


      <!-- partial -->
      <div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="grid-title">Coupon Master</h2>
              <p><?= $msg ?></p>
              <div class="row">
                <div class="col-12">
                <a href="add_coupon.php" class="btn btn-primary float-right mb-4">Add Coupon +</a>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S. no #</th>
                            <th>Code/Value</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Cart min.</th>
                            <th>Expired On</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(mysqli_num_rows($res)>0){
                            $i=1;
                            while($row=mysqli_fetch_assoc($res)){
                                
                            ?>
                            
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?= $row['coupon_code'] ?></td>
                            <td><?= $row['coupon_type'] ?></td>
                            <td><?= $row['coupon_value'] ?></td>
                            <td><?= $row['cart_min_value'] ?></td>
                            <td><?= $row['expired_on'] ?></td>
                            <td><?php
                            $dateStr=strtotime($row['added_on']);
                            echo date('d-m-Y',$dateStr);?></td>
                            <td>
                             <a href="add_coupon.php?id=<?=$row['id']?>"><lable class="badge badge-success">Edit</lable></a>
                             <?php 
                                if($row['status']==1) {
                                    ?>
                                   <a href="?type=deactive&id=<?php  echo $row['id'] ?>"><lable class="badge badge-primary">Active</lable></a>
                                <?php
                                } else {
                                    ?>
                                    <a href="?type=active&id=<?php  echo $row['id'] ?>"><lable class="badge badge-danger">Deactive</lable></a>
                                    <?php
                                }
                             ?>
                             
                              <a href="?id=<?php echo $row['id'] ?>&type=delete"><lable class="badge badge-danger delete_red">Delete</lable></a>
                              
                            </td>
                        </tr>
                        <?php
                        $i++;
                            }
                        } else {
                            echo 'no data found.';
                        }
                        ?>
                       
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>
        
		</div>
        
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
       
        <?php
include_once('footer.php');
?>
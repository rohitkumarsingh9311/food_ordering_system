<?php
include_once('top.php');
$msg='';
if(isset($_GET['type']) && $_GET['type']!='' && isset($_GET['id']) && $_GET['id']!=''){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='delete'){
        mysqli_query($con,"delete from categories where id='$id'");
        $msg='category deleted successfully';
        //redirect('categories.php');
    }
    if($type=='active' || $type=='deactive'){
        $status=1;
        if($type=='deactive') {
            $status=0;
        } else {
            $status=1;
        }
         $sql="update categories set status='$status' where id='$id'";
        
        
        mysqli_query($con,$sql);
        redirect('categories.php');
    }

}
$sql="select * from categories order by order_number";
$res=mysqli_query($con,$sql);

?>


      <!-- partial -->
      <div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h2 class="grid-title">Category Master</h2>
              <p><?= $msg ?></p>
              <div class="row">
                <div class="col-12">
                <a href="add_category.php" class="btn btn-primary float-right mb-4">Add Category +</a>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S. no #</th>
                            <th>Category</th>
                            <th>Order No.</th>
                            <th>Actions</th>
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
                            <td><?= $row['category'] ?></td>
                            <td><?= $row['order_number'] ?></td>
                            <td>
                             <a href="add_category.php?id=<?=$row['id']?>"><lable class="badge badge-success">Edit</lable></a>
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
<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Coupons</h1>
	</div>
	<div class="content-header-right">
		<a href="coupon-add.php" class="btn btn-primary btn-sm">Add New</a>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>SL</th>
			        <th>Coupon Code</th>
                    <th>Coupon Amount</th>
                    <th>Coupon Expiry</th>
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_coupon ORDER BY coupon_id ASC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['coupon_code']; ?></td>
                        <td><?php echo number_format($row['coupon_amount']); ?></td>
                        <td><?php echo $row['coupon_expiry']; ?></td>
	                    <td>
	                        <a href="coupon-edit.php?id=<?php echo $row['coupon_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="coupon-delete.php?id=<?php echo $row['coupon_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  

</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>
<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['coupon_code'])) {
        $valid = 0;
        $error_message .= "Coupon Code can not be empty<br>";
    } else {
		// Duplicate coupon checking
    	// current coupon name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_coupon_code = $row['coupon_code'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_code=? and coupon_code!=?");
    	$statement->execute(array($_POST['coupon_code'],$current_coupon_code));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Coupon Code already exists<br>';
    	}
    }
    if(empty($_POST['coupon_amount'])) {
        $valid = 0;
        $error_message .= "Coupon Amount can not be empty<br>";
    } 

    if(empty($_POST['coupon_expiry'])) {
        $valid = 0;
        $error_message .= "Coupon Expiry can not be empty<br>";
    } 

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_coupon SET coupon_code=?, coupon_amount=?, coupon_expiry=? WHERE coupon_id=?");
		$statement->execute(array($_POST['coupon_code'],$_POST['coupon_amount'],$_POST['coupon_expiry'],$_REQUEST['id']));

    	$success_message = 'Coupon is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit coupon</h1>
	</div>
	<div class="content-header-right">
		<a href="coupon.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$coupon_code = $row['coupon_code'];
    $coupon_amount = $row['coupon_amount'];
    $coupon_expiry = $row['coupon_expiry'];
}
?>

<section class="content">

  <div class="row">
    <div class="col-md-12">

		<?php if($error_message): ?>
		<div class="callout callout-danger">
		
		<p>
		<?php echo $error_message; ?>
		</p>
		</div>
		<?php endif; ?>

		<?php if($success_message): ?>
		<div class="callout callout-success">
		
		<p><?php echo $success_message; ?></p>
		</div>
		<?php endif; ?>

        <form class="form-horizontal" action="" method="post">

        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Coupon Code <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="coupon_code" autocapitalize="characters" value="<?php echo $coupon_code; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Coupon Amount <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="coupon_amount" value="<?php echo $coupon_amount ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Coupon Expiry <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" name="coupon_expiry" value="<?php echo $coupon_expiry ?>">
                    </div>
                </div>
                <div class="form-group">
                	<label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                    </div>
                </div>

            </div>

        </div>

        </form>



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
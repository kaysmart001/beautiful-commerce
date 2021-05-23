<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['coupon_code'])) {
        $valid = 0;
        $error_message .= "Coupon code can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_coupon WHERE coupon_code=?");
    	$statement->execute(array($_POST['coupon_code']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Coupon Code already exists<br>";
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

		// Saving data into the main table tbl_coupon
		$statement = $pdo->prepare("INSERT INTO tbl_coupon (coupon_code,coupon_amount,coupon_expiry) VALUES (?,?,?)");
		$statement->execute(array($_POST['coupon_code'],$_POST['coupon_amount'],$_POST['coupon_expiry']));
	
    	$success_message = 'Coupon is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add coupon</h1>
	</div>
	<div class="content-header-right">
		<a href="coupon.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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
								<input type="text" class="form-control" name="coupon_code" autocapitalize="characters">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Coupon Amount <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="coupon_amount">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Coupon Expiry <span>*</span></label>
							<div class="col-sm-4">
								<input type="date" class="form-control" name="coupon_expiry">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>
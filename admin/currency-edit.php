<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['currency_name'])) {
        $valid = 0;
        $error_message .= "Currency Name can not be empty<br>";
    } elseif(empty($_POST['currency_code'])) {
        $valid = 0;
        $error_message .= "Currency Code can not be empty<br>";
    } else {
		// Duplicate Size checking
    	// current size name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_currency WHERE currency_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_currency_name = $row['currency_name'];
			$current_currency_code = $row['currency_code'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_currency WHERE currency_name=? and currency_name!=?");
    	$statement->execute(array($_POST['currency_name'],$current_currency_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Currency name already exists<br>';
    	}
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_currency SET currency_name=?, currency_code=? WHERE currency_id=?");
		$statement->execute(array($_POST['currency_name'],$_POST['currency_code'],$_REQUEST['id']));

    	$success_message = 'Currency is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_currency WHERE currency_id=?");
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
		<h1>Edit Currency</h1>
	</div>
	<div class="content-header-right">
		<a href="currency.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$currency_name = $row['currency_name'];
	$currency_code = $row['currency_code'];
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
                    <label for="" class="col-sm-2 control-label">Currency Name <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="currency_name" value="<?php echo $currency_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Currency Code<span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="currency_code" value="<?php echo $currency_code; ?>">
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
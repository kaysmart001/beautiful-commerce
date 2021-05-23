<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['brand_name'])) {
        $valid = 0;
        $error_message .= "Brand Name can not be empty<br>";
    } else {
		// Duplicate brand checking
    	// current brand name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_brand WHERE brand_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_brand_name = $row['brand_name'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_brand WHERE brand_name=? and brand_name!=?");
    	$statement->execute(array($_POST['brand_name'],$current_brand_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Brand name already exists<br>';
    	}
    }

    $path = $_FILES['brand_image']['name'];
    $path_tmp = $_FILES['brand_image']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {  

        if($path=='') {
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_brand SET brand_name=? WHERE brand_id=?");
		$statement->execute(array($_POST['brand_name'],$_REQUEST['id']));

    	$success_message = 'Brand is updated successfully.';
        }else{
            // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_brand WHERE brand_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $image = $row['brand_image'];
            unlink('../assets/uploads/brands/'.$image);
        }

        // uploading the image
        $final_name = 'Brand'.mt_rand().'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/brands/'.$final_name ); 

        // updating into the database
        $statement = $pdo->prepare("UPDATE tbl_brand SET brand_name=?, brand_image=? WHERE brand_id=?");
        $statement->execute(array($_POST['brand_name'],$final_name,$_REQUEST['id']));

        $success_message = 'Brand is updated successfully.';
        }
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_brand WHERE brand_id=?");
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
		<h1>Edit Brand</h1>
	</div>
	<div class="content-header-right">
		<a href="brand.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$brand_name = $row['brand_name'];
    $brand_image = $row['brand_image'];
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

        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Brand Name <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="brand_name" value="<?php echo $brand_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Existing Photo</label>
                    <div class="col-sm-6" style="padding-top:6px;">
                        <img src="../assets/uploads/brands/<?php echo $brand_image; ?>" class="existing-photo" style="height:80px;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Brand Image</label>
                    <div class="col-sm-6" style="padding-top:6px;">
                        <input type="file" name="brand_image">
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
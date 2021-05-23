<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['brand_name'])) {
        $valid = 0;
        $error_message .= "Brand Name can not be empty<br>";
    } else {
    	// Duplicate Brand checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_brand WHERE brand_name=?");
    	$statement->execute(array($_POST['brand_name']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Brand Name already exists<br>";
    	}
    }

    if($_FILES['brand_image']['name'] == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
    	$path = $_FILES['brand_image']['name'];
    	$path_tmp = $_FILES['brand_image']['tmp_name'];
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// uploading the image
        $final_name = 'Brand'.mt_rand().'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/brands/'.$final_name );
		// Saving data into the main table tbl_size
		$statement = $pdo->prepare("INSERT INTO tbl_brand (brand_name,brand_image) VALUES (?,?)");
		$statement->execute(array($_POST['brand_name'],$final_name));
	
    	$success_message = 'Brand is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Brand</h1>
	</div>
	<div class="content-header-right">
		<a href="brand.php" class="btn btn-primary btn-sm">View All</a>
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

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Brand Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="brand_name">
							</div>
						</div>
						<div class="form-group">
                            <label for="" class="col-sm-2 control-label">Brand Image *</label>
                            <div class="col-sm-6" style="padding-top:6px;">
                                <input type="file" name="brand_image">
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
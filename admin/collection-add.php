<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['collection_name'])) {
        $valid = 0;
        $error_message .= "Collection Name can not be empty<br>";
    } else {
    	// Duplicate collection checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_collection WHERE collection_name=?");
    	$statement->execute(array($_POST['collection_name']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Collection Name already exists<br>";
    	}
    }
    if(empty($_POST['content'])) {
        $valid = 0;
        $error_message .= "Content can not be empty<br>";
    }
    if($_FILES['collection_image']['name'] == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
    	$path = $_FILES['collection_image']['name'];
    	$path_tmp = $_FILES['collection_image']['tmp_name'];
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
    	// uploading the image
        $final_name = 'collection'.mt_rand().'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/collections/'.$final_name );
		// Saving data into the main table tbl_size
		$statement = $pdo->prepare("INSERT INTO tbl_collection (collection_name,collection_content,collection_image) VALUES (?,?,?)");
		$statement->execute(array($_POST['collection_name'],$_POST['content'],$final_name));
	
    	$success_message = 'Collection is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Collection</h1>
	</div>
	<div class="content-header-right">
		<a href="collection.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Collection Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="collection_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content *</label>
							<div class="col-sm-6">
								<textarea class="form-control" name="content" style="height:140px;"></textarea>
							</div>
						</div>
						<div class="form-group">
                            <label for="" class="col-sm-2 control-label">Collection Image *</label>
                            <div class="col-sm-6" style="padding-top:6px;">
                                <input type="file" name="collection_image">
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="activate" name="active">
                          <label class="custom-control-label" for="activate">Active</label>
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
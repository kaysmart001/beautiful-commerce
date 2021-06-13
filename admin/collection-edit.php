<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['collection_name'])) {
        $valid = 0;
        $error_message .= "Collection Name can not be empty<br>";
    } else {
		// Duplicate brand checking
    	// current brand name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_collection WHERE collection_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_collection_name = $row['collection_name'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_collection WHERE collection_name=? and collection_name!=?");
    	$statement->execute(array($_POST['collection_name'],$current_collection_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Collection name already exists<br>';
    	}
    }

    if(empty($_POST['content'])) {
        $valid = 0;
        $error_message .= "Collection Content can not be empty<br>";
    }

    $path = $_FILES['collection_image']['name'];
    $path_tmp = $_FILES['collection_image']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    $active=isset($_POST['active']) ? 1 : 0;

    if($valid == 1) {  

        if($path=='') {
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_collection SET collection_name=?, collection_content=?, active=? WHERE collection_id=?");
		$statement->execute(array($_POST['collection_name'],$_POST['content'],$active, $_REQUEST['id']));

    	$success_message = 'Collection is updated successfully.';
        }else{
            // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_collection WHERE collection_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $image = $row['collection_image'];
            unlink('../assets/uploads/collections/'.$image);
        }

        // uploading the image
        $final_name = 'collection'.mt_rand().'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/collections/'.$final_name ); 

        // updating into the database
        $statement = $pdo->prepare("UPDATE tbl_collection SET collection_name=?, collection_content=?, collection_image=?, active=? WHERE collection_id=?");
        $statement->execute(array($_POST['collection_name'],$_POST['content'],$final_name, $active, $_REQUEST['id']));

        $success_message = 'Collection is updated successfully.';
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
	$statement = $pdo->prepare("SELECT * FROM tbl_collection WHERE collection_id=?");
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
		<h1>Edit Collection</h1>
	</div>
	<div class="content-header-right">
		<a href="collection.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$collection_name = $row['collection_name'];
    $collection_image = $row['collection_image'];
    $collection_content = $row['collection_content'];
    $active = $row['active'];
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
                    <label for="" class="col-sm-2 control-label">Collection Name <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="collection_name" value="<?php echo $collection_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Collection Content *</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="content" style="height:140px;"><?php echo $collection_content; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Existing Photo</label>
                    <div class="col-sm-6" style="padding-top:6px;">
                        <img src="../assets/uploads/collections/<?php echo $collection_image; ?>" class="existing-photo" style="height:80px;">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Collection Image</label>
                    <div class="col-sm-6" style="padding-top:6px;">
                        <input type="file" name="collection_image">
                    </div>
                </div>
                <div class="mid">
                  <label class="col-sm-2 control-label">Active ? *</label>
                  <label class="rocker rocker-small">
                    <input type="checkbox" name="active"  <?php echo $active==1 ? "checked": ""; ?>>
                    <span class="switch-left">Yes</span>
                    <span class="switch-right">No</span>
                  </label>
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
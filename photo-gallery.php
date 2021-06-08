<?php include_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $pgallery_title = $row['pgallery_title'];
    $pgallery_banner = $row['pgallery_banner'];
}
?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>Photo Gallery</h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="photo-gallery.php">photo gallery</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<section class="section-big-py-space ratio_square b-g-light">
    <div class="container">
           <?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;
            
            $statement = $pdo->prepare("SELECT * FROM tbl_photo ORDER BY id DESC");
			$statement->execute();
            $total_pages = $statement->rowCount();


            $targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
            $limit = 12;                                 //how many items to show per page
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;          //first item to display on this page
            else
                $start = 0;
            
            $statement = $pdo->prepare("SELECT * FROM tbl_photo ORDER BY id DESC LIMIT $start, $limit");
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
			    $pagination .= "<nav aria-label=\"Page navigation example\"><ul class=\"pagination pagination-lg justify-content-center\">";
			    if ($page > 1) 
			        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$prev\">&#171; previous</a></li>";
			    elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
			    {
			        if($page < 1 + ($adjacents * 2))        
			        {
			            $pagination.= "...";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
			        }
			        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			        {
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=1\">1</a></li>";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=2\">2</a></li>";
			            $pagination.= "...";
			            $pagination.= "...";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
			        }
			        else
			        {
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=1\">1</a></li>";
			            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=2\">2</a></li>";
			            $pagination.= "...";
			        }
			    }
			    if ($page < $lastpage) 
			        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$next\">next &#187;</a></li>";
			        $pagination.= "</ul></nav>\n";   
			}
			/* ===================== Pagination Code Ends ================== */

            ?>
            <?php foreach ($result as $row): ?>
            	<div class="col-md-4 col-sm-6 co-xs-12">
				<div class="box">
					<a href="#" data-toggle="modal" data-target="#<?php echo $row['id']; ?>">
						<img src="assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['caption']; ?>">
					</a>
					<div class="modal fade" id="<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
								<div class="modal-body">
									<img src="assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['caption']; ?>">
								</div>
								<div class="col-md-12 description">
									<h4><?php echo $row['caption']; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<div class="pagination">
            <?php 
                echo $pagination; 
            ?>
        </div>
    </div>
</section>

<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
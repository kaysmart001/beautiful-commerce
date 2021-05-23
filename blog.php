<?php include_once('header.php'); ?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>blog</h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="blog.php">blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<?php
/* ===================== Pagination Code Starts ================== */
$adjacents = 5;

$statement = $pdo->prepare("SELECT * 
                            FROM tbl_post t1
                            JOIN tbl_category t2 
                            ON t1.category_id = t2.category_id 
                            ORDER BY t1.post_id DESC");                
$statement->execute();
$total_pages = $statement->rowCount();


$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
$limit = 10;                                 //how many items to show per page
$page = @$_GET['page'];
if($page) 
    $start = ($page - 1) * $limit;          //first item to display on this page
else
    $start = 0;

$statement = $pdo->prepare("SELECT * 
                            FROM tbl_post t1
                            JOIN tbl_category t2 
                            ON t1.category_id = t2.category_id 
                            ORDER BY t1.post_id DESC
                            LIMIT $start, $limit"); 
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
<!-- section start -->
<section class="section-big-py-space blog-page ratio2_3">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7">
				<?php foreach ($result as $row): ?>
                <div class="row blog-media">
                    <div class="col-xl-6">
                        <div class="blog-left">
                            <a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><img src="assets/uploads/<?php echo $row['photo']; ?>" class="img-fluid  " alt="<?php echo $row['post_title']; ?>"></a>
                            <div class="date-label">
                                <?php $date=date_create($row['post_date']); ?>
                                <?php echo date_format($date,"D jS M Y"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="blog-right">
                            <div>
                                 <a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><h4><?php echo $row['post_title']; ?></h4> </a>
                                <ul class="post-social">
                                    <li>Posted By : Admin</li>
                                    <li><i class="fa fa-heart"></i> <?php echo $row['total_view']; ?> Hits</li>
                                    <li><i class="fa fa-tag"></i><a href="category.php?slug=<?php echo $row['category_slug']; ?>"><?php echo $row['category_name']; ?></a></li>
                                </ul>
                                <p><?php echo substr($row['post_content'],0,200).' ...'; ?></p>
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
            <?php
			$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
			foreach ($result as $row) {
			    $total_recent_post_sidebar = $row['total_recent_post_sidebar'];
			    $total_popular_post_sidebar = $row['total_popular_post_sidebar'];
			}
			?>
            <div class="col-xl-3 col-lg-4 col-md-5 order-sec">
                <div class="blog-sidebar">
                	<div class="theme-card">
                        <h4>Categories</h4>
                        <ul class="recent-blog">
                        	<?php
				            $statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
				            $statement->execute();
				            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
				            foreach ($result as $row) {
				                ?>
				                <li><i class="fa fa-tag"></i> <a href="category.php?slug=<?php echo $row['category_slug']; ?>"><?php echo $row['category_name']; ?></a></li><br>
				                <?php
				            }
				            ?>
                        </ul>
                    </div>
                    <div class="theme-card">
                        <h4>Recent Posts</h4>
                        <ul class="recent-blog">
                        	<?php
				            $i = 0;
				            $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC");
				            $statement->execute();
				            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
				            foreach ($result as $row) {
				                $i++;
				                if($i > $total_recent_post_sidebar) {
				                    break;
				                }
				                ?>
				                <li>
				                	<a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><div class="media"> 
				                		<img class="img-fluid " src="assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['post_title']; ?>">
                                    	<div class="media-body align-self-center">
                                        <h6>
                                        	<?php $date=date_create($row['post_date']); ?>
                                			<?php echo date_format($date,"D jS M Y"); ?>
                                		</h6>
                                        <p><?php echo $row['post_title']; ?></p>
                                    	</div>
                                	</div>
				                	</a>
				                </li>
				                <?php
				            }
				            ?>
                        </ul>
                    </div>
                    <div class="theme-card">
                        <h4>Popular Posts</h4>
                        <ul class="popular-blog">
                        	<?php
				            $i = 0;
				            $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY total_view DESC");
				            $statement->execute();
				            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
				            foreach ($result as $row) {
				                $i++;
				                if($i > $total_popular_post_sidebar) {
				                    break;
				                }
				                ?>
				                <li>
	                                <a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><div class="media">
	                                    <div class="blog-date"><span><?php $date=date_create($row['post_date']); ?>
                                			<?php echo date_format($date,"D jS M Y"); ?></span></div>
	                                    <div class="media-body align-self-center">
	                                        <h6><?php echo $row['post_title']; ?></h6>
	                                        <p><?php echo $row['total_view']; ?> hits</p>
	                                    </div>
	                                </div>
	                                <p><?php echo substr($row['post_content'],0,200).' ...'; ?></p>
	                            	</a>
                            	</li>
				                <?php
				            }
				            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->
<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
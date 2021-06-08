<?php include_once('header.php'); ?>

<?php
if(!isset($_REQUEST['slug'])) {
    header('location: index.php');
    exit;
}

$statement = $pdo->prepare("SELECT * 
                            FROM tbl_post t1
                            JOIN tbl_category t2
                            ON t1.category_id = t2.category_id
                            WHERE t1.post_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $post_title = $row['post_title'];
    $post_content = $row['post_content'];
    $photo = $row['photo'];
    $post_date = $row['post_date'];
    $category_name = $row['category_name'];
    $category_slug = $row['category_slug'];
    $hits= $row['total_view'];
}
?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>blog detail</h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="blog.php">blog</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#"><?php echo $post_title; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<!--section start-->
<section class="blog-detail-page section-big-py-space ratio2_3">
    <div class="container">
        <div class="row section-big-pb-space">
            <div class="col-sm-12 blog-detail">
               <div class="creative-card">
                   <img src="assets/uploads/<?php echo $photo; ?>" class="img-fluid w-100 " alt="<?php echo $post_title; ?>">
                   <h3><?php echo $post_title; ?></h3>
                   <ul class="post-social">
                       <li>
                        <?php $date=date_create($post_date); ?>
                        <?php echo date_format($date,"D jS M Y"); ?>        
                        </li>
                       <li>Posted By : Admin</li>
                       <li><i class="fa fa-heart"></i><?php echo $hits; ?> Hits</li>
                       <li><i class="fa fa-comments"></i> 10 Comment</li>
                       <li><i class="fa fa-tag"></i> <a href="category.php?slug=<?php echo $category_slug; ?>" class="badge bg-dark"><?php echo $category_name; ?></a>
                       </li>
                   </ul>
                   <p><?php echo $post_content; ?></p>
                   <div class="col-sm-12 text-center mt-3">
                     <h6 class="product-title">share</h6>
                     <ul class="product-social">
                       <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
                       <li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>
                       <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                       <li><a href="javascript:void(0)"><i class="fa fa-instagram"></i></a></li>
                       <li><a href="javascript:void(0)"><i class="fa fa-rss"></i></a></li>
                     </ul>
                   </div>
               </div>
            </div>
        </div>
        <div class="row section-big-pb-space">
            <div class="col-sm-12 ">
                <div class="creative-card">                          
                <h3>Comments</h3>
                <div class="fb-comments" data-href="<?php echo BASE_URL.'blog-single.php?slug='.$_REQUEST['slug']; ?>" data-numposts="5"></div>                                    
                    <ul class="comment-section">
                        <li>
                            <div class="media"><img src="assets/images/avtar/1.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media"><img src="assets/images/avtar/2.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media"><img src="assets/images/avtar/3.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class=" row blog-contact">
            <div class="col-sm-12  ">
                <div class="creative-card">
                    <h2>Leave Your Comment</h2>
                    <form class="theme-form">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Your name" required="">
                            </div>
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Email" required="">
                            </div>
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1">Comment</label>
                                <textarea class="form-control" placeholder="Write Your Comment" id="exampleFormControlTextarea1" rows="6"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-normal" type="submit">Post Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->

<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
<?php include_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
}
?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2><?php echo $about_title; ?></h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="about.php"><?php echo $about_title; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->

<!-- about section start -->
<section class="about-page section-big-py-space">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="banner-section"><img src="assets/uploads/<?php echo $about_banner; ?>" class="img-fluid   w-100" alt=""></div>
            </div>
            <div class="col-lg-6">
                <p class="mb-2"><?php echo $about_content; ?></p>
            </div>
        </div>
    </div>
</section>
<!-- about section end -->
<!-- testimonials start -->
<section class="testimonial testimonial-inverse section-mb-space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="slide-1 no-arrow">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>                            
                    <?php foreach ($result as $row): ?>
                    <div>
                        <div class="testimonial-contain">
                            <div class="media">
                                <div class="testimonial-img">
                                    <img src="assets/uploads/<?php echo $row['photo']; ?>" class="img-fluid rounded-circle  " alt="testimonial">
                                </div>
                                <div class="media-body">
                                    <h5><?php echo $row['name']; ?></h5>
                                    <h6><?php echo $row['designation']; ?> <span>(<?php echo $row['company']; ?>)</span></h6>
                                    <p><?php echo $row['comment']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
    <!--testimonials end-->
<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
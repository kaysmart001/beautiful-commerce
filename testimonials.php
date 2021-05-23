<?php if($ads_above_testimonial_on_off == 1): ?>
<div class="ad-section pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[4] == 'Adsense Code') {
                        echo $adv_adsense_code[4];
                    } else {
                        if($adv_url[4]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[4].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[4].'"><img src="assets/uploads/'.$adv_photo[4].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($home_testimonial_on_off == 1): ?>
<!--title-start-->
<div class="title8 section-big-pt-space">
    <h4><?php echo $testimonial_title; ?></h4>
    <h5><?php echo $testimonial_subtitle; ?></h5>
</div>
<!--title-end-->
<!--testimonial start-->
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
    <!--testimonial end-->
<?php endif; ?>

<?php if($ads_above_latest_product_on_off == 1): ?>
<div class="ad-section pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[2] == 'Adsense Code') {
                        echo $adv_adsense_code[2];
                    } else {
                        if($adv_url[2]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[2].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[2].'"><img src="assets/uploads/'.$adv_photo[2].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($home_latest_product_on_off == 1): ?>
<!--title-start-->
<div class="title8 section-big-pt-space">
    <h4><?php echo $latest_product_title; ?></h4>
</div>
<!--title-end-->

<!--latest products start -->
<section class="section-big-mb-space ratio_square product">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="product-slide-5 product-m no-arrow">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_id DESC LIMIT ".$total_latest_product_home);
                    $statement->execute(array(1));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    ?>                            
                    <?php foreach ($result as $row): ?>
                    <div>
                        <div class="product-box product-box2">
                            <div class="product-imgbox">
                                <div class="product-front">
                                    <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                        <img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-fluid  " alt="product">
                                    </a>
                                </div>
                                <?php
                                  $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                  $statement->execute(array($row['p_id']));
                                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                  if (count($result)>0) {
                                  foreach ($result as $photo) {
                                      ?>
                                  <div class="product-back">
                                    <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                      <img src="assets/uploads/product_photos/<?php echo $photo['photo']; ?>" class="img-fluid  " alt="product">
                                    </a>
                                  </div>
                                      <?php
                                  }
                                }
                                  ?>
                                <div class="product-icon icon-inline">
                                    <?php if($row['p_qty'] == 0): ?>
                                        <div class="out-of-stock">
                                            <div class="inner">
                                                Sold Out
                                            </div>
                                        </div>
                                    <?php else: ?>
                                    <button data-id="<?php echo $row['p_id']; ?>" class="tooltip-top quickie"  data-tippy-content="Quick View">
                                        <i  data-feather="eye"></i>
                                    </button>
                                    <a href="compare.html" class="tooltip-top" data-tippy-content="Compare">
                                        <i  data-feather="refresh-cw"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <div class="new-label1">
                                    <div>new</div>
                                </div>
                            </div>
                            <div class="product-detail detail-inline">
                                <div class="detail-title">
                                    <div class="detail-left">
                                    <?php
                                    $t_rating = 0;
                                    $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                    $statement1->execute(array($row['p_id']));
                                    $tot_rating = $statement1->rowCount();
                                    if($tot_rating == 0) {
                                        $avg_rating = 0;
                                    } else {
                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1) {
                                            $t_rating = $t_rating + $row1['rating'];
                                        }
                                        $avg_rating = $t_rating / $tot_rating;
                                    }
                                    ?>
                                    <div class="rating-star">
                                    <?php
                                    if($avg_rating == 0) {
                                        echo '';
                                    }
                                    elseif($avg_rating == 1.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    } 
                                    elseif($avg_rating == 2.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    }
                                    elseif($avg_rating == 3.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        ';
                                    }
                                    elseif($avg_rating == 4.5) {
                                        echo '
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        ';
                                    }
                                    else {
                                        for($i=1;$i<=5;$i++) {
                                            ?>
                                            <?php if($i>$avg_rating): ?>
                                                <i class="fa fa-star-o"></i>
                                            <?php else: ?>
                                                <i class="fa fa-star"></i>
                                            <?php endif; ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </div>
                                        <a href="product.php?id=<?php echo $row['p_id']; ?>">
                                            <h6 class="price-title">
                                                <?php echo $row['p_name']; ?>
                                            </h6>
                                        </a>
                                    </div>
                                    <div class="detail-right">
                                        <div class="check-price">
                                        <?php if($row['p_old_price'] != 0): ?>
                                          <?php echo $currency.$row['p_old_price']; ?>
                                        <?php endif; ?>
                                      </div>
                                        <div class="price">
                                            <div class="price">
                                                <?php echo $currency.$row['p_current_price']; ?> 
                                            </div>
                                        </div>
                                    </div>
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
<!--latest products end-->
<?php endif; ?>
<!--discount banner start-->
<section class="discount-banner">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="discount-banner-contain">
          <h2>Discount on every single item on our site.</h2>
          <h1><span>OMG! Just Look at the</span> <span>great Deals!</span></h1>
          <div class="rounded-contain rounded-inverse">
            <div class="rounded-subcontain">
              How does it feel, when you see great discount deals for each product?
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--discount banner end-->
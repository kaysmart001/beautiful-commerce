<!--tab product-->
<section  class="tab-product-main  tab-second">
   <div class="tab-prodcut-contain">
      <ul class="tabs tab-title">
        <li class="current"><a href="tab-0">all</a></li>
         <?php
              $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE ecat_id IN(SELECT DISTINCT ecat_id FROM tbl_product) ORDER BY ecat_id");
              $statement->execute();
              $result = $statement->fetchAll(PDO::FETCH_ASSOC);
          ?>
         <?php foreach ($result as $row):  ?>
            <li class="m-2">
              <a href="tab-<?php echo $row['ecat_id']; ?>"><?php echo $row['ecat_name']; ?></a>
            </li>
        <?php endforeach;?>
      </ul>
   </div>
</section>
<!--tab product-->

<!-- product start -->
<section class="section-big-py-space">
   <div class="custom-container">
      <div class="row ">
         <div class="col-12 p-0">
            <div class="theme-tab product">
               <div class="tab-content-cls ">
                <div id="tab-0" class="tab-content product-block3 active default">
                    <div class="col-12 ">
                      <div class="product-slide-3 no-arrow">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_product");
                        $statement->execute();
                        $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                          <?php foreach ($result2 as $row2): ?> 
                           <div>
                              <div class="product-box3">
                                 <div class="media">
                                    <div class="img-wrapper">
                                       <a href="product.php?id=<?php echo $row2['p_id']; ?>">
                                          <img class="img-fluid" src="assets/uploads/<?php echo $row2['p_featured_photo']; ?>" alt="product">
                                       </a>
                                    </div>
                                    <div class="media-body">
                                       <div class="product-detail">
                                        <?php
                                        $t_rating = 0;
                                        $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                        $statement1->execute(array($row2['p_id']));
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
                                          <ul class="rating">
                                            <?php
                                            if($avg_rating == 0) {
                                                echo '';
                                            }
                                            elseif($avg_rating == 1.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            } 
                                            elseif($avg_rating == 2.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            }
                                            elseif($avg_rating == 3.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            }
                                            elseif($avg_rating == 4.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                ';
                                            }
                                            else {
                                                for($i=1;$i<=5;$i++) {
                                                    ?>
                                                    <?php if($i>$avg_rating): ?>
                                                        <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <?php else: ?>
                                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <?php endif; ?>
                                                    <?php
                                                }
                                            }
                                            ?>
                                          </ul>
                                          <a href="product.php?id=<?php echo $row2['p_id']; ?>">
                                             <h3><?php echo $row2['p_name']; ?></h3>
                                          </a>
                                          <h4><?php echo $currency.$row2['p_current_price']; ?><span><?php if($row2['p_old_price'] != 0): ?>
                                          <?php echo $currency.$row2['p_old_price']; ?>
                                          <?php endif; ?></span></h4>
                                          <a class="btn btn-rounded  btn-sm" href="product.php?id=<?php echo $row2['p_id']; ?>" >shop now</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                         <?php endforeach; ?>
                        </div>
                     </div>
                  </div>

                      <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE ecat_id IN(SELECT DISTINCT ecat_id FROM tbl_product) ORDER BY ecat_id");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      ?>
                      <?php foreach ($result as $row): ?>
                        <?php $cat_id=$row['ecat_id']; ?>
                        <div id="tab-<?php echo $cat_id; ?>" class="tab-content product-block3">
                      <div class="col-12 ">
                      <div class="product-slide-3 no-arrow">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id= ?");
                        $statement->execute(array($cat_id));
                        $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                          <?php foreach ($result1 as $row1): ?> 
                           <div>
                              <div class="product-box3">
                                 <div class="media">
                                    <div class="img-wrapper">
                                       <a href="product.php?id=<?php echo $row1['p_id']; ?>">
                                          <img class="img-fluid" src="assets/uploads/<?php echo $row1['p_featured_photo']; ?>" alt="product">
                                       </a>
                                    </div>
                                    <div class="media-body">
                                       <div class="product-detail">
                                        <?php
                                        $t_rating = 0;
                                        $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                        $statement1->execute(array($row1['p_id']));
                                        $tot_rating = $statement1->rowCount();
                                        if($tot_rating == 0) {
                                            $avg_rating = 0;
                                        } else {
                                            $result2 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result2 as $row2) {
                                                $t_rating = $t_rating + $row2['rating'];
                                            }
                                            $avg_rating = $t_rating / $tot_rating;
                                        }
                                        ?>
                                          <ul class="rating">
                                            <?php
                                            if($avg_rating == 0) {
                                                echo '';
                                            }
                                            elseif($avg_rating == 1.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            } 
                                            elseif($avg_rating == 2.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            }
                                            elseif($avg_rating == 3.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                ';
                                            }
                                            elseif($avg_rating == 4.5) {
                                                echo '
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                   <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <li><a href="javascript:void(0)"><i class="fa fa-star-half-o"></i></a></li>
                                                ';
                                            }
                                            else {
                                                for($i=1;$i<=5;$i++) {
                                                    ?>
                                                    <?php if($i>$avg_rating): ?>
                                                        <li><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                                                    <?php else: ?>
                                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                                    <?php endif; ?>
                                                    <?php
                                                }
                                            }
                                            ?>
                                          </ul>
                                          <a href="product.php?id=<?php echo $row1['p_id']; ?>">
                                             <h3><?php echo $row1['p_name']; ?></h3>
                                          </a>
                                          <h4><?php echo $currency.$row1['p_current_price']; ?>
                                          <span>
                                            <?php if($row1['p_old_price'] != 0): ?>
                                          <?php echo $currency.$row1['p_old_price']; ?>
                                          <?php endif; ?>
                                          </span>
                                        </h4>
                                          <a class="btn btn-rounded  btn-sm" href="product.php?id=<?php echo $row1['p_id']; ?>" >shop now</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                          <?php endforeach; ?>
                        </div>
                     </div>
                  </div>
                <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- product end -->
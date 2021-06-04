<!--title start-->
<div class="title8 section-big-pt-space">
   <h4>our category</h4>
</div>
<!--title end-->

<!-- category start -->
<section class="category4 section-big-pb-space">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 pr-0">
            <div class="category-slide5two no-arrow">
               <?php
                     $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                     $statement->execute();
                     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                     ?>
                     <?php foreach ($result as $row): ?> 
                        <div>
                           <div class="category-box">
                              <div class="img-wrraper">
                                 <a href="category-page(left-sidebar).html">
                                    <img src="assets/images/mega-store/category/3.jpg" alt="category" class="img-fluid">
                                 </a>
                              </div>
                              <div class="category-detail">
                                 <a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
                                    <h2><?php echo $row['tcat_name']; ?></h2>
                                 </a>
                           <ul>
                              <?php
                              $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                              $statement1->execute(array($row['tcat_id']));
                              $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                              ?>
                              <?php foreach ($result1 as $row1): ?>
                                 <div class="category-detail">
                                 <a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category">
                                    <h4><?php echo $row1['mcat_name']; ?></h4>
                                 </a>
                                    <ul>
                                       <?php
                                       $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                       $statement2->execute(array($row1['mcat_id']));
                                       $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                       ?>
                                       <?php foreach ($result2 as $row2): ?>
                                          <li>
                                             <a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category"><?php echo $row2['ecat_name']; ?></a>
                                          </li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </div>
                              <?php endforeach; ?>
                           </ul>
                        <a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category" class="btn btn-rounded btn-md btn-block">shop now</a>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- category end -->
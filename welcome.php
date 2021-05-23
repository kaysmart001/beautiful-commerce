<?php if($ads_above_welcome_on_off == 1): ?>
<div class="ad-section pt_20 pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[0] == 'Adsense Code') {
                        echo $adv_adsense_code[0];
                    } else {
                        if($adv_url[0]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[0].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[0].'"><img src="assets/uploads/'.$adv_photo[0].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php if($home_welcome_on_off == 1): ?>
  <!--welcome banner start-->
<section class="sale-banenr banner-style2  section-big-mb-space">
   <img src="assets/uploads/<?php echo $cta_photo; ?>" alt="sale-banenr" class="img-fluid bg-img">
   <div class="custom-container">
      <div class="row">
         <div class="col-12 position-relative">
            <div class="sale-banenr-contain text-center  p-right">
               <div>
                  <h2><?php echo $cta_title; ?></h2>
                  <h5><?php echo nl2br($cta_content); ?></h5>
                  <a href="<?php echo $cta_read_more_url; ?>" class="btn btn-rounded"><?php echo $cta_read_more_text; ?></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--welcome banner end-->
<?php endif; ?>

<?php if($home_service_on_off == 1): ?>
     <!-- services start -->
      <section class="services1 section-pt-space  block">
         <div class="custom-container">
            <div class="row">
               <div class="col-12 pr-0">
                  <div class="services-slide4 no-arrow">
                    <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_service");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>                            
                        <?php foreach ($result as $row): ?>
                         <div>
                            <div class="services-box">
                               <div class="media">
                                  <div class="icon-wrraper">
                                     <img src="assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['title']; ?>" height="50" width="50">
                                  </div>
                                  <div class="media-body">
                                     <h4><?php echo $row['title']; ?></h4>
                                     <p><?php echo nl2br($row['content']); ?></p>
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
      <!-- services end -->
<?php endif; ?>
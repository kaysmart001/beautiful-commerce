<?php if($home_blog_on_off == 1): ?>
<!--blog start-->
    <section class="blog ">
        <div class="custom-container">
            <div class="row">
              <div class="col-12">
                  <div class="title3">
                      <h4>recent blog post</h4>
                  </div>
              </div>
                <div class="col-12 pr-0">
                    <div class="blog-slide-4 no-arrow">
                    	<?php
			            $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC LIMIT 3");
			            $statement->execute();
			            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
			            ?>                            
			             <?php foreach ($result as $row): ?>
                        <div>
                            <div class="blog-contain">
                                <div class="blog-img">
                                    <a href="blog(left-sidebar).html">
                                        <img src="assets/uploads/<?php echo $row['photo']; ?>" alt="blog photo" class="img-fluid ">
                                    </a>
                                </div>
                                <div class="blog-details">
                                    <a href="blog(left-sidebar).html">
                                        <h4><?php echo $row['post_title']; ?></h4>
                                    </a>
                                    <p><?php echo substr($row['post_content'],0,200).' ...'; ?></p>
                                    <span><a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>">read more</a></span>
                                </div>
                                <div class="blog-label">
                                	<?php $date=date_create($row['post_date']); ?>
                                    <p><?php echo date_format($date,"D jS M Y"); ?></p>
                                </div>
                            </div>
                        </div>
                       <?php endforeach; ?>                      
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--blog end-->

    <?php endif; ?>
<?php include_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $faq_title = $row['faq_title'];
    $faq_banner = $row['faq_banner'];
}
?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2><?php echo $faq_title; ?></h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="faq.php"><?php echo $faq_title; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<!-- section start -->
<section class="faq-section section-big-py-space b-g-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="accordion" id="faq-accordion">
        	<?php
            $statement = $pdo->prepare("SELECT * FROM tbl_faq");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            ?>                            
            <?php foreach ($result as $row): ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo $row['faq_id']; ?>">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['faq_id']; ?>"  >
                <?php echo $row['faq_title']; ?>
              </button>
            </h2>
            <div id="collapse<?php echo $row['faq_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $row['faq_id']; ?>" data-bs-parent="#faq-accordion">
              <div class="accordion-body">
                <p><?php echo $row['faq_content']; ?></p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>      
      </div>
    </div>
  </div>
</section>
<!-- section end -->
<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
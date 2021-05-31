<?php
SELECT p.*,c.color_name,b.brand_name ,s.size_name from tbl_product p join tbl_product_color pc on pc.p_id=p.p_id join tbl_color c on pc.color_id=c.color_id join tbl_brand b on p.brand_id= b.brand_id join tbl_product_size pz on pz.p_id= p.p_id join tbl_size s on pz.size_id=s.size_id group by c.color_name,p.p_name;
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_product_category = $row['banner_product_category'];
}
?>

<?php
if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
    header('location: index.php');
    exit;
} else {

    if( ($_REQUEST['type'] != 'top-category') && ($_REQUEST['type'] != 'mid-category') && ($_REQUEST['type'] != 'end-category') ) {
        header('location: index.php');
        exit;
    } else {

        $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $top[] = $row['tcat_id'];
            $top1[] = $row['tcat_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $mid[] = $row['mcat_id'];
            $mid1[] = $row['mcat_name'];
            $mid2[] = $row['tcat_id'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_end_category");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $end[] = $row['ecat_id'];
            $end1[] = $row['ecat_name'];
            $end2[] = $row['mcat_id'];
        }

        if($_REQUEST['type'] == 'top-category') {
            if(!in_array($_REQUEST['id'],$top)) {
                header('location: index.php');
                exit;
            } else {

                // Getting Title
                for ($i=0; $i < count($top); $i++) { 
                    if($top[$i] == $_REQUEST['id']) {
                        $title = $top1[$i];
                        break;
                    }
                }
                $arr1 = array();
                $arr2 = array();
                // Find out all ecat ids under this
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid2[$i] == $_REQUEST['id']) {
                        $arr1[] = $mid[$i];
                    }
                }
                for ($j=0; $j < count($arr1); $j++) {
                    for ($i=0; $i < count($end); $i++) { 
                        if($end2[$i] == $arr1[$j]) {
                            $arr2[] = $end[$i];
                        }
                    }   
                }
                $final_ecat_ids = $arr2;
            }   
        }

        if($_REQUEST['type'] == 'mid-category') {
            if(!in_array($_REQUEST['id'],$mid)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($mid); $i++) { 
                    if($mid[$i] == $_REQUEST['id']) {
                        $title = $mid1[$i];
                        break;
                    }
                }
                $arr2 = array();        
                // Find out all ecat ids under this
                for ($i=0; $i < count($end); $i++) { 
                    if($end2[$i] == $_REQUEST['id']) {
                        $arr2[] = $end[$i];
                    }
                }
                $final_ecat_ids = $arr2;
            }
        }

        if($_REQUEST['type'] == 'end-category') {
            if(!in_array($_REQUEST['id'],$end)) {
                header('location: index.php');
                exit;
            } else {
                // Getting Title
                for ($i=0; $i < count($end); $i++) { 
                    if($end[$i] == $_REQUEST['id']) {
                        $title = $end1[$i];
                        break;
                    }
                }
                $final_ecat_ids = array($_REQUEST['id']);
            }
        }
        
    }   
}
?>

<?php
// Checking if any product is available or not
$prod_count = 0;
$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $prod_table_ecat_ids[] = $row['ecat_id'];
}

for($ii=0;$ii<count($final_ecat_ids);$ii++):
    if(in_array($final_ecat_ids[$ii],$prod_table_ecat_ids)) {
        $prod_count++;
    }
endfor;

if($prod_count==0) {
    echo '<div class="p-3">'.LANG_VALUE_153.'</div>';
} else {
    for($ii=0;$ii<count($final_ecat_ids);$ii++) {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_is_active=?");
        $statement->execute(array($final_ecat_ids[$ii],1));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row): ?>      
<div class="col-xl-3 col-md-4 col-6 col-grid-box">
	<div class="product-box">
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
                        Out Of Stock
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
    </div>
    <div class="product-detail detail-center detail-inverse">
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
                <?php if($row['p_old_price'] != ''): ?>
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
<?php
        }
    }
?>
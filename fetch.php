<?php include("admin/inc/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="author" content="Balextek Inc">
  <!--Google font-->
   <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Days+One&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!--icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/themify.css">


  <!--Slick slider css-->
  <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">

  <!--Animate css-->
  <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
  <!-- Bootstrap css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <!-- Theme css -->
  <link rel="stylesheet" type="text/css" href="assets/css/color11.css" media="screen" id="color">

<?php
if (isset($_POST["action"])) {
$id=intval($_POST['id']);
$type=$_POST['type'];
if ($type=='top-category') {
$query="SELECT p.*,brand_name,ecat_name,mcat_name,tcat_name as title from tbl_product p join tbl_end_category ec on p.ecat_id=ec.ecat_id join tbl_mid_category mc on ec.mcat_id=mc.mcat_id join tbl_top_category tc on mc.tcat_id=tc.tcat_id join tbl_brand b on b.brand_id=p.brand_id where tc.tcat_id='".$id."'";
}

if ($type=='mid-category') {
$query="SELECT p.*,brand_name,ecat_name,mcat_name as title,tcat_name from tbl_product p join tbl_end_category ec on p.ecat_id=ec.ecat_id join tbl_mid_category mc on ec.mcat_id=mc.mcat_id join tbl_top_category tc on mc.tcat_id=tc.tcat_id join tbl_brand b on b.brand_id=p.brand_id where mc.mcat_id='".$id."'";
}

if ($type=='end-category') {
$query="SELECT p.*,brand_name,ecat_name as title,mcat_name,tcat_name from tbl_product p join tbl_end_category ec on p.ecat_id=ec.ecat_id join tbl_mid_category mc on ec.mcat_id=mc.mcat_id join tbl_top_category tc on mc.tcat_id=tc.tcat_id join tbl_brand b on b.brand_id=p.brand_id where ec.ecat_id='".$id."'";
}

// if ($type=='mid-category') {
//     $query.="where mc.mcat_id=?";
// }
// if ($type=='end-category') {
//     $query.="where ec.ecat_id=?";
// }
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);  
$total_row = $statement->rowCount();
$output    = '';                          

if ($total_row > 0) {
foreach ($result as $row) {
  $title='<div class="breadcrumb-main ">
                  <div class="container">
                    <div class="row">
                      <div class="col">
                        <div class="breadcrumb-contain">
                          <div>
                            <ul>
                              <li><a href="index.php">home</a></li>
                              <li><i class="fa fa-angle-double-right"></i></li>
                              <li><a href="javascript:void(0)">'.$row['title'].'</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
  $output .= '
                <div class="col-xl-3 col-md-4 col-6 col-grid-box">
                <div class="product-box">
                    <div class="product-imgbox">
                        <div class="product-front">
                            <a href="product.php?id=' .$row['p_id']. '">
                                <img src="assets/uploads/' .$row['p_featured_photo']. '" class="img-fluid  " alt="product">
                            </a>
                        </div>';

  $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
  $statement->execute(array($row['p_id']));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  if (count($result)>0) {
  foreach ($result as $photo) {
    $output .='<div class="product-back">
                <a href="product.php?id='.$row['p_id'].'">
                  <img src="assets/uploads/product_photos/'. $photo['photo'].'" class="img-fluid  " alt="product">
                </a>
              </div>';
                        }
                      }
    $output.='<div class="product-icon icon-inline">';
    if($row['p_qty'] == 0){
      $output.='<div class="out-of-stock">
                                    <div class="inner">
                                        Out Of Stock
                                    </div>
                                </div>';
    }else{
      $output.='<button data-id="'. $row['p_id'].'" class="tooltip-top quickie"  data-tippy-content="Quick View">
                                <i  data-feather="eye"></i>
                            </button>
                            <a href="compare.html" class="tooltip-top" data-tippy-content="Compare">
                                <i  data-feather="refresh-cw"></i>
                            </a>';
    }
    $output.='</div>
                    </div>
                    <div class="product-detail detail-center detail-inverse">
                        <div class="detail-title">
                            <div class="detail-left">';
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
    $output.='<div class="rating-star">';
    if($avg_rating == 0) {
            $output.='';
        }
        elseif($avg_rating == 1.5) {
            $output.='
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            ';
        } 
        elseif($avg_rating == 2.5) {
            $output.='
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
                <i class="fa fa-star-o"></i>
            ';
        }
        elseif($avg_rating == 3.5) {
            $output.='
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
            ';
        }
        elseif($avg_rating == 4.5) {
            $output.= '
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
            ';
        }
        else {
            for($i=1;$i<=5;$i++) {
              if($i>$avg_rating){
                $output.='<i class="fa fa-star-o"></i>';
              }else{
                $output.='<i class="fa fa-star"></i>';
              }
            }
          }
        $output.='</div>
                    <a href="product.php?id='.$row['p_id'].'">
                        <h6 class="price-title">
                            '. $row['p_name'].'
                        </h6>
                    </a>
                </div>
                <div class="detail-right">
                    <div class="check-price">';
                    if($row['p_old_price'] != 0){
                      $output.=$currency.$row['p_old_price'];
                    }
        $output.='</div>
                      <div class="price">
                          <div class="price">'.$currency.$row['p_current_price'].' 
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>';
  }
}
else 
{
$output = '<h3 class="text-center">No Product Found</h3>';
}
    echo $title;
    echo $output;

}

?>

<!-- tool tip js -->
<script src="assets/js/tippy-popper.min.js"></script>
<script src="assets/js/tippy-bundle.iife.min.js"></script>

<!-- popper js-->
<script src="assets/js/popper.min.js" ></script>
<script src="assets/js/bootstrap-notify.min.js"></script>

<!-- menu js-->
<script src="assets/js/menu.js"></script>


<!-- Bootstrap js-->
<script src="assets/js/bootstrap.js"></script>



<!-- father icon -->
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/feather-icon.js"></script>
<!-- Theme js-->
<script src="assets/js/script.js"></script>
<!-- <script src="assets/js/timer2.js"></script> -->
<script src="assets/js/modal.js"></script>

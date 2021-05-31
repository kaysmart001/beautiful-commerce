<?php
include("admin/inc/config.php");
if (isset($_POST["action"])) {
$id=$_POST['id'];
$type=$_POST['type'];
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
        $output ='<h3> Category not found</h3>';
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
        $output ='<h3> Category not found</h3>';
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
        $output ='<h3> Category not found</h3>';
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
  $output='<div class="p-3">'.LANG_VALUE_153.'</div>';
} else {
  for($ii=0;$ii<count($final_ecat_ids);$ii++) {
      $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=? AND p_is_active=?");
      $statement->execute(array($final_ecat_ids[$ii],1));
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $total_row = $statement->rowCount();
      $output    = '';
      if ($total_row > 0) {
        foreach ($result as $row) {
          $output .= '<div class="col-xl-3 col-md-4 col-6 col-grid-box">
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
                            if($row['p_old_price'] != ''){
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
        else {
        $output = '<h3>No Data Found</h3>';
    }
      }
    }

    
    echo $output;
}

?>
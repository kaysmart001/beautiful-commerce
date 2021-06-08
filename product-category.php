<?php include_once('header.php');
$id=$_REQUEST['id'];
$type=$_REQUEST['type'];

if( !isset($id) || !isset($type) ) {
    header('location: index.php');
    exit;
}

if( ($type != 'top-category') && ($type != 'mid-category') && ($type != 'end-category') ) {
    header('location: index.php');
    exit;
} 

$query="
SELECT count(p.p_id) from tbl_product p join tbl_end_category ec on p.ecat_id=ec.ecat_id join tbl_mid_category mc on ec.mcat_id=mc.mcat_id join tbl_top_category tc on mc.tcat_id=tc.tcat_id join tbl_brand b on b.brand_id=p.brand_id
";

if ($type=='top-category') {
$query.="
WHERE tc.tcat_id='". $id ."'
";
}

if ($type=='mid-category') {
$query.="
WHERE mc.mcat_id='". $id ."'
";
}

if ($type=='end-category') {
$query.="
WHERE ec.ecat_id='". $id ."'
";
}

$statement = $pdo->prepare($query);
$statement->execute();  
$total_row = $statement->rowCount();
?>

<!-- section start -->
<section class="section-big-py-space ratio_asos b-g-light">
  <div class="collection-wrapper">
    <div class="custom-container">
      <div class="row">
        <?php include_once('product-category-sidebar.php'); ?>
        <div class="collection-content col">
          <div class="page-main-content">
            <div class="row">
              <div class="col-sm-12">
                <div class="collection-product-wrapper">
                  <div class="product-top-filter">
                    <div class="row">
                      <div class="col-xl-12">
                        <div class="filter-main-btn"><span class="filter-btn btn btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="product-filter-content">
                          <div class="search-count">
                            <h5>Showing Products 1-24 of 10 Result</h5></div>
                          <div class="collection-view">
                            <ul>
                              <li><i class="fa fa-th grid-layout-view"></i></li>
                              <li><i class="fa fa-list-ul list-layout-view"></i></li>
                            </ul>
                          </div>
                          <div class="collection-grid-view">
                            <ul>
                              <li><img src="assets/images/category/icon/2.png" alt="" class="product-2-layout-view"></li>
                              <li><img src="assets/images/category/icon/3.png" alt="" class="product-3-layout-view"></li>
                              <li><img src="assets/images/category/icon/4.png" alt="" class="product-4-layout-view"></li>
                              <li><img src="assets/images/category/icon/6.png" alt="" class="product-6-layout-view"></li>
                            </ul>
                          </div>
                          <div class="product-page-per-view">
                            <select id="per_page">
                              <option value="10">10 Products Per Page</option>
                              <option value="25">25 Products Per Page</option>
                              <option value="50">50 Products Per Page</option>
                              <option value="100">100 Products Per Page</option>
                            </select>
                          </div>
                          <div class="product-page-filter">
                            <select id="sort_by">
                              <option value="p.p_id asc">Sort by</option>
                              <option value="p.p_total_view desc">Popularity</option>
                              <option value="p.p_id desc">Newest</option>
                              <option value="p.p_current_price asc">Price (low to high)</option>
                              <option value="p.p_current_price desc">Price (high to low)</option>
                              <option value="p.p_name asc">Name A-Z</option>
                              <option value="p.p_name desc">Name Z-A</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="product-wrapper-grid product-load-more product">
                    <div class="row filter_data">
                    	
                    </div>
                  </div>
                  <div class="load-more-sec"><a class="loadMore">load more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- section End -->
<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
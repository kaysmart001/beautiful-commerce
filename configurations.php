<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
    $cta_title = $row['cta_title'];
    $cta_content = $row['cta_content'];
    $cta_read_more_text = $row['cta_read_more_text'];
    $cta_read_more_url = $row['cta_read_more_url'];
    $cta_photo = $row['cta_photo'];
    $featured_product_title = $row['featured_product_title'];
    $featured_product_subtitle = $row['featured_product_subtitle'];
    $latest_product_title = $row['latest_product_title'];
    $latest_product_subtitle = $row['latest_product_subtitle'];
    $popular_product_title = $row['popular_product_title'];
    $popular_product_subtitle = $row['popular_product_subtitle'];
    $testimonial_title = $row['testimonial_title'];
    $testimonial_subtitle = $row['testimonial_subtitle'];
    $testimonial_photo = $row['testimonial_photo'];
    $blog_title = $row['blog_title'];
    $blog_subtitle = $row['blog_subtitle'];
    $total_featured_product_home = $row['total_featured_product_home'];
    $total_latest_product_home = $row['total_latest_product_home'];
    $total_popular_product_home = $row['total_popular_product_home'];
    $home_service_on_off = $row['home_service_on_off'];
    $home_welcome_on_off = $row['home_welcome_on_off'];
    $home_featured_product_on_off = $row['home_featured_product_on_off'];
    $home_latest_product_on_off = $row['home_latest_product_on_off'];
    $home_popular_product_on_off = $row['home_popular_product_on_off'];
    $home_testimonial_on_off = $row['home_testimonial_on_off'];
    $home_blog_on_off = $row['home_blog_on_off'];

    $ads_above_welcome_on_off           = $row['ads_above_welcome_on_off'];
    $ads_above_featured_product_on_off  = $row['ads_above_featured_product_on_off'];
    $ads_above_latest_product_on_off    = $row['ads_above_latest_product_on_off'];
    $ads_above_popular_product_on_off   = $row['ads_above_popular_product_on_off'];
    $ads_above_testimonial_on_off       = $row['ads_above_testimonial_on_off'];
    $ads_category_sidebar_on_off        = $row['ads_category_sidebar_on_off'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_advertisement");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $adv_type[] = $row['adv_type'];
    $adv_photo[] = $row['adv_photo'];
    $adv_url[] = $row['adv_url'];
    $adv_adsense_code[] = $row['adv_adsense_code'];
}
?>
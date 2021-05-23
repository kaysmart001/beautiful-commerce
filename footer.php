<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
   $footer_about = $row['footer_about'];
   $contact_email = $row['contact_email'];
   $contact_phone = $row['contact_phone'];
   $contact_address = $row['contact_address'];
   $contact_name = $row['contact_name'];
   $contact_fax = $row['contact_fax'];
   $footer_copyright = $row['footer_copyright'];
   $total_recent_post_footer = $row['total_recent_post_footer'];
   $total_popular_post_footer = $row['total_popular_post_footer'];
   $newsletter_on_off = $row['newsletter_on_off'];
   $before_body = $row['before_body'];
}
?>
<!-- footer start -->
<footer>
   <div class="footer1">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="footer-main">
                  <div class="footer-box">
                     <div class="footer-title mobile-title">
                        <h5><?php echo LANG_VALUE_110; ?></h5>
                     </div>
                     <div class="footer-contant">
                        <div class="footer-logo">
                           <a href="index.php">
                              <img src="assets/uploads/<?php echo $logo; ?>" class="img-fluid" alt="logo">
                           </a>
                        </div>
                        <p><?php echo nl2br($footer_about); ?></p>
                        <ul class="paymant">
                           <li><a href="javascript:void(0)"><img src="assets/images/layout-1/pay/1.png" class="img-fluid" alt="pay"></a></li>
                           <li><a href="javascript:void(0)"><img src="assets/images/layout-1/pay/2.png" class="img-fluid" alt="pay"></a></li>
                           <li><a href="javascript:void(0)"><img src="assets/images/layout-1/pay/3.png" class="img-fluid" alt="pay"></a></li>
                           <li><a href="javascript:void(0)"><img src="assets/images/layout-1/pay/4.png" class="img-fluid" alt="pay"></a></li>
                           <li><a href="javascript:void(0)"><img src="assets/images/layout-1/pay/5.png" class="img-fluid" alt="pay"></a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="footer-box">
                     <div class="footer-title">
                        <h5>my account</h5>
                     </div>
                     <div class="footer-contant">
                        <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                            foreach ($result as $row) {
                              $about_title = $row['about_title'];
                              $faq_title = $row['faq_title'];
                              $blog_title = $row['blog_title'];
                              $contact_title = $row['contact_title'];
                            }
                        ?>
                        <ul>
                           <li><a href="about.php" class="dark-menu-item"><?php echo $about_title; ?></a></li>
                            <li><a href="faq.php" class="dark-menu-item"><?php echo $faq_title; ?></a></li>
                            <li><a href="blog.php" class="dark-menu-item"><?php echo $blog_title; ?></a></li>
                            <li><a href="contact.php" class="dark-menu-item"><?php echo $contact_title; ?></a></li>
                            <li><a href="testimonials.php" class="dark-menu-item">testimonial</a></li>
                            <li><a href="terms-and-conditions.php">terms &amp; conditions</a></li>
                            <li><a href="return-policy.php">returns &amp; exchanges</a></li>
                            <li><a href="shipping-and-delivery.php">shipping &amp; delivery</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="footer-box">
                     <div class="footer-title">
                        <h5><?php echo LANG_VALUE_114; ?></h5>
                     </div>
                     <div class="footer-contant">
                        <ul class="contact-list">
                           <li><i class="fa fa-map-marker"></i><?php echo $contact_name; ?> <br> <span><?php echo nl2br($contact_address); ?></span></li>
                           <li><i class="fa fa-phone"></i>call us: <span><?php echo $contact_phone; ?></span></li>
                           <li><i class="fa fa-envelope-o"></i>email us: <?php echo $contact_email; ?></li>
                           <li><i class="fa fa-fax"></i>fax <span><?php echo $contact_fax; ?></span></li>
                        </ul>
                     </div>
                  </div>
                  <?php if($newsletter_on_off == 1): ?>
                  <?php
                  if(isset($_POST['form_subscribe']))
                  {
                     if(empty($_POST['name_subscribe'])) {
                          $valid = 0;
                          $error_message1 .= LANG_VALUE_123."<br>";
                      }
                     if(empty($_POST['email_subscribe'])) 
                      {
                          $valid = 0;
                          $error_message1 .= LANG_VALUE_131."<br>";
                      }
                      else
                      {
                        if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
                         {
                             $valid = 0;
                             $error_message1 .= LANG_VALUE_134."<br>";
                         }
                         else
                         {
                           $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
                           $statement->execute(array($_POST['email_subscribe']));
                           $total = $statement->rowCount();                   
                           if($total)
                           {
                              $valid = 0;
                              $error_message1 .= LANG_VALUE_147."<br>";
                           }
                           else
                           {
                              // Sending email to the requested subscriber for email confirmation
                              // Getting activation key to send via email. also it will be saved to database until user click on the activation link.
                              $key = md5(uniqid(rand(), true));

                              // Getting current date
                              $current_date = date('Y-m-d');

                              // Getting current date and time
                              $current_date_time = date('Y-m-d H:i:s');

                              // Inserting data into the database
                              $statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_name,subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?,?)");
                              $statement->execute(array($_POST['name_subscribe'],$_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

                              // Sending Confirmation Email
                              $to = $_POST['email_subscribe'];
                              $subject = 'Subscriber Email Confirmation';
                              
                              // Getting the url of the verification link
                              $verification_url = BASE_URL.'verify-subscriber.php?email='.$to.'&key='.$key;

                              $message = 'Dear '.$_POST['name_subscribe'].',
         Thanks for your interest to subscribe to our newsletter!<br><br>
         Please click this link to confirm your subscription:
                        '.$verification_url.'<br><br>
         This link will be active only for 24 hours.
                        ';

                              
                              
                              try {
                   
                                  $mail->setFrom($contact_email, 'Admin');
                                  $mail->addAddress($to);
                                  $mail->addReplyTo($contact_email, 'Admin');
                                  
                                  $mail->isHTML(true);
                                  $mail->Subject = $subject;
                           
                                  $mail->Body = $message;
                                  $mail->send();
                           
                                  $success_message1 = LANG_VALUE_136;   
                              } catch (Exception $e) {
                                  echo 'Message could not be sent.';
                                  echo 'Mailer Error: ' . $mail->ErrorInfo;
                              }
                              
                              

                              
                           }
                         }
                      }
                  }
                  ?>
                  <div class="footer-box">
                     <div class="footer-title">
                        <h5><?php echo LANG_VALUE_93; ?></h5>
                     </div>
                     <div class="footer-contant">
                        <div class="newsletter-second">
                           <form action="" method="post">
                           <?php $csrf->echoInputField(); ?>
                           <?php

                          if($error_message1 != '') {

                              echo "<div style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:red;'>".$error_message1."</div>";
                          }
                          if($success_message1 != '') {
                              echo "<div style='padding: 10px;background:#f1f1f1;margin-bottom:20px;color:green;'>".$success_message1."</div>";
                          }
                          ?>
                           <div class="form-group">
                              <div class="input-group">
                                 <input type="text" class="form-control" placeholder="enter full name" name="name_subscribe">
                                 <span class="input-group-text"><i class="ti-user"></i></span>
                              </div>
                           </div>
                           <div class="form-group ">
                              <div class="input-group">
                                 <input type="email" class="form-control" placeholder="enter email address" name="email_subscribe" >
                                 <span class="input-group-text"><i class="ti-email"></i></span>
                              </div>
                           </div>
                           <div class="form-group mb-0">
                              <button type="submit" class="btn btn-solid btn-sm" name="form_subscribe">submit now</button>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="subfooter dark-footer ">
      <div class="container">
         <div class="row">
            <div class="col-xl-6 col-md-8 col-sm-12">
               <div class="footer-left">
                  <p><?php echo $footer_copyright; ?></p>
               </div>
            </div>
            <div class="col-xl-6 col-md-4 col-sm-12">
               <div class="footer-right">
                  <ul class="sosiyal">
                  <?php
                  $statement = $pdo->prepare("SELECT * FROM tbl_social");
                  $statement->execute();
                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                  ?>
                  <?php foreach ($result as $row): ?>
                    <?php if($row['social_url'] != ''): ?>
                    <li><a href="<?php echo $row['social_url']; ?>"><i class="<?php echo $row['social_icon']; ?>"></i></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                     <li><a href="javascript:void(0)"><i class="fa fa-rss"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>
<!-- footer end -->
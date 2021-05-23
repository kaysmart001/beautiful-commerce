<?php include_once('header.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_title = $row['contact_title'];
    $contact_banner = $row['contact_banner'];
}
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $contact_map_iframe = $row['contact_map_iframe'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
    $contact_name = $row['contact_name'];
}
?>
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2><?php echo $contact_title; ?></h2>
                        <ul>
                            <li><a href="index.php">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="contact.php"><?php echo $contact_title; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<?php
// After form submit checking everything for email sending
if(isset($_POST['form_contact']))
{
    $error_message = '';
    $success_message = '';
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) 
    {
        $receive_email = $row['receive_email'];
        $receive_email_subject = $row['receive_email_subject'];
        $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
    }

    $valid = 1;

    if(empty($_POST['visitor_lname']) || empty($_POST['visitor_fname']))
    {
        $valid = 0;
        $error_message .= 'Please enter your firstname and lastname.\n';
    }

    if(empty($_POST['visitor_phone']))
    {
        $valid = 0;
        $error_message .= 'Please enter your phone number.\n';
    }


    if(empty($_POST['visitor_email']))
    {
        $valid = 0;
        $error_message .= 'Please enter your email address.\n';
    }
    else
    {
        // Email validation check
        if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
        {
            $valid = 0;
            $error_message .= 'Please enter a valid email address.\n';
        }
    }

    if(empty($_POST['visitor_message']))
    {
        $valid = 0;
        $error_message .= 'Please enter your message.\n';
    }

    if($valid == 1)
    {
        
        $visitor_name = strip_tags($_POST['visitor_lname']).' '.strip_tags($_POST['visitor_fname']);
        $visitor_email = strip_tags($_POST['visitor_email']);
        $visitor_phone = strip_tags($_POST['visitor_phone']);
        $visitor_message = strip_tags($_POST['visitor_message']);

        // sending email
        $to_admin = $receive_email;
        $subject = $receive_email_subject;
        $message = '
<html><body>
<table>
<tr>
<td>Name</td>
<td>'.$visitor_name.'</td>
</tr>
<tr>
<td>Email</td>
<td>'.$visitor_email.'</td>
</tr>
<tr>
<td>Phone</td>
<td>'.$visitor_phone.'</td>
</tr>
<tr>
<td>Comment</td>
<td>'.nl2br($visitor_message).'</td>
</tr>
</table>
</body></html>
';
       
        
        try {
		    
	    $mail->setFrom($visitor_email, $visitor_name);
	    $mail->addAddress($to_admin);
	    $mail->addReplyTo($visitor_email, $visitor_name);
	    
	    $mail->isHTML(true);
	    $mail->Subject = $subject;

	    $mail->Body = $message;
	    $mail->send();

	    $success_message = $receive_email_thank_you_message;
	} catch (Exception $e) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
        
        

    }
}
?>
                
<?php
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>
<!--section start-->
<section class="contact-page section-big-py-space b-g-light">
    <div class="custom-container">
        <div class="row section-big-pb-space">
            <div class="col-xl-6 offset-xl-3">
                <h3 class="text-center mb-3">Get in touch</h3>
                <form class="theme-form" method="post" action="">
                	<?php $csrf->echoInputField(); ?>
                    <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                               <label for="name">First Name</label>
                               <input type="text" class="form-control" id="name" placeholder="Enter Your name" required name="visitor_fname">
                           </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="email">Last Name</label>
                              <input type="text" class="form-control" id="last-name" placeholder="Last Name" required name="visitor_lname">
                          </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                               <label for="review">Phone number</label>
                               <input type="text" class="form-control" id="review" placeholder="Enter your number" required name="visitor_phone">
                           </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Email</label>
                                <input type="email" class="form-control" placeholder="Email" required name="visitor_email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label >Write Your Message</label>
                                <textarea class="form-control" placeholder="Write Your Message"  rows="2" name="visitor_message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-normal" type="submit" name="form_contact">Send Your Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 map">
                <div class="theme-card">
                <?php echo $contact_map_iframe; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->
<?php include_once('footer.php'); ?>
<?php include_once('modals.php'); ?>
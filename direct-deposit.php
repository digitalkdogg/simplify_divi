<form id = "direct-deposit" class = "form" method="post" enctype="multipart/form-data" >
    <h4>Direct Deposit Authorization Form</h4>
    <p>This document must be signed by employees and/or vendors requesting automatic deposit of
paychecks/checks and retained on file by the employer. Please attach a voided check for the account to
help verify their account numbers and bank routing numbers.</p>
    <br />

    <div class = "row form-group">
        <label for="employee_name">Employee Name</label>
        <input type = "text"
        required data-pristine-required-message="Please enter a name"
        id = "employee_name" name = "employee_name" />
    </div>

    <div class = "row form-group checkbox">
        <label>Account Type</label>
        <label for="checking" style = "background:transparent; color:black; width:auto; ">Checking : </label>
        <input type = "checkbox" id = "checking" name = "checking" />
        <div class = "mobile-block"></div>
        <label for="savings" style = "background:transparent; color:black; width:auto;">Savings : </label>
            <input type = "checkbox"
        id = "savings" name = "savings" />

        <br />

    </div>

    <div class = "row form-group">
        <label for="routing_number" class = "width-auto-desktop">Bank Routing Number</label>
        <input type = "password"
        required data-pristine-required-message="Please enter a routing number"
        id = "routing_number" name = "routing_number" />
    </div>
    <div class = "row form-group">
        <label for="account_number" class = "width-auto-desktop">Bank Account Number</label>
        <input type = "password"
        required data-pristine-required-message="Please enter a routing number"
        id = "account_name" name = "account_number" />
    </div>
    <div class = "row form-group">
        <label for="file">File </label><input type="file" id="checkimg" name="checkimg" class = "file" />
        <span class = "file-info"></span>
        <div class = "pristine-error" style = "display:none;"></div>
    </div>
    <div class = "row form-group checkbox">
    <h4>Terms and Service</h4>
    <p>This authorizes Simplify Professional Services, to send credit entries (and appropriate debit and adjustment entries),
electronically or by any other commercially accepted method, to my (our) account(s) indicated below
and to other accounts I (we) identify in the future (the “Account”). This authorizes the financial
institution holding the Account to post all such entries. I agree that the ACH transactions authorized
herein shall comply with all applicable U.S. Law. This authorization will be in effect until the Company
receives a written termination notice from myself and has a reasonable opportunity to act on it.</p>
    <label for="terms" style = "background:transparent; color:black; width:auto; ">Check to agree : </label>
    <input type = "checkbox" id = "terms" name = "terms" required data-pristine-required-message="Please Agree to the terms and service statement" />
    </div>


    <input type = "hidden" name="isvalid" id = "isvalid" />
    <button id = "direct-deposit-submit">Submit</button>

    <div id = "status">
    <?php

    if ($_POST['isvalid']=='iamvalid') {


        if ($_POST) {
            if(isset($_FILES['file'])){


                $errors= array();
                $file_name = $_FILES['file']['name'];
                $file_size =$_FILES['file']['size'];
                $file_tmp =$_FILES['file']['tmp_name'];
                $file_type=$_FILES['file']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

                $extensions= array("jpeg","jpg","png","gif" );

                if(in_array($file_ext,$extensions)=== false){
                    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }

                if($file_size > 200097152){
                    $errors[]='File size must be less than 200 MB';
                }
                if(empty($errors)==true){
                    $to = 'becky@simplifyprofessionalservices.com';
                    //$to = 'kevinbollman@gmail.com';
                    $subject = 'Direct Deposit Submission';
                    $message = 'Here is the direct deposit info : <br /> <br />
                    Employee Name : ' . $_POST['employee_name'] .
                    '<br />Checking : ' . $_POST['checking'] .
                    '<br />Savings : ' . $_POST['savings'] .
                    '<br />Routing No :'. $_POST['routing_number']  .
                    '<br />Account No : ' . $_POST['account_number'] .
                    '<br />Check Image : ';

                    $headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
                    if (wp_mail( $to, $subject, $message, $headers )) {
                    ?>
                        You form was uploaded successfully
                    <?php
                    }
                }
            }
        }



    }

    ?>
    </div>


</form>

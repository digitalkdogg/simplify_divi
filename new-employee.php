<form id = "new-employee" class = "form" method="post" >
    <div class = "row form-group">
        <label for="employee_name">Employee Name</label>
        <input type = "text" 
        required data-pristine-required-message="Please enter a name" 
        id = "employee_name" name = "employee_name" />
    </div>

    <div class = "row form-group">
        <label for="email_name">Email Address</label>
        <input type = "email" 
        required data-pristine-required-message="Please enter a email address" 
        id = "email_name" name = "email_name" />
    </div>
    
    <div class = "row form-group">
        <label for="start_date">Start Date</label>
        <input type = "text" 
        class="date"
        required data-pristine-required-message="Please enter a start date" 
        id = "start_date" name = "start_date" />
    </div>


    <div class = "row form-group">
        <label for="pay">Rate Pay or Salary </label>
        <input type = "text" 
        required data-pristine-required-message="Please enter a rate pay or salary" 
        id = "pay" name = "pay" />
    </div>

    <div class = "row form-group">
        <label for="benefits">Benefits </label>
        <input type = "text" 
        required data-pristine-required-message="Please enter something for the benefits" 
        id = "benefits" name = "beneftis" />
    </div>
    
    <br />
    <input type = "hidden" name="isvalid" id = "isvalid" />
    <button id = "goback" onclick="history.back(-1);">Go Back</button>
    <button id = "new-employee-submit">Submit</button>
    <button id = "new-employee-print">Print As PDF</button>
    <div id = "status">
    <?php
    
    if ($_POST['isvalid']=='iamvalid') {
    

        $to = 'becky@simplifyprofessionalservices.com';
        //$to = 'kevinbollman@gmail.com';
        $subject = 'New Employee Submission';
        $message = 'Here is the new employee info : <br /> <br />
        Employee Name : ' . $_POST['employee_name'] . 
        '<br />Email Address : ' . $_POST['email_name'] . 
        '<br />Start Date : ' . $_POST['start_date'] . 
        '<br />Salary :'. $_POST['pay']  . 
        '<br />benefits : ' . $_POST['beneftis'];
        //	$message = 'Dearest Becky!<br /><br /> There is a new submission<br /><br /> From : ' . $_POST['person_name'] . '<br />Email : ' . $_POST['email'] . '<br />Link :' . WP_CONTENT_URL . '/../uploads/' . substr($_POST['data-id'], -7) . '--' . $file_name;
                    
        $headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');
        if (wp_mail( $to, $subject, $message, $headers )) {
            ?> 
                You form was uploaded successfully
            <?php
        }

    }

    ?>
    </div>
</form>
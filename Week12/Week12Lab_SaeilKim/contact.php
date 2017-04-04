<?php require_once('./dao/mailDAO.php'); ?>
<?php require_once('./PasswordHash.php'); ?>
<?php include 'header.php'; ?>
<?php
            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }            


        try{
            $mailDAO = new mailDAO();
            //Tracks errors with the form fields
            $hasError = false;
            //Array for our error messages
            $errorMessages = Array();
            $customerNameError = $customerName = "";
            $phoneNumberError=$phoneNumber= "";
            $emailAddress=$emailError="";
            $referrer=$referrerError="";


            if(isset($_POST['customerName']) || isset($_POST['phoneNumber']) || isset($_POST['emailAddress']) || isset($_POST['referrer'])){

                if(!isset($_POST['customerName']) || (empty(trim($_POST['customerName'])))){
                    $customerNameError = "Please enter a Customer name.";
                    $hasError = true;
                } else {
                    $customerName = test_input($_POST["customerName"]);
                }

                if(!isset($_POST['phoneNumber']) || (empty($_POST['phoneNumber']))){
                    $phoneNumberError = "Please enter a phone Number.";
                    $hasError = true;
                } else {
                    if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", trim($_POST['phoneNumber']))) {
                    $phoneNumberError = "Invalid phoneNumber format";
                    $hasError = true;
                    } else {
                     $phoneNumber = test_input($_POST["phoneNumber"]);
                    }

                }
                   
                if(!isset($_POST['emailAddress']) || (empty($_POST['emailAddress']))){
                    $emailError = "Please enter a Email Address.";
                    $hasError = true;
                } else {
                    $email = test_input($_POST["emailAddress"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailError = "Invalid email format";
                        $hasError = true;
                    } else {
                      $emailAddress = test_input($_POST["emailAddress"]);
                    }
                }           
                
                if(!isset($_POST['referrer']) || ($_POST['referrer'] == "")){
                    $referrerError = "Please select one option.";
                    $hasError = true;
                } else {
                       $referrer = test_input($_POST["referrer"]);
                }
 
               if(!$hasError){
                   
                   $mail = new Mail($_POST['customerName'],$_POST['phoneNumber'],$_POST['emailAddress'], $_POST['referrer']);
                   $addSuccess = $mailDAO->addMail($mail);
                   
//                   echo '<h3>' . $addSuccess . '</h3>';

                    $uploaddir = 'files\\';

                    if(!is_dir($uploaddir)) {
                        mkdir($uploaddir);
                    }


                    $uploadfile = $uploaddir . basename($_FILES['fileToUpload']['name']);

                    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
                        $fileMsg= "File is valid, and was successfully uploaded.\n";
                    } else {
                        $fileMsg= "Possible file upload attack!\n";
                    }
                   echo '<h3>' . $addSuccess . ' ' . $fileMsg .'</h3>';

                   
                   $customerNameError = $customerName = "";
                   $phoneNumberError=$phoneNumber= "";
                   $emailAddress=$emailError="";
                   $referrer=$referrerError="";
                   unset($_POST['customerName']);
                   unset($_POST['phoneNumber']);
                   unset($_POST['emailAddress']);
                   unset($_POST['referrer']);
                   unset($hasError);
                   
                   
                   
                   
                   
                }

            } 
            
        ?>
            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                        <form name="addMailing" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40' value="<?php echo($customerName); ?>">
                                 <?php 
                                //If there was an error with the firstName field, display the message
                                        echo ' <span style=\'color:red;font-size:10px\' > ' . $customerNameError . '</span>';
                                ?>
                                </td>
                           </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40' value="<?php echo($phoneNumber); ?>" maxlength=12> ie: 000-000-0000
                             <?php 
                                //If there was an error with the firstName field, display the message
                                        echo ' <span style=\'color:red;font-size:10px\' > ' . $phoneNumberError . '</span>';
                            ?>
                                
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40' value="<?php echo($emailAddress); ?>">
                                <?php 
                                //If there was an error with the firstName field, display the message
                                        echo ' <span style=\'color:red;font-size:10px\' > ' . $emailError . '</span>';
                                ?>
                                </td>                              
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referrer" id="referralNewspaper" value="newspaper" <?php if (trim($referrer)=='newspaper') echo 'checked';?> >
                                    Radio<input type="radio" name='referrer' id='referralRadio' value='radio' <?php if (trim($referrer)=='radio') echo 'checked';?> >
                                    TV<input type='radio' name='referrer' id='referralTV' value='TV' <?php if (trim($referrer)=='TV') echo 'checked';?> >
                                    Other<input type='radio' name='referrer' id='referralOther' value='other' <?php if (trim($referrer)=='other') echo 'checked';?> >
                                <?php 
                                //If there was an error with the firstName field, display the message
                                        echo ' <span style=\'color:red;font-size:10px\' > ' . $referrerError. '</span>';
                                ?>
                                </td>                              
                            </tr>
                            <tr>
                                <td colspan="2">Choose a file to Upload</td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="file" name="fileToUpload" id="fileToUpload"></td>
                            </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" onclick="location.href='contact.php';" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->
            
        <?php
        }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }
        ?>
            
          <?php
            include 'footer.php';
            ?>
        </div><!-- End Wrapper -->
    </body>
</html>

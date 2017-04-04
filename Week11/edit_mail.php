<?php
require_once('./dao/mailDAO.php');

if(!isset($_GET['email'])){
//Send the user back to the main page
header("Location: index.php");
exit;

} else{
    $mailDAO = new mailDAO();
    $mail = $mailDAO->getMail($_GET['email']);
    if($mail){
?>    
        
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Week 11 Mailing List - Edit Information - <?php echo $mail->getFirstName() . ' ' . $mail->getLastName();?></title>
        <script type="text/javascript">
            function confirmDelete(name){
                return confirm("Do you wish to delete " + name + "?");
            }
        </script>
    </head>
    <body>
        
        <?php
        if(isset($_GET['recordsUpdated'])){
                if(is_numeric($_GET['recordsUpdated'])){
                    echo '<h3> '. $_GET['recordsUpdated']. ' Customer Record Updated.</h3>';
                }
        }
        if(isset($_GET['missingFields'])){
                if($_GET['missingFields']){
                    echo '<h3 style="color:red;"> Please enter both first and last names.</h3>';
                }
        }?>
        <h3>Edit Information</h3>
        <form name="editMail" method="post" action="process_mail.php?action=edit">
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="firstName" id="firstName" 
                               value="<?php echo $mail->getFirstName();?>"></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lastName" id="lastName" 
                               value="<?php echo $mail->getLastName();?>"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" id="email" 
                               value="<?php echo $mail->getEmail();?>" readonly></td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input type="text" name="phoneNumber" id="phoneNumber" 
                               value="<?php echo $mail->getPhoneNumber();?>"></td>
                </tr>
                <tr>
                    <td cospan="2"><a onclick="return confirmDelete('<?php echo $mail->getFirstName() . ' ' . $mail->getLastName();?>')" href="process_mail.php?action=delete&email=<?php echo $mail->getEmail();?>">DELETE <?php echo $mail->getFirstName() . " " . $mail->getLastName();?></a></td>
                </tr>
                <tr>
                    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update Information"></td>
                    <td><input type="reset" name="btnReset" id="btnReset" value="Reset"></td>
                </tr>
            </table>
        </form>
        <h4><a href="index.php">Back to main page</a></h4>
    </body>
</html>
<?php } else{
//Send the user back to the main page
header("Location: index.php");
exit;
}

} ?>
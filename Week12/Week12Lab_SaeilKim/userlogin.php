<?php require_once('./dao/mailDAO.php'); ?>
<?php include 'header.php'; ?>

<?php
session_start();
//session_unset();

$mailDAO = new mailDAO();

if ((isset($_SESSION['AdminID'])) && (!empty($_SESSION['AdminID']))
   &&(isset($_SESSION['LoginDate'])) && (!empty($_SESSION['LoginDate    ']))) {
    header("Location:mailing_list.php");
} else {

  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }            

    
    try{
        //Tracks errors with the form fields
        $hasError = false;
 
        $login=$loginError="";
        $password=$passwordError="";

        if(isset($_POST['login']) || isset($_POST['password'])){

            if(!isset($_POST['login']) || (empty(trim($_POST['login'])))){
                $loginError = "Please enter the login ID.";
                $hasError = true;
            } else {
                $login = test_input($_POST["login"]);
            }

            if(!isset($_POST['password']) || (empty($_POST['password']))){
                $passwordError = "Please enter the password.";
                $hasError = true;
            }
 
            
           if(!$hasError){
               $userYN = $mailDAO->getAdminYn($_POST['login'],$_POST['password']);
               
               if ($userYN) {
                   $_SESSION['AdminID'] = $userYN[0];
                   $_SESSION['LoginDate'] = $userYN[2];
                   unset($_POST['password']);
                   
                   header("Location:mailing_list.php");
               } else {
                    echo '<h3><span style=\'color:red;\' >Username and password did not authenticate. Try Again!</span></h3>';
               }
               
            }

        } 
            
    
?>   
            <div class="clearfix">
                <div>
                        <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div><left>
                        <table style="width: 70%; height:120px" >
                            <tr>
                                <th style="text-align:left"> &nbsp; Login: </th>
                                <td><input type="text" name="login" id="login" size='40' value="<?php echo $login; ?> " >
                                 <?php echo ' <span style=\'color:red;font-size:10px\' > ' . $loginError . '</span>';  ?>
                                </td>
                           </tr>
                            <tr>
                                <th style="text-align:left"> &nbsp; Password: </th>
                                <td><input type="password" name="password" id="password" size='40' >
                                 <?php echo ' <span style=\'color:red;font-size:10px\' > ' . $passwordError . '</span>';  ?>
                                </td>
                           </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Log in'>&nbsp;&nbsp;</td>  
                           </tr>
                         </table>
                         </left>
                        </div>
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
}
            include 'footer.php';
            ?>
        </div><!-- End Wrapper -->
    </body>
</html>

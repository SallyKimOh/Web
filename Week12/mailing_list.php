<?php require_once('./dao/mailDAO.php'); ?>
<?php include 'header.php'; ?>
<?php
session_start();
//session_unset();
$mailDAO = new mailDAO();

if ((isset($_SESSION['AdminID'])) && (!empty($_SESSION['AdminID']))) {
    $loginDate = date_create($_SESSION['LoginDate']);
    $loginDate = date_format($loginDate, 'm/d/Y');

    echo "<br>&nbsp; &nbsp; &nbsp; Session AdminID = " .$_SESSION['AdminID'];
    echo "<br>&nbsp; &nbsp; &nbsp; Last Login Date = " .$loginDate . "<br><br>";

?>
            <div class="clearfix">
                <div>
                        <form name="form1" method="post" action="mailing_list.php">
                        <div><center>
                        <table style="border: 1px solid #FFFFFF;width: 95%" >
                            <tr style="background-color: darkgray;">
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Referrer</th>
                           </tr>
<?php
$list = $mailDAO->getList();
            if($list){
                 foreach($list as $mail){
                    echo '<tr class=tline>';
                    echo '<td style=\'text-align:center;\'>' . $mail->getCustomerName() . '</td>';
                    echo '<td style=\'text-align:center;\'>' . $mail->getPhoneNumber() . '</td>';
                    echo '<td style=\'text-align:center;\'>' . $mail->getEmailAddress() . '</td>';
                    echo '<td style=\'text-align:center;\'>' . $mail->getReferrer() . '</td>';
                    echo '</tr>';
                }
            }
?>
                       
                        </table>
                            </center>
                        </div>
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->

<?php
} else {
    header("Location:userlogin.php");
}
    include 'footer.php';
?>
        </div><!-- End Wrapper -->
    </body>
</html>

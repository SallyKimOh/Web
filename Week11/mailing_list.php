<?php require_once('./dao/mailDAO.php'); ?>
<?php include 'header.php'; ?>

            <div id="content" class="clearfix">
                <div>
                        <form name="form1" method="post" action="mailing_list.php">
                        <div><center>
                        <table style="border: 1px solid #FFFFFF;width: 100%" >
                            <tr style="background-color: darkgray;">
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Referrer</th>
                           </tr>
<?php
$mailDAO = new mailDAO();
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
            include 'footer.php';
            ?>
        </div><!-- End Wrapper -->
    </body>
</html>

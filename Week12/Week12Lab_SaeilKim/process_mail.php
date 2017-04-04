<?php
require_once('./dao/mailDAO.php');
if(isset($_GET['action'])){
    if($_GET['action'] == "edit"){
        if(isset($_POST['email']) && 
                isset($_POST['firstName']) && isset($_POST['lastName']) &&
                isset($_POST['phoneNumber'])){
        
        if(     $_POST['firstName'] != "" &&$_POST['lastName'] != ""                    &&$_POST['email'] != "" &&
                $_POST['phoneNumber'] != ""){    
               
                $mailDAO = new mailDAO();
                $result = $mailDAO->editMail( $_POST['firstName'], $_POST['lastName'],$_POST['email'], $_POST['phoneNumber']);
                

            echo $result;
                if($result > 0){
                    header('Location:edit_mail.php?recordsUpdated='.$result.'&email=' . $_POST['email']);
                } else {
                    header('Location:edit_mail.php?email=' . $_POST['email']);
                }
            } else {
                header('Location:edit_mail.php?missingFields=true&email=' . $_POST['email']);
            }
        } else {
            header('Location:edit_mail.php?error=true&email=' . $_POST['email']);
        }
    }
    
    if($_GET['action'] == "delete"){
        if(isset($_GET['email'])){
            $mailDAO = new mailDAO();
            $success = $mailDAO->deleteMail($_GET['email']);
            echo $success;
            if($success){
                header('Location:index.php?deleted=true');
            } else {
                header('Location:index.php?deleted=false');
            }
        }
    }
}
?>

<?php
require_once('abstractDAO.php');
require_once('./model/mail.php');
require_once('./PasswordHash.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class mailDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }
    
    /*
     * This is an example of how to use the query() method of a mysqli object.
     * 
     * Returns an array of <code>Employee</code> objects. If no employees exist, returns false.
     */
    public function getList(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        $list = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new Mailing object, and add it to the array.
                $mail = new Mail($row['customerName'], $row['phoneNumber'],$row['emailAddress'],$row['referrer']);
                $list[] = $mail;
            }
            $result->free();
            return $list;
        }
        $result->free();
        return false;
    }
    
    /*
     * This is an mailinng of how to use a prepared statement
     * with a select query.
     */
    public function getMail($emailAddress){
        $query = 'SELECT * FROM mailingList WHERE emailAddress = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('s', $emailAddress);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $mail = new Mail($row['customerName'], $row['phoneNumber'],$row['emailAddress'],$row['referrer']);
            $result->free();
            return $mail;
        }
        
        $result->free();
        return false;
    }
    
    /*
     * This is an mailinng of how to use a prepared statement
     * with a select query.
     */
    public function getAdminYn($id,$passwd){
        $val = Array();
        
        $query = 'select adminId from adminusers where username = ? and password=?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('ss', $id,$passwd);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $result->free();
            
            $getToday = $this->addToday($row['adminId']);   
 //           $getAdmin = $this->getAdmin($row['adminId']);    
            
            if ($getToday){
                $getAdmin = $this->getAdmin($row['adminId']);   
//                $val[0] = $row['adminId'];
//                $val[1] = $getToday[2];
                return $getAdmin;
                
            }
            
//            return $row['adminId'];
           // return $val;
        }
        
        $result->free();
        return false;
    }

    public function getAdmin($adminId){
        $val = Array();

        $query = 'SELECT adminId,userName,lastLogin FROM adminusers WHERE AdminId = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('s', $adminId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $var[0] = ($row['adminId']);
            $var[1] = ($row['userName']);
            $var[2] = ($row['lastLogin']);
            $result->free();
            return $var;
        }
        
        $result->free();
        return false;
    }
    

    public function updateSession($id,$passwd){
        if(!$this->mysqli->connect_errno){

            $query = 'Update adminusers set lastLogin=now where AdminId=(select adminId from adminusers where username = ? and password=?)';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ss', $id,$passwd);
            //Execute the statement
                $stmt->execute();
                //If there are errors, they will be in the error property of the
                //mysqli_stmt object.
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return true;
                }
        } else {
            return 'Could not connect to Database.';
        }
    }

    
    
    
    public function addToday($adminId){
        if(!$this->mysqli->connect_errno){

            $query = 'Update adminusers set lastLogin=now() where AdminId=?';
                $stmt = $this->mysqli->prepare($query);
                $stmt->bind_param('i',$adminId);
            //Execute the statement
                $stmt->execute();
                //If there are errors, they will be in the error property of the
                //mysqli_stmt object.
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return true;
                }
        } else {
            return 'Could not connect to Database.';
        }
    }

    
    
    public function addMail($mail){
        
        // Base-2 logarithm of the iteration count used for password stretching
        $hash_cost_log2 = 8;
        // Do we require the hashes to be portable to older systems (less secure)?
        $hash_portable = FALSE;
        $hash = '*';
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            

           $passHash = new PasswordHash($hash_cost_log2, $hash_portable);
            
           $hash = $passHash->gensalt_private($mail->getEmailAddress());
           $hash1 = $passHash->crypt_private($mail->getEmailAddress(),$hash);
            
           if (strlen($hash1) < 20)
                fail('Failed to hash the email');
           unset($passHash);                

           $getMail = $this->getMail($hash1);    
            
            if(!$getMail) {
                
                $query = 'INSERT INTO mailingList (customerName, phoneNumber, emailAddress,referrer) VALUES (?,?,?,?)';
                $stmt = $this->mysqli->prepare($query);
                $stmt->bind_param('ssss', 
                        $mail->getCustomerName(), 
                        $mail->getPhoneNumber(),
                        $hash1, 
                        $mail->getReferrer()); 
                //Execute the statement
     //           echo $mail;
                $stmt->execute();
                //If there are errors, they will be in the error property of the
                //mysqli_stmt object.
                if($stmt->error){
                    return $stmt->error;
                } else {
                    return $mail->getCustomerName() . ' added successfully!';
                }
            } else {
                    return $mail->getEmailAddress() . ' Already subscribed';
           
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
    
    public function deleteMail($email){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailingList WHERE emailAddress = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('s', $emailAddress);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
    public function editMail($customerName, $phoneNumber,$emailAddress,$referrer){
        if(!$this->mysqli->connect_errno){
            $query = 'UPDATE mailingList SET customerName = ?, phoneNumber = ? ,referrer=? WHERE emailAddress = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('ssss', $customerName, $phoneNumber, $referrer,$emailAddress);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return $stmt->affected_rows;
            }
        } else {
            return false;
        }
    }
}

?>

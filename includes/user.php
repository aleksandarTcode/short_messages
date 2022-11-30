<?php
include_once("functions.php");
class User {

    public $database;
    public $username;
    public $email;
    public $password;
    public $hashed_password;
    public $friend = "";
    public $msg_text = "";
    public $mail;
    public $usernameErr;
    public $emailErr;
    public $role;
    public $role_session;


    public function __construct($data_base)
    {
        $this->database = $data_base;
        $this->username = $_SESSION['username'];
    }

    public function set_username($username){
        $this->username = $username;
    }

    public function set_password($password){
        $this->password = $password;
    }

    public function set_friend($friend){
        $this->friend = $friend;
    }

    public function set_msg_text($msg_text){
        $this->msg_text = $msg_text;
    }

    public function add_user(){
        $this->username = test_input($_POST['username']);
        $this->email = test_input($_POST['email']);
        $this->hashed_password = $_SESSION['hashed_password'];
        try{
            $stmt = $this->database->conn->prepare("SELECT username,email FROM users WHERE username = ? OR email = ?;");
            $stmt->execute(array($this->username,$this->email));
            $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
            $row = $stmt->fetch();
//                print_r($row);
            if($stmt->rowCount()!==0 && $row->username == $this->username){
                $this->usernameErr = "Username is already taken!";
            }else if($stmt->rowCount()!==0 && $row->email == $this->email){
                $this->emailErr = "Email is already taken!";
            }
            else {
                $stmt = $this->database->conn->prepare("INSERT INTO users (username,password,email,first_name,last_name,phone) VALUES (:username,:password,:email,:first_name,:last_name,:phone)");
                $stmt->bindParam(':username',$this->username);
                $stmt->bindParam(':password',$this->hashed_password);
                $stmt->bindParam(':email',$_SESSION['email']);
                $stmt->bindParam(':first_name',$_SESSION['first_name']);
                $stmt->bindParam(':last_name',$_SESSION['last_name']);
                $stmt->bindParam(':phone',$_SESSION['phone']);

                $stmt->execute();

                //sending mail to user when register
                $this->mail->IsSMTP();
                $this->mail->Mailer = "smtp";
                $this->mail->SMTPDebug  = 1;
                $this->mail->SMTPAuth   = TRUE;
                $this->mail->SMTPSecure = "tls";
                $this->mail->Port       = 587;
                $this->mail->Host       = "smtp.gmail.com";
                $this->mail->Username   = "testingtrmcic@gmail.com";
                $this->mail->Password   = "ocphwwhfisxkjjjs";

                //Recipients
                $this->mail->setFrom('msgnow@example.com', 'MsgNow');
                $this->mail->addAddress($_SESSION['email'], $_SESSION['first_name']." ".$_SESSION['last_name']);     //Add a recipient
//                $this->mail->addAddress('ellen@example.com');               //Name is optional
                $this->mail->addReplyTo('testingtrmcic@gmail.com', 'Aleksandar');
//                $this->mail->addCC('cc@example.com');
//                $this->mail->addBCC('bcc@example.com');

//                //Attachments
//                $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//                $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $this->mail->isHTML(true);                                  //Set email format to HTML
                $this->mail->Subject = 'Successful registration!';
                $this->mail->Body    = "<h3>Dear {$_SESSION['first_name']}, thank you for registering on our store!</h3><br><p>Your <b>username</b> is: {$_SESSION['username']}</p><p>Your <b>password</b> is: {$_SESSION['password']}</p>";
                $this->mail->AltBody = 'Thank you for registering on our store!';

                $this->mail->send();
                echo 'Message has been sent';

            }


        }catch (PDOException $e){
            echo "Error: ". $e->getMessage();
        }
    } // end add_user

    public function login_user(){

        $this->username = test_input($_POST['username']);
        $this->password = test_input($_POST['password']);

        try{
        $stmt = $this->database->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute(array($this->username));

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
        $row = $stmt->fetch();

            if($stmt->rowCount()!==0){
                $this->role = $row->role;
                $this->role_session = $_SESSION['role'] = $row->role;
                if($row->username == $this->username && password_verify($this->password,$row->password ) && $this->role == 'user'){
                    $_SESSION['username'] = $this->username;
                    $_SESSION['first_name'] = $row->first_name;
                    $_SESSION['last_name'] = $row->last_name;
                    header("Location: home.php");
                }else if($row->username == $this->username && password_verify($this->password,$row->password ) && $this->role == 'admin'){
                    $_SESSION['username'] = $this->username;
                    header("Location: admin.php");
                }
                else{
                    set_message("Your Password is wrong!");
                    $_SESSION['username_temp'] = $_POST['username'];
                    $_SESSION['password_temp'] = $_POST['password'];
                    header("Location: index.php");
                }
            }else {
                set_message("Your Username or Password is wrong!");
                $_SESSION['username_temp'] = $_POST['username'];
                $_SESSION['password_temp'] = $_POST['password'];
                header("Location: index.php");
            }

        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }

    } // end login_user

    public function messages_for_current_user($query,$query_variable){

        $stmt = $this->database->conn->prepare($query);
        $stmt->execute(array($query_variable)); // this is recipient or sender, execute parameter must be an array

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $row = $stmt->fetchAll();

        return $row;


    }

    public function message_thread_for_user(){

        $stmt = $this->database->conn->prepare("SELECT sender,msg_text,time FROM msg WHERE (sender= ? AND recipient = ?) OR (sender= ? AND recipient= ?) ORDER BY time ASC");
        $stmt->execute(array($this->username, $this->friend, $this->friend, $this->username));
        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $table = "<table class='table mt-5'>
                <thead>
                <tr>
                    <th class='text-center align-middle'>Sender</th>
                    <th class='text-center align-middle'>Message thread</th>
                    <th class='text-center align-middle'>Time</th>
                </tr>
                </thead>";
                $i=0;
        while($row = $stmt->fetchAll()){
            foreach ($row as $object){

                if($object->sender == $this->username){
                    $class = "table-primary";
                } else $class="";

                $table.="<tbody>
                 <tr class='{$class}'>
                    <td>{$object->sender}</td>
                    <td>{$object->msg_text}</td>
                    <td class='text-center align-middle'>{$object->time}</td>
                 </tr>                
                 </tbody>";
                $i++;
            }
        }
        $table.="<tr>
                    <td>Total messages: </td>
                    <td colspan='2' class='text-right'>{$i}</td>
                 </tr> </table>";


        echo $table;

    }

    public function get_friends_for_user(){

        $stmt = $this->database->conn->prepare("SELECT user2 as friend FROM friends WHERE user1= ? UNION SELECT user1 as friend FROM friends WHERE user2= ?");
        $stmt->execute(array($this->username,$this->username));

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $options = '';
        while($row = $stmt->fetchAll()){
            foreach ($row as $object){
                $options .= "<option value='{$object->friend}'>{$object->friend}</option>";
            }
        }

        echo $options;
    }

    public function add_new_message(){

        try {

        $stmt = $this->database->conn->prepare("INSERT into msg (sender, recipient, msg_text) VALUES (:sender,:recipient,:msg_text)");
        $stmt->bindParam(':sender',$this->username);
        $stmt->bindParam(':recipient',$this->friend);
        $stmt->bindParam(':msg_text',$this->msg_text);

        $stmt->execute();

            echo "New message sent successfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    public function update_message_as_read($query_variable){

        $stmt = $this->database->conn->prepare("UPDATE msg SET read_msg = '1' WHERE id = ?");

        $stmt->execute(array($query_variable));
    }

    public function update_all_messages_as_read($query_variable){

        $stmt = $this->database->conn->prepare("UPDATE msg SET read_msg = '1' WHERE sender = ? and recipient = ?");

        $stmt->execute(array($query_variable,$this->username));
    }

    public function get_all_messages_for_current_user($query,$query_variable,$query_variable2){

        $stmt = $this->database->conn->prepare($query);
        $stmt->execute(array($query_variable,$query_variable2)); // this is recipient or sender, execute parameter must be an array

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $row = $stmt->fetchAll();

        return $row;


    }









}




?>
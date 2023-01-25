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
    public $usernameErr="";
    public $emailErr="";
    public $role;
    public $role_session;
    public $username_update;
    public $email_update;
    public $username_updateErr="";
    public $email_updateErr="";


    public $target_dir = "img/profile_photos/";
    public $target_file;
    public $uploadOk = 1;
    public $imageFileType;
    public $imageMsg = "";
    public $user_photo = "";


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
                    header("Location: home.php");
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

    public function get_all_users_for_search(){
        try{
            $stmt = $this->database->conn->prepare("SELECT id,username,user_photo FROM users");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
            $row = $stmt->fetchAll();
            return $row;
            }
            catch (PDOException $e){
                echo "Error: ". $e->getMessage();
            }
            }//end get_all_users

    public function get_user(){

        try{
            $stmt = $this->database->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute(array($this->username));
            $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
            $row = $stmt->fetch();
//            print_r($row);
            $_SESSION['first_name'] = $row->first_name;
            $_SESSION['last_name'] = $row->last_name;
            $_SESSION['email'] = $row->email;
            $_SESSION['username'] = $row->username;
            $_SESSION['password_from_database'] = $row->password;

            $this->user_photo = $row->user_photo;

            return $row;



        }catch (PDOException $e){
            echo "Error: ". $e->getMessage();
        }




    } // end get_user

    public function update_user(){

        $this->username_update = test_input($_POST['username_update']);
        $this->email_update = test_input($_POST['email_update']);
        try{
            $stmt = $this->database->conn->prepare("SELECT username,email FROM users WHERE username = ? OR email = ?;");
            $stmt->execute(array($this->username_update,$this->email_update));
            $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
            $row = $stmt->fetch();
//                print_r($row);
            //checks if username or email is taken, and also checks if updated username or email is the same as current username or email and doesn't show error if is
            if(($stmt->rowCount()!==0 && $row->username == $this->username_update) && ($stmt->rowCount()!==0 && $row->username == $this->username_update && $this->username!==$this->username_update)){
                $this->username_updateErr = "Username is already taken!";
            } else if(($stmt->rowCount()!==0 && $row->email == $this->email_update) && ($stmt->rowCount()!==0 && $row->email == $this->email_update && $_SESSION['email'] !== $_SESSION['email_update'])){
                $this->email_updateErr = "Email is already taken!";
            }
            else {

                $stmt = $this->database->conn->prepare("UPDATE users SET username=:username,first_name=:first_name,last_name=:last_name,email=:email,password=:password WHERE username=:current_username");
                $stmt->bindParam(':username', $_SESSION['username_update']);
                $stmt->bindParam(':first_name', $_SESSION['first_name_update']);
                $stmt->bindParam(':last_name', $_SESSION['last_name_update']);
                $stmt->bindParam(':email', $_SESSION['email_update']);
                $stmt->bindParam(':password', $_SESSION['hashed_password']);
                $stmt->bindParam(':current_username', $this->username);

                $_SESSION['username'] = $_SESSION['username_update'];

                $stmt->execute();
            }
        }

        catch (PDOException $e){
            echo "Error: ". $e->getMessage();
        }


    } // end update_user

    public function upload_profile_image(){

        // Check if image file is an actual image or fake image
//        $this->target_file = $this->target_dir . basename($_FILES["profile_photo"]["name"]);
        $this->imageFileType = strtolower(pathinfo(basename($_FILES["profile_photo"]["name"]), PATHINFO_EXTENSION));
        $this->target_file = $this->target_dir . date('m-d-Y_H-i-s') .".".$this->imageFileType;
//        $this->target_file = $this->target_dir."miki.jpg";
        $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
        if ($check !== false) {
            $this->imageMsg = "File is an image - " . $check["mime"] . ".";
            $this->uploadOk = 1;
        } else {
            $this->imageMsg = "File is not an image";
            $this->uploadOk = 0;
        }

        // Check if file already exists *not necessary anymore after image name has been changed to be a unique timestamp
//        if (file_exists($this->target_file)) {
//            $this->imageMsg = "Sorry, file already exists";
//            $this->uploadOk = 0;
//        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 600000) {
            $this->imageMsg = "Sorry, your file is too large";
            $this->uploadOk = 0;
        }

        // Allow certain file formats
        if ($this->imageFileType != "jpg" && $this->imageFileType != "png" && $this->imageFileType != "jpeg"
            && $this->imageFileType != "gif") {
            $this->imageMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
            $this->uploadOk = 0;
        }


        // Check if $uploadOk is set to 0 by an error
        if ($this->uploadOk == 0) {
            $this->imageMsg = $this->imageMsg.", your file was not uploaded.";
// if everything is ok, try to upload a file
        } else {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $this->target_file)) {
                $this->imageMsg = "The file " . htmlspecialchars(basename($_FILES["profile_photo"]["name"])) . " has been uploaded.";
                try{
                    $stmt = $this->database->conn->prepare("UPDATE users SET user_photo=? WHERE username=?");

//                    $stmt->bindParam(':user_photo', "tdfg");
//                    $stmt->bindParam(':username', $this->username);

                    $stmt->execute(array(date('m-d-Y_H-i-s').".".$this->imageFileType, $this->username));

                }  catch (PDOException $e){
                    echo "Error: ". $e->getMessage();
                }

            } else {
                $this->imageMsg = "Sorry, there was an error uploading your file.";
            }
        }


    } //End upload_profile_image

    public function messages_for_current_user_with_pagination($query,$query_variable){



        $stmt = $this->database->conn->prepare($query);
        $stmt->execute(array($query_variable)); // this is recipient or sender, execute parameter must be an array
        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
        $row = $stmt->fetchAll();

        $total_entries = count($row);
        $perPage = 2;

        //set page in url to 1 if it is set to non number
        if (isset($_GET['page'])) {
            $page = preg_replace('/[^0-9]/', '', $_GET['page']);
        } else {
            $page = 1;
        }

        if($total_entries!==0) {

            $lastPage = ceil($total_entries / $perPage);


            // if someone is changing page in url manually
            if ($page < 1) {
                $page = 1;
            } elseif ($page > $lastPage) {
                $page = $lastPage;
            }

            $middleNumbers = '';
            $sub1 = $page - 1;
            $sub2 = $page - 2;
            $add1 = $page + 1;
            $add2 = $page + 2;

            if ($page == 1) {
                $middleNumbers .= '<li class="page-item active"><a class="page-link">' . $page . '</a></li>';

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';

            } elseif ($page == $lastPage) {

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';

                $middleNumbers .= '<li class="page-item active"><a class="page-link">' . $page . '</a></li>';

            } elseif ($page > 2 && $page < ($lastPage - 1)) {
                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub2 . '">' . $sub2 . '</a></li>';

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';

                $middleNumbers .= '<li class="page-item active"><a class="page-link">' . $page . '</a></li>';

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add2 . '">' . $add2 . '</a></li>';

            } elseif ($page > 1 && $page < $lastPage) {
                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $sub1 . '">' . $sub1 . '</a></li>';

                $middleNumbers .= '<li class="page-item active"><a class="page-link">' . $page . '</a></li>';

                $middleNumbers .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $add1 . '">' . $add1 . '</a></li>';

            }



            $outputPagination = '';

            if ($page != 1) {
                $prev = $page - 1;
                $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $prev . '">Back</a></li>';
            }

            $outputPagination .= $middleNumbers;


            if ($page != $lastPage) {
                $next = $page + 1;
                $outputPagination .= '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . '">Next</a></li>';
            }

            //don't show pagination if there is only one page
            if($page == 1 && $lastPage ==1){
                $outputPagination = '';
            }


            // echo pagination only for sent.php and inbox.php and not for message_from_inbox.php and message_from_sent.php
            if(strpos(basename($_SERVER['REQUEST_URI']),'from') == false){
                echo "<div class='text-center' style='clear: both'><ul class='pagination'>{$outputPagination}</ul></div>";
            }


            $limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;

            try{

                $stmt2 = $this->database->conn->prepare($query .' '. $limit);
                $stmt2->execute(array($query_variable));
                $result2 = $stmt2->setFetchMode(PDO::FETCH_OBJ);
                $row = $stmt2->fetchAll();
                return $row;


            }catch (PDOException $e) {
                echo "Error: " . $e->getMessage();

            }



        }//end if $total_entries exist check

//        return $row;


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

    public function check_if_user_and_friend_in_search_are_already_friends($friend_from_search){
        try{
            $stmt = $this->database->conn->prepare("SELECT user2 as friend FROM friends WHERE user1 = ? AND user2 = ? UNION SELECT user1 as friend FROM friends WHERE user2= ? AND user1=?;");
            $stmt->execute(array($this->username,$friend_from_search,$this->username,$friend_from_search));

            $result = $stmt->setFetchMode(PDO::FETCH_OBJ);
            $row = $stmt->fetchAll();

            if($stmt->rowCount()){
                return true;
            }else return false;

        }
        catch (PDOException $e){
            echo "Error: ". $e->getMessage();
        }

    }

    public function make_a_friend($user2){
        try{
            $stmt = $this->database->conn->prepare("INSERT INTO friends (user1, user2) VALUES (?,?)");
            $stmt->execute(array($this->username,$user2));
    }catch (PDOException $e){
        echo "Error: ". $e->getMessage();
    }
    }







}




?>
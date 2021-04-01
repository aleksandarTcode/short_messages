<?php

class User {

    public $database;
    public $username;
    public $friend = "";
    public $msg_text = "";

    public function __construct($data_base)
    {
        $this->database = $data_base;
    }

    public function set_username($username){
        $this->username=$username;
    }

    public function set_friend($friend){
        $this->friend=$friend;
    }

    public function set_msg_text($msg_text){
        $this->msg_text=$msg_text;
    }


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
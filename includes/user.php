<?php

class User {

    public $database;
    public $username;
    public $friend = "";

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

    public function inbox_for_current_user(){

        $stmt = $this->database->conn->prepare("SELECT sender,msg_text,time FROM msg WHERE recipient = ? ORDER BY time DESC");
        $stmt->execute(array($this->username)); // this is recipient, execute parameter must be an array

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

       $table = "<table class='table table-bordered mt-5'>
                <thead>
                <tr>
                    <th>Sender</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
                </thead>";

        while($row = $stmt->fetchAll()){
            foreach ($row as $object){

                $table.="<tbody>
                 <tr>
                    <td class='text-center'><strong><a href='thread.php?friend={$object->sender}'>{$object->sender}</a></strong></td>
                    <td>{$object->msg_text}</td>
                    <td>{$object->time}</td>
                 </tr>                
                 </tbody>";
            }
        }
        $table.=" </table>";

        echo $table;

    }


    public function sent_for_current_user(){

        $stmt = $this->database->conn->prepare("SELECT recipient,msg_text,time FROM msg WHERE sender = ? ORDER BY time DESC");
        $stmt->execute(array($this->username)); // this is sender, execute parameter must be an array

        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $table = "<table class='table table-bordered mt-5'>
                <thead>
                <tr>
                    <th>Recipient</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
                </thead>";

        while($row = $stmt->fetchAll()){
            foreach ($row as $object){

                $table.="<tbody>
                 <tr>
                    <td class='text-center'><strong><a href='thread.php?friend={$object->recipient}'>{$object->recipient}</a></strong></td>
                    <td>{$object->msg_text}</td>
                    <td>{$object->time}</td>
                 </tr>                
                 </tbody>";
            }
        }
        $table.=" </table>";

        echo $table;

    }

    public function message_thread_for_user(){

        $stmt = $this->database->conn->prepare("SELECT sender,msg_text,time FROM msg WHERE (sender= ? AND recipient = ?) OR (sender= ? AND recipient= ?) ORDER BY time ASC");
        $stmt->execute(array($this->username, $this->friend, $this->friend, $this->username));
        $result = $stmt->setFetchMode(PDO::FETCH_OBJ);

        $table = "<table class='table mt-5'>
                <thead>
                <tr>
                    <th>Sender</th>
                    <th>Message thread</th>
                    <th>Time</th>
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
                    <td>{$object->time}</td>
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







}




?>
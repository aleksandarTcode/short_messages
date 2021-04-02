<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database); //$database is instance of Database class
//$user->set_username($_SESSION['username']);

//$result_array = $user->messages_for_current_user('SELECT id,sender,msg_text,time,read_msg FROM msg WHERE recipient = ? ORDER BY time DESC',$user->username);

?>



    <div class="row">
        <div class="col-md-6 offset-md-4">

            <script>
                function showHint(str) {
                    if (str.length == 0) {
                        document.getElementById("txtHint").innerHTML = "";
                        return;
                    } else {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("txtHint").innerHTML = this.responseText;
                            }
                        };
                        xmlhttp.open("GET", "includes/getmessage.php?q=" + str, true);
                        xmlhttp.send();
                    }
                }
            </script>


            <p><b>Search messages:</b></p>
            <form action="">
                <div class="form-group">
                <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)" placeholder="enter text">
                </div>
            </form>
            <p>Messages: <span id="txtHint"></span></p>




        </div>
    </div>




<?php include("includes/home_footer.php"); ?>















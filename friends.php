<?php include ("includes/home_header.php");?>



<?php

$user = new User($database); //$database is instance of Database class

?>

<div class="row">
    <div class="col-md-6 offset-md-4">

        <script>
            function showResult(str) {
                if (str.length==0) {
                    document.getElementById("search-results").innerHTML="";

                    return;
                }
                var xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange=function() {
                    if (this.readyState==4 && this.status==200) {
                        document.getElementById("search-results").innerHTML=this.responseText;

                    }
                }
                xmlhttp.open("GET","includes/getfriends.php?q="+str,true);
                xmlhttp.send();
            }
        </script>

        <form class="form-inline">
            <div class="search-container">
                <div class="input-group">
                    <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">
          <i class="fa fa-search"></i>
        </span>
                    </div>
                    <input type="text" class="form-control" onkeyup="showResult(this.value)" placeholder="Search for Friends" aria-label="Search" aria-describedby="basic-addon1" id="search-input">
                </div>
                <div id="search-results" class="form-control"></div>
            </div>
        </form>



    </div>
</div>



<?php include("includes/home_footer.php"); ?>















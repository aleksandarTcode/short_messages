<?php require_once("includes/init.php"); ?>
<?php if(!isset($_SESSION['username'])) header("Location: index.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
          crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>MsgNow</title>
</head>

<body data-spy="scroll" data-target="#main-nav" id="home">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
        <a href="<?php echo isset($_SESSION['username'])?'home.php':'index.php' ?>" class="navbar-brand">MsgNow</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="inbox.php" class="nav-link">Inbox</a>
                </li>
                <li class="nav-item">
                    <a href="sent.php" class="nav-link">Sent</a>
                </li>
                <li class="nav-item">
                    <a href="search.php" class="nav-link">Search</a>
                </li>
                <li>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown mr-3">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user"></i>  Welcome <?php echo $_SESSION['username']; ?>
                            </a>
                            <div class="dropdown-menu">
                                <a href="logout.php" class="dropdown-item" onClick="return confirm('Are you sure you want to logout?')">
                                    <i class="fas fa-user-times"></i> Logout
                                </a>
                                <a href="profile.php" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a>
                                <!--                                <a href="#" class="dropdown-item">-->
                                <!--                                    <i class="fas fa-cog"></i> Settings-->
                                <!--                                </a>-->
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--end header-->
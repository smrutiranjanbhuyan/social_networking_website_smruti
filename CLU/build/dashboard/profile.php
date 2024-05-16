<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['user_id']) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>User Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-rwoI1FBYYanGkdUUe1/kJrjGm2iXf9gx3QRR1PRhdJlzSHwuF6F6zfeYjN3g6fno" crossorigin="anonymous">
        <link rel="stylesheet" href="styles/profile.css">
        <style>
            
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse container" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">DevBase</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php echo $_SESSION['username']; ?>
                                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li align="center" class="well">
                                    <div>
                                        <img class="img-responsive" style="padding: 2%" src="<?php echo isset($_SESSION['avatar']) ? "../uploads/" . $_SESSION['avatar'] : 'https://bootdey.com/img/Content/avatar/avatar1.png'; ?>" />
                                        <a class="change" href="./update_profile.php">Change Picture</a>
                                    </div>
                                    <a href="./security.php" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-lock"></span> Security</a>
                                    <a href="..\server\routs\logout.php" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container bootstrap snippets bootdey">
            <div class="row well">
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-stacked well">
                        <li class="active">
                            <a href="#"><i class="fa fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="./posts.php"><i class="fa fa-home"></i>Posts</a>
                        </li>

                        <li>
                            <a href="./addFriends.php"><i class="fa fa-home"></i>Add Friends</a>
                        </li>
                        <li>
                            <a href="./myFriends.php"><i class="fa fa-home"></i>My Friends</a>
                        </li>
                        <li>
                            <a href="./chatroom.php"><i class="fa fa-home"></i>Chat Room</a>
                        </li>
                        <li>
                            <a href="./update_profile.php"><i class="fa fa-key"></i> Update</a>
                        </li>
                        <li>
                            <a href="..\server\routs\logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="panel" style="background-image: none;">
                        <img class="pic img-circle" src="<?php echo isset($_SESSION['avatar']) ? "../uploads/" . $_SESSION['avatar'] : 'https://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="User Avatar" />
                        <div class="name d-none d-sm-block">
                            <h2><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'user name'; ?></h2>
                        </div>
                       


                        <button type="button" class="btn btn-xs btn-primary pull-right" style="margin: 10px" id="changeCoverButton">
                            <span class="glyphicon glyphicon-picture"></span> Change cover
                        </button>
                    </div>
                    <br />
                    <br />
                    <br />
                    <!-- Card to display followers and followings -->
                    <div class="card border-0 rounded-lg">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-header bg-light border-0 text-center">
                                            <h5 class="card-title text-primary mb-0">Followers</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <!-- Replace 'X' with the actual number of followers -->
                                            <h3 class="card-text font-weight-bold"><?php echo $_SESSION['followers_count'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-header bg-light border-0 text-center">
                                            <h5 class="card-title text-success mb-0">Following</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <!-- Replace 'Y' with the actual number of following -->
                                            <h3 class="card-text font-weight-bold"><?php echo $_SESSION['following_count'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-lg">
                                        <div class="card-header bg-light border-0 text-center">
                                            <h5 class="card-title text-danger mb-0">You liked</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <!-- Replace 'Z' with the actual number of likes -->
                                            <h3 class="card-text font-weight-bold"><?php echo $_SESSION['likes_count'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts at the end of body for faster loading -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="./scripts/fetch_user.js"></script>

    </body>

    </html>
<?php
} else {
    header("Location: ../signin.php");
    exit();
}
?>
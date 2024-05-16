<?php
session_start(); 
if (isset($_SESSION['username']) &&  $_SESSION['user_id']) {
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Upate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">
        body {
            margin-top: 20px;
            background-color: #f2f6fc;
            color: #69707a;
        }

        .img-account-profile {
            height: 10rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }

        .card .card-header {
            font-weight: 500;
        }

        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }

        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }

        .form-control,
        .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }

        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Style for profile picture upload area */
        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Select Image';
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 0.5em 1em;
            outline: none;
            white-space: nowrap;
            cursor: pointer;
            font-weight: 700;
            border-radius: 0.35rem;
        }

        .custom-file-input:hover::before {
            background: #0056b3;
        }

        .custom-file-input:active::before {
            background: #0056b3;
        }

        .custom-file-input:focus::before {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .custom-file-input::after {
            content: 'No file chosen';
        }

        /* End of profile picture upload area style */
    </style>
</head>
<body>
<div class="container-xl px-4 mt-4">
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="./profile.php
        ">Back to Profile</a>
        <a class="nav-link" href="../server/routs/logout.php">Logout</a>
        <a class="nav-link" href="./posts.php" >Posts</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">
        <form action="../server/routs/update_profile.php" method="post" enctype="multipart/form-data">
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                       
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                <input class="form-control" id="inputUsername" name="inputUsername" type="text" placeholder="Enter your username" />
                            </div>
                        
                           
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="inputPhone" name="inputPhone" type="tel" placeholder="Enter your phone number" />
                                </div>
                               
                            </div>
                            <!-- Profile picture upload area -->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputProfilePicture">Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputProfilePicture" name="inputProfilePicture">
                                    <label class="custom-file-label" for="inputProfilePicture">Choose file...</label>
                                </div>
                            </div>
                            <!-- End of profile picture upload area -->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                       
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
<?php
} else {
    
    header("Location: ../signin.php");
    exit();
}
?>
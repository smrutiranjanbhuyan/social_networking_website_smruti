<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 70px; /* Adjusted to account for navbar height */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Password Update</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update Password</h5>
                    </div>
                    <div class="card-body">
                        <form id="password-update-form">
                            <div class="form-group">
                                <label for="current-password">Current Password</label>
                                <input type="password" class="form-control" id="current-password"
                                    name="current-password" required>
                            </div>
                            <div class="form-group">
                                <label for="new-password">New Password</label>
                                <input type="password" class="form-control" id="new-password" name="new-password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="confirm-new-password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm-new-password"
                                    name="confirm-new-password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   

    <!-- Custom JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#password-update-form').submit(function (e) {
            e.preventDefault(); // Prevent form submission

            var currentPassword = $('#current-password').val();
            var newPassword = $('#new-password').val();
            var confirmNewPassword = $('#confirm-new-password').val();

            if (newPassword !== confirmNewPassword) {
                alert("New password and confirm password do not match");
                return;
            }

            $.ajax({
                url: '../server/routes/update_password.php',
                type: 'POST',
                data: {
                    current_password: currentPassword,
                    new_password: newPassword
                },
                success: function (response) {
                    alert(response);
                    $('#password-update-form')[0].reset();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred while updating password. Please try again.");
                }
            });
        });
    });
</script>


</body>

</html>

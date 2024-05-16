<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['user_id']) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <title>My Friends</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Link to Bootstrap CSS -->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Link to custom CSS -->
    <style>
      body {
        padding-top: 80px;
      }

      .navbar.fixed-top {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
      }

      .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
      }

      .profile-photo-lg {
        max-width: 100%;
        height: auto;
      }

      .profile-link {
        color: #007bff;
        text-decoration: none;
      }

      .btn-follow {
        width: 100%;
      }
    </style>

  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-10 fixed-top">
      <a class="navbar-brand" href="#">My Friends</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="./profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./posts.php">Posts</a>
          </li>
          <li class="nav-item bg-danger rounded">
            <a class="nav-link text-white" href="../server/routs/logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container "> <!-- Added margin top -->
      <!-- users appear here -->
    </div>
    <!-- Link to jQuery -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- Link to Bootstrap JS -->
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $.ajax({
          url: "../server/routs/my_friends.php",
          type: "GET",
          dataType: "json",
          success: function(users) {
            if (!users || users.length === 0) {
              $('.container').append("You have no friends");
              return;
            }
            users.forEach(function(user) {
              var userCard = $(`  <div class="row">
      <div class="col-md-8" id="user-${user.user_id}">
        <div class="card">
          <div class="row">
            <div class="col-md-2 col-sm-2">
              <!-- User Profile Photo -->
              <img src="../uploads/${user.profile_pic_url}" alt="user" class="profile-photo-lg" />
            </div>
            <div class="col-md-7 col-sm-7">
              <!-- User Name and Occupation -->
              <h5><a href="#" class="profile-link" id="${user.user_id}">${user.username}</a></h5>
              <p class="mb-1">${user.email?user.email:"Email not found"}</p>
              <!-- User Distance -->
              <p class="text-muted mb-1">${user.phone?user.phone:"No not found"}</p>
            </div>
            <!-- Follow Buttons -->
            <div class="col-md-3 col-sm-3">
              <button class="btn btn-danger btn-unfollow mb-1 btn-${user.user_id}" id="${user.user_id}">UnFollow</button>
               
            </div>
          </div>
        </div>
      </div>
    </div>`);
              $('.container').append(userCard);
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText); // Output error to console (for testing)
            alert("Error fetching users. Please try again later.");
          }
        });
      });

      // Function to add friend via AJAX

      // Function to unfollow user via AJAX
      function unfollowUser() {
        var userId = <?php echo $_SESSION['user_id']; ?>;
        var friendId = $(this).attr('id');
        $.ajax({
          url: "../server/routs/remove_friend.php",
          type: "POST",
          dataType: "json",
          data: {
            user_id: userId,
            friend_id: friendId
          },
          success: function(response) {
            if (response.success) {
              alert("User unfollowed successfully!");
              <?php
              if ($_SESSION['following_count'] !== 0) {
                $_SESSION['following_count']--;
              }
              ?>

              $(`#user-${friendId}`).hide();


            } else {
              alert("Error: " + response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("Error unfollowing user. Please try again later.");
          }
        });
      }


      $(document).on('click', '.btn-unfollow', unfollowUser);
    </script>
  </body>

  </html>
<?php
} else {
  header("Location: ../signin.php");
  exit();
}
?>
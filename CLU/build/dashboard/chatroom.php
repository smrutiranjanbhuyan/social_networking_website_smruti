<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chat Room </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/chatroom.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default mt-0 navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Chats</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="./profile.php">Home <span class="sr-only">(current)</span></a></li>
                    <li><a href="./update_profile.php">Updates</a></li>
                    <li><a href="..\server\routs\logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Chat Room Content -->
    <div class="container bootstrap snippets bootdey mb-4">
        <div class="row">
            <!-- Friend List Column -->
            <div class="col-md-4 bg-white">
                <div class="row border-bottom padding-sm" style="height: 40px;">
                    Friends
                </div>
                <!-- Friend List -->
                <ul class="friend-list">
                    <!-- Sample friend list items -->
                    <li class="active bounceInDown my-friends" value="1">
                        <a href="#" class="clearfix">
                            <img src="https://bootdey.com/img/Content/user_1.jpg" alt class="img-circle">
                            <div class="friend-name">
                                <strong>John Doe</strong>
                            </div>
                            <div class="last-message text-muted">Hello, Are you there?</div>
                            <small class="time text-muted">Just now</small>
                            <small class="chat-alert label label-danger">1</small>
                        </a>
                    </li>
                    <!-- More friend list items -->
                </ul>
            </div>

            <!-- Chat Messages Column -->
            <div class="col-md-8 bg-white">
                <!-- Chat Messages -->
                <div class="chat-message">
                    <ul class="chat">
                        <!-- Sample chat messages -->
                        <div class="card mb-3" style="border: none; border-radius: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                            <div class="card-body" style="padding: 20px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="card-text">Connect with Your Friends!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
                <!-- Chat Box -->
                <div class="chat-box bg-white">
                    <div class="input-group">
                        <input class="form-control border no-shadow no-rounded messagetext" placeholder="Type your message here">
                        <span class="input-group-btn">
                            <button class="btn btn-success no-rounded sendbtn" type="button">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- Your Custom JavaScript Code -->
    <script>
        let currentSelectedUser = "";

        // Function to fetch messages
        function fetchMessages(receiver_id) {
            $(".chat").empty();
            $.ajax({
                url: "../server/messages/fetch_messages.php",
                type: "POST",
                dataType: "json",
                data: {
                    receiver_id: receiver_id,
                },
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(index, message) {
                            var x =
                                message.sender_id != receiver_id ?
                                `<li class="left clearfix">
                                <span class="chat-img pull-left" id="${message.length}">
                                    <img src="<?php echo isset($_SESSION['avatar']) ? "../uploads/" . $_SESSION['avatar'] : 'https://bootdey.com/img/Content/avatar/avatar1.png'; ?>" alt="User Avatar" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font"><?php echo isset($_SESSION['avatar']) ? $_SESSION['username'] : 'you'; ?></strong>
                                        <small class="pull-right text-muted">
                                            <i class="fa fa-clock-o"></i> ${message.created_at}
                                        </small>
                                    </div>
                                    <p>
                                        ${message.message_text}
                                    </p>
                                </div>
                            </li>` :
                                `<li class="right clearfix">
                                <span class="chat-img pull-right" id="${message.length}">
                                    <img src="../uploads/${message.sender_profile_pic}" alt="User Avatar" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">${message.sender_name}</strong>
                                        <small class="pull-right text-muted">
                                            <i class="fa fa-clock-o"></i> ${new Date().toLocaleTimeString()}
                                        </small>
                                    </div>
                                    <p>
                                        ${message.message_text}
                                    </p>
                                </div>
                            </li>`;

                            $(".chat").append(x);
                        });

                        // Scroll to bottom of chat window
                        $(".chat").scrollTop($(".chat")[0].scrollHeight);
                    } else {
                        console.log("No messages");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                },
            });
        }

        $(document).ready(function() {
            // Function to fetch followers
            function fetchFollowers() {
                $.ajax({
                    url: "../server/messages/user_friends.php",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            displayFollowers(response.followers);
                        } else {
                            console.error("Error: " + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                    },
                });
            }

            // Function to display followers
            function displayFollowers(followers) {
                $(".friend-list").empty();
                followers.forEach(function(follower) {
                    var followerHtml = `<li class="active bounceInDown my-friends" value="${follower.user_id}" ">
                        <a href="#" class="clearfix">
                            <img src="../uploads/${follower.profile_pic_url}" alt class="img-circle">
                            <div class="friend-name">
                                <strong>${follower.username}</strong>
                            </div>
                            <div class="last-message text-muted">Hello, Are you there?</div>
                            <small class="time text-muted">Just now</small>
                            <small class="chat-alert label label-danger">1</small>
                        </a>
                    </li>`;
                    $(".friend-list").append(followerHtml);
                });

                // Add click event listener to my-friends
                $(".my-friends").click(function(e) {
                    e.preventDefault();
                    var friendId = $(this).attr("value");
                    currentSelectedUser = friendId;
                    fetchMessages(friendId);
                });
            }

            function sendMessage(receiverId, message) {
                $.ajax({
                    url: "../server/messages/send_message.php",
                    type: "POST",
                    data: {
                        follower_id: receiverId,
                        message: message,
                    },
                    success: function(response) {
                        console.log("Message sent successfully");
                        fetchMessages(receiverId);
                        // You can handle further actions after sending the message if needed
                    },
                    error: function(xhr, status, error) {
                        console.error("Error sending message: " + error);
                    },
                });
            }

            $(".sendbtn").click(function() {
                let message = $(".messagetext").val().trim();
                if (currentSelectedUser !== "" && message !== "") {
                    sendMessage(currentSelectedUser, message);
                    $(".messagetext").val(""); // Clear input after sending message
                } else {
                    console.log("Invalid message or user not selected");
                }
            });
 setInterval(function() {
                    if (currentSelectedUser !== "") {
                        fetchMessages(currentSelectedUser);
                    }
                }, 5000);
            fetchFollowers();
        });
    </script>
</body>

</html>

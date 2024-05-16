<?php
include('../server/connect.php');
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>View Posts</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="styles/posts.css">
    </head>

    <body>
        <!-- navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top custom-navbar">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="./profile.php">DevBase</a>
                    <a class="navbar-brand" href="./update_profile.php">Update</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <!-- adding posts -->
        <div class="container" style="margin-top: 50px;">
            <!-- Button trigger modal -->
            <button class="add-post-btn" id="addPostBtn"><i class="fas fa-plus " data-toggle="modal" data-target="#addPostModal"></i></button>

            <!-- Modal -->
            <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPostModalLabel">Add Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="../server//routs/process_post.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="postTitle">Type:</label>
                                    <input type="text" class="form-control" id="postTitle" name="postType" required>
                                </div>
                                <div class="form-group">
                                    <label for="postTitle">Title:</label>
                                    <input type="text" class="form-control" id="postTitle" name="postTitle" required>
                                </div>
                                <div class="form-group">
                                    <label for="postDescription">Description:</label>
                                    <textarea class="form-control" id="postDescription" name="postDescription" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="postImage">Image:</label>
                                    <input type="file" class="form-control-file" id="postImage" name="postImage" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Comment Popup -->
        <div class="container" style="margin-top: 50px">
            <h2>View Posts</h2>
            <!-- Iterate through posts -->
            <?php foreach ($_SESSION['posts'] as $post) : ?>
                <?php
                // Select username for this post
                $user_id = $post['user_id'];
                $username_query = "SELECT username FROM users WHERE user_id = $user_id";
                $username_result = mysqli_query($connect, $username_query);
                $username_row = mysqli_fetch_assoc($username_result);
                $username = $username_row['username'];
                ?>
                <div class="post">
                    <div class="post-content">
                        <div class="post-title bg-primary text-dark"><?php echo $post['title']; ?></div>
                        <div class="post-description"><?php echo $post['content'] ? $post['content'] : "No content"; ?></div>
                        <div class="post-image">
                            <img src="<?php echo $post['post_image'] ? "../uploads/" . $post['post_image'] : "../images/404.svg"; ?>" alt="Post Image" class="img-responsive" />

                        </div>
                        <div class="post-author">
                            <p>Author: <?php echo $username; ?></p>
                        </div>
                        <div class="post-timestamp">
                            <p>Posted At: <?php echo $post['created_at']; ?></p>
                        </div>
                        <div class="interaction">
                            <span class="like-btn"><i class="fas fa-heart"></i> Like</span>
                            <span class="like-count-<?php echo $post['post_id']; ?>" data-toggle="modal" data-target="#likesModal-<?php echo $post['post_id']; ?>">
                                5 likes
                            </span>
                            <span class="comment-btn-<?php echo $post['post_id']; ?>" data-toggle="modal" data-target="#commentModal-<?php echo $post['post_id']; ?>"><i class="fas fa-comment"></i> Comment</span>
                            <span class="comment-count-<?php echo $post['post_id']; ?>" data-toggle="modal" data-target="#comments-<?php echo $post['post_id']; ?>">5 Comments</span>
                            <!-- Hidden input fields for likes and comments -->
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        </div>

                        <!-- coments  -->
                        <div id="comments-<?php echo $post['post_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="commentModalLabel">Comments</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display comments dynamically -->
                                        <ul class="post-comments">

                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="closer-btn" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Comment Modal -->
                        <div id="commentModal-<?php echo $post['post_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="commentModalLabel">Comment Box</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Comment form -->
                                        <form id="commentForm_<?php echo $post['post_id']; ?>" class="commentForm" method="post" action="">
                                            <div class="form-group">
                                                <label for="comment">Your Comment:</label>
                                                <textarea class="form-control" name="comment_text" rows="3"></textarea>
                                                <!-- Hidden inputs for post ID and user ID -->
                                                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                            </div>
                                            <button type="submit" class="submitComment btn btn-primary">Post Comment</button>
                                        </form>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Liked Modal -->
                        <div id="likesModal-<?php echo $post['post_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="commentModalLabel">Likes</h4>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="user-likes"></ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>







                    </div>
                </div>
            <?php endforeach; ?>
            <!-- End Iterate through posts -->
        </div>


        <!-- End Comment Popup -->


        <!-- Comment Modal -->
        <div class="modal" id="commentModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="comment-container">
                    <!-- Comments will be displayed here -->
                </div>
            </div>
        </div>
        <!-- End Comment Modal -->

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/timer.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="./scripts/timer.js"></script>
        <script src="./scripts/posts.js"></script>

    </body>

    </html>
<?php
} else {
    header("Location: ../signin.php");
    exit();
}
?>
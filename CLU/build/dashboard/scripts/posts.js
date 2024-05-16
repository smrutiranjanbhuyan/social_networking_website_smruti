$(document).ready(function () {
  // Function to handle like button click
  $(".like-btn").click(function () {
    // Get post_id and user_id from hidden input fields
    var post_id = $(this).closest(".post").find("input[name='post_id']").val();
    var user_id = $(this).closest(".post").find("input[name='user_id']").val();
    // console.log("Post ID:", post_id);
    // console.log("User ID:", user_id);

    // Make AJAX POST request to handel_like.php
    $.ajax({
      url: "../server/routs/handel_like.php",
      method: "POST",
      data: {
        post_id: post_id,
        user_id: user_id,
      },
      success: function (response) {
        // console.log(response);
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      },
    });
  });

  function fetchNewPosts() {
    $.ajax({
      url: "../server/routs/fetch_posts.php",
      method: "GET",
      success: function (response) {},
      error: function (xhr, status, error) {
        console.error("Error fetching new posts:", error);
      },
    });
  }

  // Function to fetch likes on a post
  function fetchLikes() {
    $(".post").each(function () {
      var post_id = $(this)
        .closest(".post")
        .find("input[name='post_id']")
        .val();
      $.ajax({
        url: "../server/routs/likes_on_a_post.php",
        method: "GET",
        data: { post_id: post_id },
        success: function (response) {
          var likedUsers = $(this).find(".user-likes");
          likedUsers.empty(); // Clear existing comments

          $(this)
            .find(`.like-count-${post_id}`)
            .text(response.like_count + ` Likes`);
          response.liked_users.forEach(function (user) {
            likedUsers.append("<li>" + user + " Liked your post</li>");
          });
        }.bind(this), // Binding 'this' to the outer context
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        },
      });
    });
  }

  // Function to fetch comments on a post
  function fetchComments() {
    $(".post").each(function () {
      var post_id = $(this)
        .closest(".post")
        .find("input[name='post_id']")
        .val();
      $.ajax({
        url: "../server/routs/comments_on_a_post.php",
        method: "GET",
        data: { post_id: post_id },
        success: function (response) {
          // Assuming the response is an array of comments
          var commentsList = $(this).find(".post-comments");
          commentsList.empty(); // Clear existing comments
          response.forEach(function (comment) {
            commentsList.append(
              "<li>" + comment.username + " : " + comment.comment_text + "</li>"
            );
          });
        }.bind(this), // Binding 'this' to the outer context
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        },
      });
    });
  }

  $(".commentForm").submit(function(event) {
    // Prevent the default form submission
    event.preventDefault();
    
    // Get the comment text, post ID, and user ID for the specific form
    var commentText = $(this).find("textarea[name='comment_text']").val();
    var post_id = $(this).find("input[name='post_id']").val();
    var user_id = $(this).find("input[name='user_id']").val();
    
    // Make an AJAX POST request to the add_comment.php file
    $.ajax({
        url: "../server/routs/add_comment.php",
        method: "POST",
        data: {
            comment_text: commentText,
            post_id: post_id,
            user_id: user_id
        },
        success: function(response) {
            alert(response);
        },
        error: function(xhr, status, error) {
            // Display an error message if the AJAX request fails
            alert("Error: Unable to add comment.");
        }
    });
});


  // Call fetchLikes initially
  fetchLikes();
  fetchNewPosts();
  fetchComments();
  setInterval(fetchLikes, 1000);
  setInterval(fetchLikes, 1000);
  setInterval(fetchNewPosts, 2000);
});

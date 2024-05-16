$(document).ready(function(){
    function fetchNewPosts() {
        $.ajax({
            url: '../server/routs/fetch_posts.php', // Adjust the URL according to your file structure
            method: 'GET',
            success: function(response) {
            },
            error: function(xhr, status, error) {
                console.error('Error fetching new posts:', error);
            }
        });

    }

    // Call fetchNewPosts function every 2 seconds
    setInterval(fetchNewPosts, 2000);
   
})
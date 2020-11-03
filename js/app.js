
// Ajax syntax to select the form id = #commentform
$(function() {
    $('#commentform').submit(handleSubmit);
});

// When the form is posted, it is captured by Ajax
function handleSubmit() {
    console.log("HANDLESUBMIT");
    var form = $(this);
    var data = {
        "comment_author": form.find('#comment_author').val(),
        "email": form.find('#email').val(),
        "comment": form.find('#comment').val(),
        "comment_post_ID": form.find('#comment_post_ID').val()
    };

    postComment(data);

    return false;
}

// Type: Specifies the type of request. (GET or POST)
// Url: Specifies the URL to send the request to. Default is the current page
// Data: Specifies data to be sent to the server
// Headers: An object of additional header key/value pairs to send along with request.
// Success, Error: Callback functions
function postComment(data) {
    console.log("POSTCOMMENT");
    $.ajax({
       type: 'POST',
       url: '/about/post_comment.php',
       data: data,
       headers: {
         'X-Requested-With': 'XMLHttpRequest'
       },
       // X-Requested-With: To differentiate AJAX request from normal page views. When working with an Ajax-enhanced website, it's generally a good idea to provide a regular request fallback for any core functionality of the site. AJAX is kinda a plan-b?
       success: postSuccess,
       error: postError
     });
}

// data = echo from json_encode, textStatus is either 201 or 400
// XHR = XML Http Request
function postSuccess(data, textStatus, jqXHR) {
    console.log("POSTSUCCESS");
    // get() method: loads data from the server using a HTTP GET request.
    // reset(): resets the values of all elements in a form
    $('#commentform').get(0).reset();
    displayComment(data);
}

function postError(jqXHR, textStatus, errorThrown) {
    // display error
    console.log("POSTERROR");
    console.log(textStatus);
    console.log(jqXHR);
}

function displayComment(data) {
    var commentHtml = createComment(data);
    var commentEl = $(commentHtml); // Converting it from HTML into a jQuery object...?
    commentEl.hide();
    var postsList = $('#posts-list');   // Another jQuery object
    postsList.addClass('has-comments'); // Enable 'has-comments' variable
    postsList.prepend(commentEl);   // Add comment into the list <ol>
    commentEl.slideDown();  // "Show" the new comment?
}

function createComment(data) {
    var html = '' +
    '<li><article id="' + data.id + '" class="hentry">' +
    '<footer class="post-info">' +
        '<abbr class="published" title="' + data.date + '">' +
        parseDisplayDate(data.date) +
        '</abbr>' +
        '<address class="vcard author">' +
        'By <a class="url fn" href="#">' + data.comment_author + '</a>' +
        '</address>' +
    '</footer>' +
    '<div class="entry-content">' +
        '<p>' + data.comment + '</p>' +
    '</div>' +
    '</article></li>';

    return html;
}

function parseDisplayDate(date) {
    date = (date instanceof Date? date : new Date( Date.parse(date) ) );
    var display = date.getDate() + ' ' +
                ['January', 'February', 'March',
                 'April', 'May', 'June', 'July',
                 'August', 'September', 'October',
                 'November', 'December'][date.getMonth()] + ' ' +
                date.getFullYear();
    return display;
}

// To test function displayComment() by pressing 'u'
// $(function() {
//
//   $(document).keyup(function(e) {
//     e = e || window.event;
//     if(e.keyCode === 85){
//       displayComment({
//         "id": "comment_1",
//         "comment_post_ID": 1,
//         "date":"Tue, 21 Feb 2012 18:33:03 +0000",
//         "comment": "The realtime Web rocks!",
//         "comment_author": "Phil Leggetter"
//       });
//     }
//   });
//
// });

// Creating a Pusher intance connect client to Pusher
var pusher = new Pusher('94b577f129fd48f41527', {
      cluster: 'ap1'
    });

// Channels provide a great way of organizing streams of real-time data.
// Here we are subscribing to comments for the current blog post,
// uniquely identified by the value of the comment_post_ID hidden form input element.
var channel = pusher.subscribe('comments-' + $('#comment_post_ID').val());

// Event: further filter data and are ideal for linking updates to changes in the UI
channel.bind('new_comment', displayComment);

<?php
require('pusher_config.php');
require('Persistence.php');
require __DIR__ . '/vendor/autoload.php';
$comment_post_ID = 1;
$db = new Persistence();
$comments = $db->get_comments($comment_post_ID);
$has_comments = (count($comments) > 0);
?>

<!DOCTYPE html>
<html lang="en-UK">
    <head>
        <title>Y.J. Kee</title>
        <meta charset='UTF-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/img/favicon/site.webmanifest">

        <link rel="stylesheet" href="/scss/main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/js/main.js"></script>
    </head>

    <body>
        <div w3-include-html="/include/header.html"></div>
        <div class="container-fluid m-0 p-0 bg-primary">
            <div class="homepage">
                <div class="container-fluid p-0">
                    <div class="paper container-fluid">
                        <div class="container pt-3">
                            <h1 class="title">#About</h1>
                        </div>
                        <div class="container pb-3">
                            <p>
                                I am a third year undergraduate from the University of Southampton, majoring in Electronic Engineering.</br></br>

                                Apparently, the way I have immediately associated myself with my 'occupation' is a well-known phenomenon called 'Enmeshment'. It's when you are overly dependent on the identity in your work, bad things can happen when you stopped doing the same thing later. (Source: <a href="http://cukup.club/is-your-kerja-your-only-identity/" target="_blank">Is your kerja your only identity?</a>)</br></br>

                                To fix this, I'll reintroduce myself, using this website, through: </br>
                            </p>
                            <ol>
                                <li>Portfolio showcase</li>
                                <li>Blogging</li>
                            </ol>
                            </br>
                            <p>Quote of the web update:</p>
                            <p>"The evil that is in the world always comes of ignorance, and good intentions may do as much harm as malevolence, if they lack understanding. On the whole, men are more good than bad; that, however, isn't the real point. But they are more or less ignorant, and it is this that we call vice and virtue; the most incorrigible vice being that of an ignorance that fancies it knows everything and therefore claims for itself the right to kill." - The Plague</p>
                            <p>What do you think about it? In general, regardless of the context.</br>Comment it down below: [Non-existing comment section]</p>
                            <!-- https://www.smashingmagazine.com/2012/05/building-real-time-commenting-system/ -->
                            <div id="comments">
                                <ol id="posts-list" class="hfeed<?php echo($has_comments?' has-comments':''); ?>" style="list-style:none;">
                                <!-- Why add "hfeed" as a class? -->
                                    <li class="no-comments">Be the first to add a comment.</li>
                                        <?php
                                        foreach ($comments as &$comment) {
                                        ?>
                                    <li>
                                        <article id="comment_<?php echo($comment['id']); ?>" class="hentry">
                                            <footer class="post-info">
                                                <abbr class="published" title="<?php echo($comment['date']); ?>">
                                                    <?php echo( date('d F Y', strtotime($comment['date']) ) ); ?>
                                                </abbr>

                                                <address class="vcard author">
                                                    By <a class="url fn" href="#"><?php echo($comment['comment_author']); ?></a>
                                                </address>
                                            </footer>

                                            <div class="entry-content">
                                                <p>
                                                    <?php echo($comment['comment']); ?>
                                                </p>
                                            </div>
                                        </article>
                                    </li>
                                    <?php
                                    }
                                    ?>
                                </ol>
                                <div id="respond">
                                    <form action="/about/post_comment.php" method="post" id="commentform">

                                        <label for="comment_author" class="required">Displayed name:</label>
                                        <input type="text" name="comment_author" id="comment_author" value="" tabindex="1" required="required">

                                        <label for="email" class="required">Your email-address:</label>
                                        <input type="email" name="email" id="email" value="" tabindex="2" required="required">

                                        <label for="comment" class="required">Comment:</label>
                                        <textarea name="comment" id="comment" rows="5" tabindex="4"  required="required"></textarea>

                                        <input type="hidden" name="comment_post_ID" value="<?php echo($comment_post_ID); ?>" id="comment_post_ID" />
                                        <input name="submit" type="submit" value="Submit comment" />

                                    </form>
                                </div>
                            </div>
                            <form action="/about/clear.php" method="post">
                                <input name="clear" type="submit" value="Delete all comments (Test)"/>
                            </form>
                            <!-- https://www.smashingmagazine.com/2012/05/building-real-time-commenting-system/ -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div w3-include-html="/include/footer.html"></div>
        <script>includeHTML();</script>
        <!-- Optional: jQuery, Popper.js & JavaScript Plugins respectively (for Bootstrap) // Required for navbar toggler -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!-- For comment section -->
        <!-- Client-side Pusher lib -->
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="/js/app.js"></script>
        <script>
            var APP_KEY = '<?php echo(APP_KEY); ?>';
            // Need APP_KEY to connect to Pusher at runtime
        </script>
        <!-- <script>
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('94b577f129fd48f41527', {
              cluster: 'ap1'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
              alert(JSON.stringify(data));
            });
        </script> -->
    </body>
</html>

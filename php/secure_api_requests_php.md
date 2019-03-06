## Accept Requests From Specific Pages With AJAX
The example below explains how to accept API request from pages hosted on
the same server. I've taken the solution from the stack overlow link below and
broken it down further and expanded on the functions used.

Original StackOverflow Link:
https://stackoverflow.com/questions/23533003/only-accept-ajax-get-or-post-requests-from-specific-page

### Steps

+ Create a token in PHP and hash it.
+ Send the token hash through AJAX as part of the data object.
+ Check if the request was sent through AJAX on the server.
+ Create a hash of the token using the received token hash and compare.
+ If there is a match, congrats! The request has come from a verified source.
<?php

/*
  decription: accept request from specific pages

  original: https://stackoverflow.com/
  questions/23533003/only-accept-ajax-get-or-post-requests-from-specific-page
*/

/* Check if the request it sent through AJAX: */
if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
  && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {}

/* On the page that's holding the AJAX Request, create a token: */
session_start();
$hashed='';
$_SESSION['token'] = microtime();
if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    $salt = '$2y$11$' . substr(md5(uniqid(mt_rand(), true)), 0, 22);
    $hashed = crypt($_SESSION['token'], $salt);
}

// This is using the blowfish algorithm with the crypt() to create hashed string.
// Your AJAX function would be like:

$.ajax({
    type: "POST",
    url: 'page2.php',
    data: {
        action: '<?php echo $hashed;?>', //pasted the hashed string created in PHP
        q: 'test'
    },
    success: function (data) {}
});

// Upto you whether you want to use $_GET or $_POST method.
// And then on the second page which is receiving the AJAX request, you do:

session_start();
if(crypt($_SESSION['token'], $_POST['action']) == $_POST['action']){
  //Hashed string matches. Request has come from page1.
  echo $_POST['q'];
}

?>
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

### Client

#### Create a token in PHP and apply a hashing algorithm to it:

```php
session_start();
$hashed='';
$_SESSION['token'] = microtime();
if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    $salt = '$2y$11$' . substr(md5(uniqid(mt_rand(), true)), 0, 22);
    $hashed = crypt($_SESSION['token'], $salt);
}

```

#### Send the token hash through AJAX as part of the data object:

```javascript

$.ajax({
  type: "POST",
  url: 'server_page.php',
  data: {
    action: '<?= $hashed ?>', //place hashed string here
    q: 'test'
  },
  success: function (data) {}
});

```

### Server

#### Check if the request was sent through AJAX on the server:

```php
if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
  // request was sent through AJAX
}

```

#### Create a hash of the token using the received token hash and compare.

```php
session_start();
if(crypt($_SESSION['token'], $_POST['action']) == $_POST['action']){
  // Hashed string matches. Request came from client.
  echo $_POST['q'];
}

```
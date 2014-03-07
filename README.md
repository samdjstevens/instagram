#Instagram API for PHP 5.3+ [Work in progress]

A simple, framework agnostic, PHP implementation of a wrapper for the [Instagram API](http://instagram.com/developer/).

##Installation

Install the package via composer:

```json
{
	"require": {
		"spanky/instagram": "dev-master"
	}
}
``` 
and require the Composer autoloader in your PHP files:

```php
	require 'vendor/autoload.php';
```

###Laravel Installation

If you want to use this package with Laravel 4, you can make use of the included service provider and facades to take care of the bootstrapping code.

First, add the service provider to the ```providers``` array in ```app/config/app.php```:

```php
'providers' => array(
	...
	'Spanky\Instagram\Laravel\InstagramServiceProvider',
);
```

Next, publish the configuration file from the package to your project via the command line:

```
php artisan config:publish spanky/instagram
```

You should now see the config file at ```app/config/packages/spanky/instagram/config.php```, where you can enter in your details.

Once you've entered in your app details in the config file, you can now access the ```Spanky\Instagram\Factory``` class with the ```Instagram``` alias.

##Usage

###Authentication

The package follows the server side flow for authentication, [described here](http://instagram.com/developer/authentication/). To setup authentication in your app, follow these steps:

- [Register a Instagram client](http://instagram.com/developer/clients/register), making note of the credentials that are generated.

- Next, create an instance of ```Spanky\Instagram\Authorizor``` by calling the ```authorizor()``` method (passing the configuration details in, if not using Laravel) on an instance of ```Spanky\Instagram\Factory```, and call the ```getAuthorizeUrl()``` to return the Instagram 
authorization URL. Redirect your users to this URL via PHP, or other means.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$authorize_url = Instagram::authorizor($config)->getAuthorizeUrl();

header("Location:{$authorize_url}");

```

- Upon authorizing, the user will be redirected back to the URL you specified when you registered the client, along with a ```code``` parameter in the query string. You need to pass this code to the ```getAccessToken()``` method on the ```Spanky\Instagram\Authorizor``` class to retrieve the access token.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$token = Instagram::authorizor($config)->getAccessToken($_GET['code']);
```

-  Once you have this access token, you can store it (in the session, in a database, etc) and retrieve it for authenticating API requests.

```php
$_SESSION['instagram_access_token'] = $token;

header("Location:index.php");
// Redirect somewhere
```

###API Usage

Once you are in posession of an access token, you must set this on the instance of 
the ```Spanky\Instagram\Instagram``` class, before you can make any requests.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$instagram = Instagram::api();
$instagram->setAccessToken($_SESSION['instagram_access_token']);

```

###Getting the authorized user

```php
$user = $instagram->getAuthorizedUser();
// will return an instance of Spanky\Instagram\Entities\AuthorizedUser

echo $user->username; // the username of the authorized user
echo $user->profile_picture;
echo $user->mediaCount(); // the number of photos/videos the user has uploaded
```

###Getting a user by their id

```php
$user = $instagram->getUser(1010);
// will return an instance of Spanky\Instagram\Entities\User
```

### Getting the users who follow a user

```php
$followers = $user->followers();
// returns an instance of Spanky\Instagram\Collections\UserCollection

foreach($followers as $follower) 
{
	// $follower is an instance of Spanky\Instagram\Entities\User
	echo $follower->username;
}

if ($followers->hasMoreItems()) 
{
	// If the user has more followers (results are paginated)
	$next_max_id = $followers->nextPageMaxId();
	// Get the next max id for the next request

	$moreFollowers = $user->followers(array('max_id' => $next_max_id));
	// Get the next round by passing in the max id
}
```
To be continued...
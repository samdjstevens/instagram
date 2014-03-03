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

- [Register a Instagram client](http://instagram.com/developer/clients/register), and note the client info.

- FILL IN.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$authenticator = Instagram::authenticator($config);

$redirect_url = $authenticator->getAuthorizeUrl();

header("Location:{$redirect_url}");

```

- Upon authorizing, the user will be redirected back to the URL you specified when you registered the client, along with a ```code``` parameter in the query string. You need to pass this code to the ```getAccessToken(``` method on the ```Spanky\Instagram\Authenticator``` class to retrieve the access token. Once you have this access token, you can store it (in the session, in a database, etc) and retrieve it for authenticating API requests.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$authenticator = Instagram::authenticator($config);

$token = $authenticator->getAccessToken($_GET['code']);
$_SESSION['instagram_access_token'] = $token;

header("Location:index.php");
// Redirect somewhere

```

### API Usage

Once you are in posession of an access token, you must set this on the instance of the ```Spanky\Instagram\Api``` class, before you can make any requests.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$instagram = Instagram::api();
$instagram->setAccessToken($_SESSION['instagram_access_token']);

```

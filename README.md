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

##Usage


###Authentication

The package follows the server side flow for authentication, [described here](http://instagram.com/developer/authentication/). To setup authentication in your app, follow these steps:

- [Register a Instagram client](http://instagram.com/developer/clients/register), and note the client info.

- Create a new instance of ```Spanky\Instagram\Factory```, passing in the configuration array as the only parameter. Then retrieve an instance of ```Spanky\Instagram\Authenticator``` from the ```Factory``` object,  by calling ```$factory->authenticator()```. Finally, retrieve the authorization URL from the Authenticator and redirect the user.

```php
<?php

use Spanky\Instagram\Factory as Instagram;

$config = array(

	'client_id' 	=> 'YOUR_CLIENT_ID',
	'client_secret'	=> 'YOUR_CLIENT_SECRET',
	'redirect_uri'	=> 'YOUR_REDIRECT_URL'
);

$factory = new Instagram($config);

$authenticator = $factory->authenticator();

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

$factory = new Instagram($config);

$authenticator = $factory->authenticator();

$token = $authenticator->getAccessToken($_GET['code']);
$_SESSION['instagram_access_token'] = $token;
$_SESSION['instagram_user_id'] = $auth->getAuthorizedUser()->id;

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

$factory = new Instagram($config);

$instagram = $factory->api();
$instagram->setAccessToken($_SESSION['instagram_access_token']);

```

# Albion service status client

Simple http client to get service status and maintenance reports

### Installation 

`composer require ica4c/albion-status-client`

### Usage

#### How to resolve server status

```php
use Albion\Status\Client;use Albion\Status\Enums\ServerState;
$client = new Client();

$status = $client->getServiceStatus();

switch ($status->getState()) {
    case ServerState::ONLINE:
    case ServerState::STARTING:
        // Do something while service online/starting;
        break;
    
    case ServerState::FAILED:    
    case ServerState::OFFLINE:
    case ServerState::UNRESPONSIVE:
        // Do something while service offline; 
        break;
}
```

#### How to resolve client version

```php
$client = new Client();

$version = $client->getClientVersion();

echo "Android is: {$version->getAndroid()}\n";
echo "IOS is: {$version->getIOS()}\n";
echo "Windows is: {$version->getWindows()}\n";
echo "OSX is: {$version->getOSX()}\n";
echo "Linux is: {$version->getLinux()}\n";

```
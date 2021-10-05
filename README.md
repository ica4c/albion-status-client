# Albion service status client

Simple http client to get service status and maintenance reports

### Installation 

`composer require ica4c/albion-status-client`

### Usage

#### How to resolve server status

```php
use Albion\Status\Client;
use Albion\Status\Models\State;

$client = new Client();

$status = $client->getServiceStatus();

switch ($status->getState()->toString()) {
    case State::ONLINE:
    case State::STARTING:
        // Do something while service online/starting;
        break;
    
    case State::FAILED:    
    case State::OFFLINE:
    case State::UNRESPONSIVE:
        // Lets output the maintenance message 
        $maintenance = $client->getMaintenanceStatus();
        echo $maintenance->getMessage(); 
        break;
}
```

#### How to resolve active client version

```php
use Albion\Status\Client;
use Albion\Status\Models\Version;

$client = new Client();

$version = $client->getClientVersion();

echo "Android is: {$version->getAndroid()}\n";
echo "IOS is: {$version->getIOS()}\n";
echo "Windows is: {$version->getWindows()}\n";
echo "OSX is: {$version->getOSX()}\n";
echo "Linux is: {$version->getLinux()}\n";

```
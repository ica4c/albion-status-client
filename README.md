# Albion service status client

Simple http client to get service status and maintenance reports

### Installation 

`composer require ica4c/albion-status-client`

### Usage

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
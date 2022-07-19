# Barsbank
This barsbank API allows you to operate API of https://dynamic.barsbank.com/api-docs.  (Make Booking not implemented yet)


# Installation
## Composer
You should have installed composer and install from the following command.
```bash
composer require maxwkf/barsbank
```

## Running with laravel
Copy and add key to config file and add your API key to it.

Run the following command.  It will copy a config file to your /config folder
```bash
> php artisan vendor:publish --provider="Maxwkf\Barsbank\BarsbankServiceProvider" --tag="config"
```

Update the key attribute in the config file.
```php
return [
  'key' => 'your-own-key'
];
```

# How to use
## PHP without framework
```php
$apiKey = "your-api-key";
$parkId = 2; // your park id
$apiClient = new \Maxwkf\Barsbank\ApiClient(apiKey: $apiKey, parkId: $parkId);

$apiClient
    ->setDateFrom('2022-12-01')
    ->setDateTo('2022-12-31')
    ->setNumberAdults(2)
    ->getAvailability()
    ;

```

## Laravel
1. Add the API key to your config file
2. Create your own Lodge Class interface such that you can wire up other API Client later on.
```php
// /app/Services/Lodge.php
namespace App\Services;

interface Lodge {

    public function getAvailabilities();

    public function getValidStays();
    
    public function getParkAccommodation();

    public function getTourValidStays();

    public function getExtras();
}
```
3. Register Lodge class in AppServiceProvider.php and instantiate it with our API Client
```php
app()->bind(Lodge::class, function () {

    $apiClient = (new \Maxwkf\Barsbank\ApiClient(
        apiKey: config('barsbank.key'),
        parkId: 2,
    ));

    return new BarsbankLodge($apiClient);
});
```
4. Create your own class to implement the Lodge Class and inject the ApiClient to this class
```php
namespace App\Services;


use Maxwkf\Barsbank\ApiClient;


class BarsbankLodge implements Lodge {
    
    public function __construct(protected ApiClient $client) {
        
    }
    public function getAvailabilities() {
        $this->client
            ->setNumberAdults(1)
            ->setDateFrom('2022-09-26')
            ->setDateTo('2022-09-30')
            ;

        return $this->client->getAvailabilities();
    }
    public function getValidStays() {
        // your own implementation
    }

    // implement for other functions
}

```
5. Create your own controller and use the LodgeController directly from the web.php
```php
//  /routes/web.php
Route::get('/testBarsbankApi', LodgeController::class);
```

```php
// /app/Http/Controllers/LodgeController.php
namespace App\Http\Controllers;
use App\Services\Lodge;

use Illuminate\Http\Request;

class LodgeController extends Controller
{
    public function __invoke(Lodge $lodge) {// validate
        // $result = $lodge->getAvailabilities();
        

        dd($lodge->getAvailabilities());
    }
}
```


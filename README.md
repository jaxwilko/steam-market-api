# Steam Market API
This package is designed to allow you to compile a database of Steam item info.

To install via composer add:

```
"require": {
        "jaxwilko/steam-market-api": "dev-master",
},
"repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:JaxWilko/steam-market-api.git"
        }
    ],
```

to your composer.json file, then run `composer require jaxwilko/steam-market-api`

This package currently offers 3 API calls you can make to Steam.

You must at some point pass the appId to the Api class, you can do this in each request or set it globally via `Api::setAppId(xxx)`.

For the below I will be using the CS:GO appId which is 730.

### Market Listings

```
$options = ['start' => 0];

$listings = Api::request('MarketList', 730)->call($options)->response();
```

This will return a list of 100 items, you'll need to change the `start` option to cycle through the complete list of item.

Each item in the array will look like:

```
[
  "image" => "http://steamcommunity-a.akamaihd.net/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpot7HxfDhoyszJemkV4N27q4KcqPrxN7LEmyUDsJIh27-YpYmmiVDm_UFuZ2vzJYPDJlRsYw2C8lC5w-fu0Je_6ZrB1zI97TOUU9Z0"
  "name" => "AK-47 | Black Laminate (Field-Tested)"
  "price" => 12.22
  "volume" => 143
  "condition" => "Field-Tested"
]
```

### Item Sale History

```
$itemName = 'AK-47 | Black Laminate (Field-Tested)';

$sales = Api::request('SaleHistory', 730)->call(['itemName' => rawurlencode($itemName)])->response();
```

This will return the lifetime sales history for an item by date.

e.g.

```
[ 
    "sale_date" => "2016-06-16"
    "sale_price" => 2.807
    "quantity" => 4395
]
```

### Item Current Price

For some reason this call to Steam seems to be very inconsitant, but this is how you access it:

```
$itemName = 'AK-47 | Black Laminate (Field-Tested)';

Api::request('ItemPricing', 730)->call(['itemName' => rawurlencode($itemName)])->response()
```

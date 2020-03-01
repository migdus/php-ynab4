# PHP YNAB4 Database

Read and write transactions from and to a YNAB4 JSON database.

## Prerequisites
* PHP 5.4+
* composer

## Quick start

Clone repository to disk

```
git clone git@github.com:petrica/php-ynab4.git
```

Run composer install in order to create necessary libraries

```
cd php-ynab4
composer install
```

Play with the sample application

```
cd sample
php index.php
```

## Read transactions

```php
# dropbox driver
$io = new YnabDropboxIO(new Client($auth['access_token'], "MTools"));
# or
# disk driver if you want to access directly on disk the budget database
$io = new YnabDiskIO();

# path to budget folder
$pathToBudget = '/app/ynab/Test~B5C2AEE7.ynab4';
# device id as UUID Version 1, if not provided a new device will be generated
$deviceId = null;
$ynab = new YnabClient($pathToBudget, $io, $deviceId);

# fetch transactions from diff files
$ynab->pull();

# get latest transactions
$transactions = $ynab->getTransactions();

# update device knowledge based on read transactions
$ynab->commit();

# store device id for future calls
$deviceId = $ynab->getDevice()->getDeviceGUID();
```

## Write transactions

```php
# dropbox driver
$io = new YnabDropboxIO(new Client($auth['access_token'], "MTools"));
# or
# disk driver if you want to access directly on disk the budget database
$io = new YnabDiskIO();

# path to budget folder
$pathToBudget = '/app/ynab/Test~B5C2AEE7.ynab4';
# device id as UUID Version 1, if not provided a new device will be generated
$deviceId = null;
$ynab = new YnabClient($pathToBudget, $io, $deviceId);

$transaction = new YnabTransaction();
$transaction->setAccountId('UUID_ACCOUNT_TO_PUSH_TRANSACTION_TO');
$transaction->setAmount('-10.5');
$transaction->setMemo('Some memo');
$transaction->setDate(new \DateTime());

$ynab->setTransactions([
    $transaction
]);

# Create diff file for other devices to read the new transaction
$ynab->push();

# Update device knowledge based on new generated diff file
$ynab->commit();
```
## Running the app with docker
Using the project directory as the home folder build a new docker image:

```sh
docker build -t php-ynab4 .
```

Then run a container using a volume to add what you want to run and add as a param the php file you need to run. For example, here is how you run the sample php file:

```sh
docker run --rm \
  # The volume with the files you want to run
  -v "$PWD"/sample:/sample 
  php-ynab4 \
  # The path to the main php file
  "/sample/index.php"
```
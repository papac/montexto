# Montexto PHP SDK

__Montexto__ is a high quality SMS platform which enables you to integrate any of your applications with our SMS message sending and receiving system. 
The main advantage of our system is its simplicity of implementation. The SMS message may have your company name or any phone number that you own as sender name.

## Installation

Pour installer une copie de l'SDK.

```bash
composer require montexto/montexto
```

## Utilisation

```php
use Montexto\Montexto

$mon_texto = new Montexto([
    'email' => 'email', 
    'password' => 'password', 
    'sendername' => 'Sender Name'
]);

$client = $mon_texto->login();

// Vérifié si votre êtes connecter.
$client->isLogin();

// Récupération de la date d'expiration
$client->expirateDate();

// Envoyé un message simple
$response = $client->send($number, $message);

// Envoyé un message simple à plusieur numéro
$response = $client->sendMany([$number, $number], $message);

// Récupération de votre crédits
$response = $client->getCredits();

// Récupération de votre crédits consommé
$response = $client->getConsumedCredits();

// Récupération des messages envoyés
$response = $client->getSendedMessages();
```

## Test

pour lancer les tests unitaires, veuillez créer un fichier `config.php` dans le dossier `tests` et ensuite lancer le test.
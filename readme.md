# Montexto PHP SDK

[__Montexto__](https://www.montexto.pro) is a high quality SMS platform which enables you to integrate any of your applications with our SMS message sending and receiving system. The main advantage of our system is its simplicity of implementation. The SMS message may have your company name or any phone number that you own as sender name.

## Installation

Pour installer une copie de l'SDK.

```bash
composer require papac/montexto
```

## Utilisation

L'utilisation du package est rélativement simple:

```php
use Montexto\Montexto

$mon_texto = new Montexto([
    'email' => 'email',
    'password' => 'password',
    'brand' => 'Sender Name'
]);

$client = $mon_texto->login();

// Vérifié si votre êtes connecter.
$client->isLogin();
```

### Option de configuration

| paramêtre | Description |
|---------|-------------|
| __email__ | Votre email de connexion |
| __password__ | Votre mot de passe |
| __brand__ | Le nom de votre marque `MONTEXTO` par defaut c'est `MONTEXTO`  |

Aprés la connextion vous pouvez voir la date d'expiration du token

```php
// Récupération de la date d'expiration
$client->expirateDate();
```

### Envoie d'SMS

Envoyé un message simple

```php
// configuration préalable
$response = $client->send($number, $message);

$response->get('status');
```

Information de la réponse en JSON avec `response->toJson()`

```json
{
    "id": 20180805155735,
    "status": "true",
    "number": "22549625874",
    "message": "lorem ipsum demo Montexto.pro",
    "total_of_message_sent": "1",
    "sms_remaining": "1248",
    "send_type": "api"
}
```

### Envoie d'SMS à plusieur numéro

Envoyé un message simple à plusieur numéro

```php
// configuration préalable
$response = $client->sendMany([$number, $number], $message);
```

### Consultez votre Crédits

Récupération de votre crédits

```php
$credits = $client->getCredits();
// => 100 par exemple
```

Récupération de votre crédits consommé

```php
$credits = $client->getConsumedCredits();
// => 100 par exemple
```

### Liste des messages envoyés

Récupération des messages envoyés

```php
$messages = $client->getSendedMessages();

// C'est un tableau du style:
[
    [
      "id" => "APIMONTEXTO2018-08-041683125",
      "message" => "AAAAAAAAAAAA",
      "number" => "2254698745",
      "total_of_message_sent": "1",
      "status" => "1",
      "sender" => "MONTEXTO",
      "id_compte" => "6"
    ],
    [
      "id" => "APIMONTEXTO2018-08-041263125",
      "message" => "AAAAAAAAAAAA",
      "number" => "2254698745",
      "total_of_message_sent" => "1",
      "status" => "1",
      "sender" => "MONTEXTO",
      "id_compte" => "6"
    ]
];
```

```php
$response = $client->getSendedMessagesWithResponse();

$response->get('messages');

// C'est un tableau du style:
[
    [
      "id" => "APIMONTEXTO2018-08-041683125",
      "message" => "AAAAAAAAAAAA",
      "number" => "2254698745",
      "total_of_message_sent": "1",
      "status" => "1",
      "sender" => "MONTEXTO",
      "id_compte" => "6"
    ],
    [
      "id" => "APIMONTEXTO2018-08-041263125",
      "message" => "AAAAAAAAAAAA",
      "number" => "2254698745",
      "total_of_message_sent" => "1",
      "status" => "1",
      "sender" => "MONTEXTO",
      "id_compte" => "6"
    ]
];
```

### La Réponse `response`

Si vous remaquez bien dans ce que vous lisez ci-dessus, il y a c'est la variable `response`.
C'est un objet de la classe `Montexto\Response`. Elle permet de manipuler facilement de réponse du du serveur.

## Test

pour lancer les tests unitaires, veuillez créer un fichier `config.php` dans le dossier `tests` et ensuite lancer le test.

Ajoutez le code suivant dans le fichier `config.php`:

```php
return [
    'email' => 'email',
    'password' => 'password',
    'brand' => 'Sender Name',
    'numbers' => ['number1', 'number2']
];
```
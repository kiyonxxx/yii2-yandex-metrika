# Клиент Яндекс.Метрика API для Yii2

API: https://yandex.ru/dev/metrika/doc/api2/concept/about.html

## Конфигурация

```php
'components' => [
    'metrika' => dicr\yandex\metrika\MetrikaClient::class,
    'token' => 'Ваш API токен'
];
```

## Использование

### получаем клиент API

```php
use dicr\yandex\metrika\Metrika;
use dicr\yandex\metrika\MetrikaClient;
use dicr\yandex\metrika\manage\CounterListRequest;
use dicr\yandex\metrika\manage\CounterListResponse;
use dicr\yandex\metrika\manage\CounterInfoRequest;
use dicr\yandex\metrika\manage\entity\Counter;
use dicr\yandex\metrika\report\TableRequest;
use dicr\yandex\metrika\report\ReportResponse;


/** @var MetrikaClient $client */
$client = Yii::$app->get('metrika');
```

### получаем список счетчиков

```php
/** @var CounterListResponse $res */
$res = $client->createRequest([
    'class' => dicr\yandex\metrika\manage\CounterListRequest::class,
])->send();

echo 'Всего счетчиков: ' . $res->rows . "\n";
```

### получаем информацию по счетчику

```php
/** @var Counter $res */
$res = $client->createRequest([
    'class' => CounterInfoRequest::class,
    'counterId' => Metrika::TEST_COUNTER_ID
]);

echo 'Сайт счетчика: ' . $res->site2->site . "\n";
```

### получаем таблицу отчета

```php
/** @var ReportResponse $res */
$res = $client->createRequest([
    'class' => TableRequest::class,
    'ids' => [Metrika::TEST_COUNTER_ID],
    'metrics' => ['ym:s:pageviews']
]);

echo 'Количество строк в отчете: ' . $res->totalRows . "\n";
```

API управления реализовано не пользовать - только работы со счетчиками.

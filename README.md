# Клиент Яндекс.Метрика API для Yii2

API: https://yandex.ru/dev/metrika/doc/api2/concept/about.html

## Конфигурация

```php
$config = [
    'components' => [
        'metrika' => dicr\yandex\metrika\MetrikaClient::class,
        'token' => 'Ваш Oauth API токен'
    ]
];
```

## Использование

### Получаем список счетчиков

```php
/** @var dicr\yandex\metrika\MetrikaClient $client */
$client = Yii::$app->get('metrika');

/** @var dicr\yandex\metrika\manage\CounterListResponse $res */
$res = $client->createRequest([
    'class' => dicr\yandex\metrika\manage\CounterListRequest::class,
])->send();

echo 'Всего счетчиков: ' . $res->rows . "\n";
```

### Получаем информацию по счетчику

```php
/** @var dicr\yandex\metrika\MetrikaClient $client */
$client = Yii::$app->get('metrika');

/** @var dicr\yandex\metrika\manage\entity\Counter $res */
$res = $client->createRequest([
    'class' => dicr\yandex\metrika\manage\CounterInfoRequest::class,
    'counterId' => dicr\yandex\metrika\Metrika::TEST_COUNTER_ID
])->send();

echo 'Сайт счетчика: ' . $res->site2->site . "\n";
```

### Получаем таблицу отчета

```php
/** @var dicr\yandex\metrika\MetrikaClient $client */
$client = Yii::$app->get('metrika');

/** @var dicr\yandex\metrika\report\ReportResponse $res */
$res = $client->createRequest([
    'class' => TableRequest::class,
    'ids' => [Metrika::TEST_COUNTER_ID],
    'metrics' => ['ym:s:pageviews']
])->send();

echo 'Количество строк в отчете: ' . $res->totalRows . "\n";
```

API управления реализовано не полностью - только получение информации для отчетов.

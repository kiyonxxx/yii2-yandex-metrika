<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 22:47:24
 */

/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types = 1);

/** string */
define('YII_ENV', 'dev');

/** bool */
define('YII_DEBUG', true);

require_once(dirname(__DIR__) . '/vendor/autoload.php');
require_once(dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php');

/** @noinspection SpellCheckingInspection */
new yii\console\Application([
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'components' => [
        'cache' => [
            'class' => yii\caching\FileCache::class
        ],
        'log' => [
            'targets' => [
                'file' => [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info', 'trace']
                ]
            ]
        ],
        'urlManager' => [
            'hostInfo' => 'https://dicr.org'
        ],
        'metrika' => [
            'class' => dicr\yandex\metrika\MetrikaClient::class,
            'token' => 'AQAAAAAK2j0dAAJ6e-ThPTOkrEJYv6IYipC6Bz8'

        ]
    ],
    'bootstrap' => ['log']
]);

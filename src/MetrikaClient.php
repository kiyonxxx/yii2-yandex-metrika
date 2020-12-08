<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 09.12.20 00:11:42
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

use dicr\http\CachingClient;
use dicr\http\HttpCompressionBehavior;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

/**
 * Клиент Яндекс.Метрика.
 *
 * @property-read Client $httpClient
 * @link https://yandex.ru/dev/metrika/doc/api2/concept/about.html/
 */
class MetrikaClient extends Component
{
    /** @var string базовый URL API по-умолчанию */
    public const URL_API = 'https://api-metrika.yandex.net';

    /** @var string токен доступа */
    public $token;

    /** @var array конфиг HTTP-клиента */
    public $httpClientConfig;

    /**
     * Создание запроса к метрике.
     *
     * @param array $config конфиг запроса, включая 'class'
     * @return AbstractRequest
     * @throws InvalidConfigException
     */
    public function createRequest(array $config) : AbstractRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject($config, [$this]);
    }

    /** @var Client */
    private $_httpClient;

    /**
     * HTTP-клиент.
     *
     * @return Client
     * @throws InvalidConfigException
     */
    public function getHttpClient() : Client
    {
        if ($this->_httpClient === null) {
            $this->_httpClient = Yii::createObject(array_merge([
                'class' => CachingClient::class,
                'baseUrl' => self::URL_API,
                'cacheDuration' => 86400,
                'as compression' => [
                    'class' => HttpCompressionBehavior::class
                ]
            ], $this->httpClientConfig ?: []));
        }

        return $this->_httpClient;
    }
}

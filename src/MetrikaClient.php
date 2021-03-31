<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 21:40:38
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

use dicr\http\CachingClient;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

use function array_merge;
use function is_array;

use const CURLOPT_ENCODING;

/**
 * Клиент Яндекс.Метрика.
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/concept/about.html/
 */
class MetrikaClient extends Component
{
    /** @var string базовый URL API по-умолчанию */
    public const URL_API = 'https://api-metrika.yandex.net';

    /** @var string токен доступа */
    public $token;

    /** @var Client */
    public $httpClient;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        if (empty($this->httpClient) || is_array($this->httpClient)) {
            $this->httpClient = array_merge([
                'class' => CachingClient::class,
                'transport' => CurlTransport::class,
                'baseUrl' => self::URL_API,
                'cacheDuration' => 86400,
                'requestConfig' => [
                    'format' => Client::FORMAT_JSON,
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'options' => [
                        CURLOPT_ENCODING => ''
                    ]
                ],
                'responseConfig' => [
                    'format' => Client::FORMAT_JSON
                ]
            ], $this->httpClient ?: []);
        }

        $this->httpClient = Instance::ensure($this->httpClient, Client::class);
    }

    /**
     * Создание запроса к метрике.
     *
     * @param array $config конфиг запроса, включая 'class'
     * @return AbstractRequest
     * @throws InvalidConfigException
     */
    public function createRequest(array $config): AbstractRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject($config, [$this]);
    }
}

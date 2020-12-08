<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 20:31:59
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

use dicr\validate\ValidateException;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Request;

/**
 * Абстрактный запрос к API.
 */
abstract class AbstractRequest extends Entity
{
    /** @var string формат JSON */
    public const FORMAT_JSON = 'json';

    /** @var string формат CSV */
    public const FORMAT_CSV = 'csv';

    /** @var MetrikaClient */
    protected $client;

    /**
     * AbstractRequest constructor.
     *
     * @param MetrikaClient $client
     * @param array $config
     */
    public function __construct(MetrikaClient $client, array $config = [])
    {
        $this->client = $client;

        parent::__construct($config);
    }

    /**
     * HTTP-заголовки.
     *
     * @return string[]
     */
    protected function headers() : array
    {
        return [
            'Authorization' => 'OAuth ' . $this->client->token,
            'Content-Type' => 'application/x-yametrika+json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Запрос.
     *
     * @return Request
     * @throws InvalidConfigException
     */
    abstract protected function httpRequest() : Request;

    /**
     * Отправка запроса.
     *
     * @return array (переопределяется в наследнике)
     * @throws Exception
     * @noinspection PhpMissingReturnTypeInspection, ReturnTypeCanBeDeclaredInspection
     */
    public function send()
    {
        if (! $this->validate()) {
            throw new ValidateException($this);
        }

        $request = $this->httpRequest();

        Yii::debug('Запрос: ' . $request->toString(), __METHOD__);
        $response = $request->send();
        Yii::debug('Ответ: ' . $response->toString(), __METHOD__);

        if (! $response->isOk) {
            throw new Exception('HTTP-ошибка: ' . $response->statusCode);
        }

        $response->format = Client::FORMAT_JSON;

        return $response->data;
    }
}


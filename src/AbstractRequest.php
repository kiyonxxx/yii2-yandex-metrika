<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 21:22:12
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

use dicr\helper\Log;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Request;

/**
 * Абстрактный запрос к API.
 */
abstract class AbstractRequest extends Entity
{
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
     * Запрос.
     *
     * @return Request
     * @throws Exception
     */
    abstract protected function httpRequest(): Request;

    /**
     * Отправка запроса.
     *
     * @return array (переопределяется в наследнике)
     * @throws Exception
     * @noinspection PhpMissingReturnTypeInspection, ReturnTypeCanBeDeclaredInspection
     */
    public function send()
    {
        // создаем запрос
        $request = $this->httpRequest();

        // добавляем токен
        if (empty($this->client->token)) {
            throw new InvalidConfigException('Не задан token доступа');
        }

        $request->headers->set('Authorization', 'OAuth ' . $this->client->token);

        Log::debug('Запрос: ' . $request->toString(), __METHOD__);
        $response = $request->send();

        Log::debug('Ответ: ' . $response->toString(), __METHOD__);
        if (! $response->isOk) {
            throw new Exception('HTTP-ошибка: ' . $response->statusCode);
        }

        $response->format = Client::FORMAT_JSON;

        return $response->data;
    }
}


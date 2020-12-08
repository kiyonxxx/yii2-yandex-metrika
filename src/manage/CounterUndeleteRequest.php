<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 14:34:20
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\yandex\metrika\AbstractRequest;
use yii\base\Exception;
use yii\httpclient\Request;

/**
 * Восстановление счетчика
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/undeletecounter.html
 */
class CounterUndeleteRequest extends AbstractRequest
{
    /** @var int */
    public $counterId;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['counterId', 'required'],
            ['counterId', 'integer', 'min' => 1],
            ['counterId', 'filter', 'filter' => 'intval']
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function httpRequest() : Request
    {
        return $this->client->httpClient
            ->post('/management/v1/counter/' . $this->counterId . '/undelete', null, $this->headers());
    }

    /**
     * @inheritDoc
     */
    public function send() : void
    {
        $data = parent::send();

        if (! $data['success']) {
            throw new Exception('Операция восстановления не успешна');
        }
    }
}

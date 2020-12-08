<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:16:04
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\AbstractRequest;
use dicr\yandex\metrika\manage\entity\Counter;
use yii\base\Exception;
use yii\httpclient\Request;

/**
 * Информация о счетчике
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/counter.html/
 */
class CounterInfoRequest extends AbstractRequest
{
    /** @var int номер счетчика */
    public $counterId;

    /**
     * @var string[]|null Один или несколько дополнительных параметров возвращаемого объекта.
     * Названия дополнительных параметров указываются в любом порядке через запятую, без пробелов.
     * Например: field=goals,mirrors,grants,filters,operation.
     */
    public $field;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['counterId', 'required'],
            ['counterId', 'integer', 'min' => 1],
            ['counterId', 'filter', 'filter' => 'intval'],

            ['field', 'default'],
            ['field', StringsValidator::class]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function httpRequest() : Request
    {
        $url = ['/management/v1/counter/' . $this->counterId];

        if (! empty($this->field)) {
            $url['field'] = implode(',', (array)$this->field);
        }

        return $this->client->httpClient
            ->get($url, null, $this->headers());
    }

    /**
     * @inheritDoc
     */
    public function send() : Counter
    {
        $data = parent::send();
        if (empty($data['counter'])) {
            throw new Exception('Не найдены данные в ответе');
        }

        return new Counter([
            'json' => $data['counter']
        ]);
    }
}

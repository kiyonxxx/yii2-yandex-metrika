<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 12:54:36
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\json\EntityValidator;
use dicr\validate\StringsValidator;
use dicr\yandex\metrika\AbstractRequest;
use dicr\yandex\metrika\manage\entity\Counter;
use yii\httpclient\Request;

/**
 * Создание счетчика
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/addcounter.html
 */
class CounterCreateRequest extends AbstractRequest
{
    /**
     * @var string[] Один или несколько дополнительных параметров возвращаемого объекта.
     * Названия дополнительных параметров указываются в любом порядке через запятую, без пробелов.
     */
    public $field;

    /** @var Counter параметры создаваемго счетчика */
    public $counter;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'counter' => Counter::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['field', 'default'],
            ['field', StringsValidator::class],

            ['counter', 'required'],
            ['counter', EntityValidator::class]
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson() : array
    {
        return [
            'field' => static function ($val) : ?string {
                return empty($val) ? null : implode(',', (array)$val);
            }
        ];
    }

    /**
     * @inheritDoc
     */
    protected function httpRequest() : Request
    {
        $data = $this->json;

        $url = ['/management/v1/counters'];
        if (! empty($data['field'])) {
            $url['field'] = $data['field'];
        }

        return $this->client->httpClient->post($url, [
            'counter' => $data['counter']
        ], $this->headers());
    }

    /**
     * @inheritDoc
     */
    public function send() : Counter
    {
        $data = parent::send();

        return new Counter([
            'json' => $data['counter']
        ]);
    }
}

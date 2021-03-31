<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 20:14:07
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\json\EntityValidator;
use dicr\validate\StringsValidator;
use dicr\validate\ValidateException;
use dicr\yandex\metrika\AbstractRequest;
use dicr\yandex\metrika\manage\entity\Counter;
use dicr\yandex\metrika\manage\entity\CounterUpdate;
use yii\httpclient\Request;

use function array_merge;

/**
 * Изменение счетчика.
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/editcounter.html
 */
class CounterUpdateRequest extends AbstractRequest
{
    /** @var int */
    public $counterId;

    /**
     * @var string[]|null Один или несколько дополнительных параметров возвращаемого объекта.
     * Названия дополнительных параметров указываются в любом порядке через запятую, без пробелов.
     */
    public $field;

    /** @var CounterUpdate параметры создаваемого счетчика */
    public $counter;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'counter' => CounterUpdate::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['counterId', 'required'],
            ['counterId', 'integer', 'min' => 1],
            ['counterId', 'filter', 'filter' => 'intval'],

            ['field', 'default'],
            ['field', StringsValidator::class],

            ['counter', 'required'],
            ['counter', EntityValidator::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function httpRequest(): Request
    {
        if (! $this->validate()) {
            throw new ValidateException($this);
        }

        $url = ['/management/v1/counter/' . $this->counterId];
        if (! empty($this->field)) {
            $url['field'] = self::formatArray($this->field);
        }

        return $this->client->httpClient->put($url, [
            'counter' => $this->counter->json
        ]);
    }

    /**
     * @inheritDoc
     */
    public function send(): Counter
    {
        $data = parent::send();

        return new Counter([
            'json' => $data['counter']
        ]);
    }
}

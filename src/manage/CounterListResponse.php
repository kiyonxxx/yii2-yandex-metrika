<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.12.20 02:42:57
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\json\EntityValidator;
use dicr\json\JsonEntity;
use dicr\yandex\metrika\manage\entity\Counter;

/**
 * Ответ на CounterListRequest
 */
class CounterListResponse extends JsonEntity
{
    /** @var int общее количество данных */
    public $rows;

    /** @var Counter[] порция данных счетчиков */
    public $counters;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'counters' => [Counter::class]
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['counters', EntityValidator::class]
        ];
    }
}

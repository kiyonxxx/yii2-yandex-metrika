<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 14:36:54
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\json\EntityValidator;
use dicr\yandex\metrika\AbstractResponse;
use dicr\yandex\metrika\manage\entity\Counter;

/**
 * Ответ на CounterListRequest
 */
class CounterListResponse extends AbstractResponse
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
        return array_merge(parent::attributeEntities(), [
            'counters' => [Counter::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['rows', 'required'],
            ['rows', 'integer', 'min' => 0],
            ['rows', 'filter', 'filter' => 'intval'],

            ['counters', 'required'],
            ['counters', EntityValidator::class]
        ]);
    }
}

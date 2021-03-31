<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 20:11:36
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

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
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'counters' => [Counter::class]
        ]);
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:16:56
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

/**
 * Данные для обновления счетчика.
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/editcounter.html
 */
class CounterUpdate extends Entity
{
    /**
     * @var bool Нужно ли удалить зеркала
     * Игнорировать входящий параметр mirrors (если указан), а также удалить для счетчика ранее заданные зеркала сайта.
     */
    public $mirrorsRemove;

    /**
     * @var bool Нужно ли удалить цели
     * игнорировать входящий параметр goals (если указан), а также удалить для счетчика ранее заданные цели.
     */
    public $goalsRemove;

    /**
     * @var bool Нужно ли удалить фильтры
     * игнорировать входящий параметр filters (если указан), а также удалить ранее заданные фильтры счетчика.
     */
    public $filtersRemove;

    /**
     * @var bool Нужно ли удалить операции
     * игнорировать входящий параметр operations (если указан), а также удалить ранее заданные операции счетчика.
     */
    public $operationsRemove;

    /**
     * @var bool Нужно ли удалить настройки доступа
     * игнорировать входящий параметр grants (если указан), а также удалить для счетчика ранее заданные настройки
     *     доступа.
     */
    public $grantsRemove;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            [['mirrorsRemove', 'goalsRemove', 'filtersRemove', 'operationsRemove', 'grantsRemove'], 'default'],
            [['mirrorsRemove', 'goalsRemove', 'filtersRemove', 'operationsRemove', 'grantsRemove'], 'boolean'],
            [['mirrorsRemove', 'goalsRemove', 'filtersRemove', 'operationsRemove', 'grantsRemove'], 'filter',
                'filter' => 'intval', 'skipOnEmpty' => true]
        ]);
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.12.20 02:21:28
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\EntityValidator;
use dicr\json\JsonEntity;

/**
 * Тип для описания цели
 */
class Goal extends JsonEntity
{
    /** @var string посещение страниц */
    public const TYPE_URL = 'url';

    /** @var string количество просмотров */
    public const TYPE_NUMBER = 'number';

    /** @var string составная цель */
    public const TYPE_STEP = 'step';

    /** @var string JavaScript-событие */
    public const TYPE_ACTION = 'action';

    /** @var string[] */
    public const TYPES = [
        self::TYPE_URL, self::TYPE_NUMBER, self::TYPE_STEP, self::TYPE_ACTION
    ];

    /** @var string «корзина», страница посещения корзины */
    public const FLAG_BASKET = 'basket';

    /** @var string «заказ», страница подтверждения заказа */
    public const FLAG_ORDER = 'order';

    /** @var string[] */
    public const FLAGS = [
        self::FLAG_BASKET, self::FLAG_ORDER
    ];

    /** @var int Идентификатор цели. Укажите данный параметр при изменении и удалении цели счетчика. */
    public $id;

    /** @var string Наименование цели */
    public $name;

    /** @var string Тип цели (TYPE_*) */
    public $type;

    /** @var bool Является ли цель ретаргетинговой */
    public $isRetargeting;

    /** @var string Тип цели для клиентов Яндекс.Маркета. */
    public $flag;

    /** @var GoalCondition[] Список структур с условиями цели */
    public $conditions;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'conditions' => [GoalCondition::class]
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['conditions', EntityValidator::class, 'class' => [GoalCondition::class]]
        ];
    }
}

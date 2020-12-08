<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:26:07
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Условие цели.
 */
class GoalCondition extends Entity
{
    /** @var string содержит */
    public const TYPE_CONTAIN = 'contain';

    /** @var string совпадает */
    public const TYPE_EXACT = 'exact';

    /** @var string начинается с */
    public const TYPE_START = 'start';

    /** @var string удовлетворяет регулярному выражению */
    public const TYPE_REGEXP = 'regexp';

    /** @var string специальный тип условия для целей типа action */
    public const TYPE_ACTION = 'action';

    /** @var string[] */
    public const TYPES = [
        self::TYPE_CONTAIN, self::TYPE_EXACT, self::TYPE_START, self::TYPE_REGEXP, self::TYPE_ACTION
    ];

    /** @var string Тип условия */
    public $type;

    /** @var string Адрес страницы или части страницы для условия */
    public $url;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['type', 'required'],
            ['type', 'in', 'range' => self::TYPES],

            ['url', 'required'],
            ['url', 'string']
        ]);
    }
}

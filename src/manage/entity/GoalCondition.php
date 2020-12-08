<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.12.20 02:19:42
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Условие цели.
 */
class GoalCondition extends JsonEntity
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
}

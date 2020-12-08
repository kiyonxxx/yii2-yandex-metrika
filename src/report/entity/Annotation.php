<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:16:08
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Примечание.
 */
class Annotation extends Entity
{
    /** @var string группа A */
    public const GROUP_A = 'A';

    /** @var string группа B */
    public const GROUP_B = 'B';

    /** @var string группа C */
    public const GROUP_C = 'C';

    /** @var string группа D */
    public const GROUP_D = 'D';

    /** @var string группа E */
    public const GROUP_E = 'E';

    /** @var string группа результаты проверки сайта на доступность. */
    public const GROUP_MONITORING = 'MONITORING';

    /** @var string группа государственные праздники. Отображаются, если Яндекс.Метрике удалось определить регион счетчика. */
    public const GROUP_HOLIDAY = 'HOLIDAY';

    /** @var string[] */
    public const GROUPS = [
        self::GROUP_A, self::GROUP_B, self::GROUP_C, self::GROUP_D, self::GROUP_E,
        self::GROUP_MONITORING, self::GROUP_HOLIDAY
    ];

    /** @var int Идентификатор примечания */
    public $id;

    /** @var string Дата */
    public $date;

    /** @var string Время */
    public $time;

    /** @var string Заголовок */
    public $title;

    /** @var string Описание */
    public $message;

    /** @var string Группа (GROUP_*) */
    public $group;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['id', 'default'],
            ['id', 'integer', 'min' => 1],
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['date', 'default'],
            ['date', 'date', 'format' => 'php:Y-m-d'],

            ['time', 'default'],
            ['time', 'time', 'format' => 'php:H:i:s'],

            [['title', 'message'], 'default'],
            [['title', 'message'], 'string'],

            ['group', 'default'],
            ['group', 'in', 'range' => self::GROUPS]
        ]);
    }
}

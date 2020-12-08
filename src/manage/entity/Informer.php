<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:20:55
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Информер счетчика.
 */
class Informer extends JsonEntity
{
    /** @var string простой */
    public const TYPE_SIMPLE = 'simple';

    /** @var string расширенный */
    public const TYPE_EXT = 'ext';

    /** @var string[] */
    public const TYPES = [
        self::TYPE_SIMPLE, self::TYPE_EXT
    ];

    /** @var int 80х15 */
    public const SIZE_80x15 = 1;

    /** @var int 80x31 */
    public const SIZE_80x31 = 2;

    /** @var int 88х31 (по-умолчанию) На вид информера этого типа не влияет значение поля indicator. */
    public const SIZE_88x31 = 3;

    /** @var int[] */
    public const SIZES = [
        self::SIZE_80x15, self::SIZE_80x31, self::SIZE_88x31
    ];

    /** @var string просмотры (по умолчанию) */
    public const INDICATOR_PAGEVIEWS = 'pageviews';

    /** @var string визиты */
    public const INDICATOR_VISITS = 'visits';

    /** @var string посетители */
    public const INDICATOR_UNIQUES = 'uniques';

    /** @var string[] */
    public const INDICATORS = [
        self::INDICATOR_PAGEVIEWS, self::INDICATOR_VISITS, self::INDICATOR_UNIQUES
    ];

    /** @var int черный */
    public const COLOR_BLACK = 0;

    /** @var int белый */
    public const COLOR_WHITE = 1;

    /** @var int[] */
    public const COLORS = [
        self::COLOR_BLACK, self::COLOR_WHITE
    ];

    /** @var bool Разрешение отображения информера */
    public $enabled;

    /** @var string Тип информера (TYPE_*) */
    public $type;

    /** @var int Размер информера. (SIZE_*) */
    public $size;

    /** @var string Показатель, который будет отображаться на информере (INDICATOR_*) */
    public $indicator;

    /**
     * @var string Начальный (верхний) цвет информера в формате RRGGBBAA.
     * RR, GG, BB ― насыщенность красного, зеленого и синего цвета.
     * Насыщенность каждого цвета задается значениями в диапазоне от 00 до FF.
     * AA ― прозрачность от 00 (прозрачный) до FF (непрозрачный).
     */
    public $colorStart;

    /**
     * @var string Конечный (нижний) цвет информера в формате RRGGBBAA.
     * Параметр предназначен для создания градиента фона.
     * Насыщенность и прозрачность цвета задаются аналогично параметру color_start.
     */
    public $colorEnd;

    /** @var int Цвет текста на информере. (COLOR_*) */
    public $colorText;

    /** @var int Цвет стрелки на информере. (COLOR_*) */
    public $colorArrow;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['enabled', 'default'],
            ['enabled', 'boolean'],
            ['enabled', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['type', 'default'],
            ['type', 'in', 'range' => self::TYPES],

            ['size', 'default'],
            ['size', 'in', 'range' => self::SIZES],

            ['indicator', 'default'],
            ['indicator', 'in', 'range' => self::INDICATORS],

            [['colorStart', 'colorEnd'], 'default'],
            [['colorStart', 'colorEnd'], 'string', 'length' => 8],

            [['colorText', 'colorArrow'], 'default'],
            [['colorText', 'colorArrow'], 'in', 'range' => self::COLORS]
        ];
    }
}

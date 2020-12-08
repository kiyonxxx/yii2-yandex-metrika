<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:50:24
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Настройки webvisor счетчика.
 */
class Webvisor extends JsonEntity
{
    /** @var string выключено */
    public const ARCH_TYPE_NONE = 'none';

    /** @var string загружать с сайта */
    public const ARCH_TYPE_LOAD = 'load';

    /** @var string из браузера */
    public const ARCH_TYPE_HTML = 'html';

    /** @var string[] */
    public const ARCH_TYPES = [
        self::ARCH_TYPE_NONE, self::ARCH_TYPE_LOAD, self::ARCH_TYPE_HTML
    ];

    /** @var string от имени анонимного пользователя */
    public const LOAD_TYPE_PROXY = 'proxy';

    /** @var string от вашего имени */
    public const LOAD_TYPE_YOUR = 'on_your_behalf';

    /** @var string[] */
    public const LOAD_TYPES = [
        self::LOAD_TYPE_PROXY, self::LOAD_TYPE_YOUR
    ];

    /** @var string Список страниц для сохранения. (regexp:.*) */
    public $urls;

    /** @var bool Сохранение страниц сайта */
    public $archEnabled;

    /** @var string Запись содержимого страниц (ARCH_TYPE_*) */
    public $archType;

    /** @var string Загрузка страниц в плеер (LOAD_TYPE_*) */
    public $loadPlayerType;

    /** @var int Версия вебвизора */
    public $wvVersion;

    /** @var bool Запись содержимого полей и форм. */
    public $wvForms;

    /* Недокументированные из JSON-ответов */

    /** @var bool */
    public $allowWv2;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['urls', 'default'],
            ['urls', 'string'],

            ['archEnabled', 'default'],
            ['archEnabled', 'boolean'],
            ['archEnabled', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['archType', 'default'],
            ['archType', 'in', 'range' => self::ARCH_TYPES],

            ['loadPlayerType', 'default'],
            ['loadPlayerType', 'in', 'range' => self::LOAD_TYPES],

            ['wvVersion', 'default'],
            ['wvVersion', 'integer', 'min' => 1],
            ['wvVersion', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            [['wvForms', 'allowWv2'], 'default'],
            [['wvForms', 'allowWv2'], 'boolean'],
            [['wvForms', 'allowWv2'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
        ];
    }
}

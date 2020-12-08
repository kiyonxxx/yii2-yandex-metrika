<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:35:37
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Фильтр счетчика.
 */
class Filter extends JsonEntity
{
    /** @var string заголовок страницы */
    public const ATTR_TITLE = 'title';

    /** @var string IP-адрес */
    public const ATTR_CLIENT_IP = 'client_ip';

    /** @var string URL страницы */
    public const ATTR_URL = 'url';

    /** @var string реферер */
    public const ATTR_REFERER = 'referer';

    /** @var string специальный атрибут для фильтра «не учитывать мои визиты». */
    public const ATTR_UNIQ_ID = 'uniq_id';

    /** @var string[] аттрибуты фильтра */
    public const ATTRS = [
        self::ATTR_TITLE, self::ATTR_CLIENT_IP, self::ATTR_URL, self::ATTR_REFERER, self::ATTR_UNIQ_ID
    ];

    /** @var string оставить только трафик */
    public const ACTION_INCLUDE = 'include';

    /** @var string исключить трафик */
    public const ACTION_EXCLUDE = 'exclude';

    /** @var string[] */
    public const ACTIONS = [
        self::ACTION_INCLUDE, self::ACTION_EXCLUDE
    ];

    /** @var string фильтр используется */
    public const STATUS_ACTIVE = 'active';

    /** @var string фильтр отключен (без удаления) */
    public const STATUS_DISABLED = 'disabled';

    /** @var string[] */
    public const STATUSES = [
        self::STATUS_ACTIVE, self::STATUS_DISABLED
    ];

    /** @var int Идентификатор фильтра */
    public $id;

    /** @var string Тип данных, к которым применяется фильтр. (ATTR_*) */
    public $attr;

    /** @var string значение фильтра */
    public $value;

    /** @var string Тип фильтра */
    public $action;

    /** @var string Статус фильтра */
    public $status;

    /** @var string первый IP-адрес диапазона */
    public $startIp;

    /** @var string последний IP_адрес диапазона */
    public $endIp;

    /** @var bool Фильтровать по поддоменам */
    public $withSubdomains;
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:27:44
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Операция счетчика.
 */
class Operation extends Entity
{
    /** @var string вырезать якорь из URL */
    public const ACTION_CUT_FRAGMENT = 'cut_fragment';

    /** @var string вырезать определенный параметр из URL */
    public const ACTION_CUT_PARAMETER = 'cut_parameter';

    /** @var string вырезать все параметры из URL */
    public const ACTION_CUT_ALL_PARAMETERS = 'cut_all_parameters';

    /** @var string заменить https:// на http:// */
    public const ACTION_MERGE_HTTPS_AND_HTTP = 'merge_https_and_http';

    /** @var string привести к нижнему регистру */
    public const ACTION_TO_LOWER = 'to_lower';

    /** @var string заменить домен */
    public const ACTION_REPLACE_DOMAIN = 'replace_domain';

    /** @var string[] */
    public const ACTIONS = [
        self::ACTION_CUT_FRAGMENT, self::ACTION_CUT_PARAMETER, self::ACTION_CUT_ALL_PARAMETERS,
        self::ACTION_MERGE_HTTPS_AND_HTTP, self::ACTION_TO_LOWER, self::ACTION_REPLACE_DOMAIN
    ];

    /** @var string URL страницы */
    public const ATTR_URL = 'url';

    /** @var string реферер */
    public const ATTR_REFERER = 'referer';

    /** @var string[] */
    public const ATTRS = [
        self::ATTR_URL, self::ATTR_REFERER
    ];

    /** @var string операция используется */
    public const STATUS_ACTIVE = 'active';

    /** @var string операция отключена (без удаления) */
    public const STATUS_DISABLED = 'disabled';

    /** @var string[] */
    public const STATUSES = [
        self::STATUS_ACTIVE, self::STATUS_DISABLED
    ];

    /** @var int Идентификатор операции */
    public $id;

    /** @var string Тип операции. (ACTION_*) */
    public $action;

    /** @var string Поле для фильтрации (ATTR_*) */
    public $attr;

    /** @var string Значение для замены. */
    public $value;

    /** @var string Статус операции. (STATUS_*) */
    public $status;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['id', 'default'],
            ['id', 'integer', 'min' => 1],
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['action', 'required'],
            ['action', 'in', 'range' => self::ACTIONS],

            ['attr', 'required'],
            ['attr', 'in', 'range' => self::ATTRS],

            ['value', 'required'],
            ['value', 'string'],

            ['status', 'default'],
            ['status', 'in', 'range' => self::STATUSES]
        ]);
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:18:02
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Права доступа к счетчику.
 */
class Grant extends JsonEntity
{
    /** @var string публичный доступ к статистике */
    public const PERM_PUBLIC_STAT = 'public_stat';

    /** @var string только просмотр */
    public const PERM_VIEW = 'view';

    /** @var string полный доступ */
    public const PERM_EDIT = 'edit';

    /** @var string[] */
    public const PERMS = [
        self::PERM_PUBLIC_STAT, self::PERM_VIEW, self::PERM_EDIT
    ];

    /**
     * @var ?string Логин пользователя, которому выдано разрешение на управление счетчиком.
     * Параметр содержит пустую строку, если к статистике счетчика предоставлен публичный доступ (perm = public_stat)
     */
    public $userLogin;

    /**
     * @var ?int uid пользователя, которому выдано разрешение на управление счетчиком.
     * Параметр содержит 0, если к статистике счетчика предоставлен публичный доступ (perm = public_stat)
     */
    public $userUid;

    /** @var string Уровень доступа. (PERM_*) */
    public $perm;

    /**
     * @var string Дата предоставления доступа в формате YYYY-MM-DD'T'hh:mm:ssZ
     * @noinspection SpellCheckingInspection
     */
    public $createdAt;

    /** @var ?string Произвольный комментарий. Количество символов не должно превышать 255. */
    public $comment;

    /**
     * @var bool Доступ к группе отчетов «Монетизация».
     * Пользователь сможет просматривать отчеты, добавлять группировки и метрики из группы «Монетизация» в другие
     * отчеты. Если у пользователя есть доступ на редактирование, то ему уже доступны отчеты группы «Монетизация».
     */
    public $partnerDataAccess;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['userLogin', 'default'],
            ['userLogin', 'string'],

            ['userUid', 'default'],
            ['userUid', 'integer', 'min' => 1],
            ['userUid', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['perm', 'required'],
            ['perm', 'in', 'range' => self::PERMS],

            ['createdAt', 'default'],
            ['createdAt', 'date', 'format' => 'php:c'],

            ['comment', 'trim'],
            ['comment', 'default'],

            ['partnerDataAccess', 'default'],
            ['partnerDataAccess', 'boolean'],
            ['partnerDataAccess', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true]
        ];
    }
}

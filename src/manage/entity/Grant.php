<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.12.20 00:36:04
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

    /** @var string Дата предоставления доступа в формате YYYY-MM-DD'T'hh:mm:ssZ */
    public $createdAt;

    /** @var ?string Произвольный комментарий. Количество символов не должно превышать 255. */
    public $comment;

    /**
     * @var bool Доступ к группе отчетов «Монетизация».
     * Пользователь сможет просматривать отчеты, добавлять группировки и метрики из группы «Монетизация» в другие
     * отчеты. Если у пользователя есть доступ на редактирование, то ему уже доступны отчеты группы «Монетизация».
     */
    public $partnerDataAccess;
}

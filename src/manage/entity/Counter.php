<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:35:37
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\EntityValidator;
use dicr\json\JsonEntity;

/**
 * Счетчик метрики
 */
class Counter extends JsonEntity
{
    /** @var string Счетчик активен */
    public const STATUS_ACTIVE = 'Active';

    /** @var string Счетчик удален */
    public const STATUS_DELETED = 'Deleted';

    /** @var string[] */
    public const STATUSES = [
        self::STATUS_ACTIVE, self::STATUS_DELETED
    ];

    /** @var string Не удалось проверить (ошибка соединения). */
    public const CODE_STATUS_CONNECT = 'CS_ERR_CONNECT';

    /** @var string Установлен другой счетчик. */
    public const CODE_STATUS_OTHER = 'CS_ERR_OTHER_HTML_CODE';

    /** @var string Не удалось проверить (превышено время ожидания). */
    public const CODE_STATUS_TIMEOUT = 'CS_ERR_TIMEOUT';

    /**
     * @var string Не удалось проверить
     * (сайт, на котором установлен счетчик или одно из его зеркал находится в списке зараженных сайтов).
     */
    public const CODE_STATUS_INFECTED = 'CS_ERR_INFECTED';

    /** @var string Неизвестная ошибка. */
    public const CODE_STATUS_UNKNOWN = 'CS_ERR_UNKNOWN';

    /** @var string Не установлен. */
    public const CODE_STATUS_NOT_FOUND = 'CS_NOT_FOUND';

    /** @var string Корректно установлен. */
    public const CODE_STATUS_OK = 'CS_OK';

    /** @var string Ожидает проверки. */
    public const CODE_STATUS_CHECKING = 'CS_WAIT_FOR_CHECKING';

    /** @var string[] */
    public const CODE_STATUSES = [
        self::CODE_STATUS_CONNECT, self::CODE_STATUS_OTHER, self::CODE_STATUS_TIMEOUT, self::CODE_STATUS_INFECTED,
        self::CODE_STATUS_UNKNOWN, self::CODE_STATUS_NOT_FOUND, self::CODE_STATUS_OK, self::CODE_STATUS_CHECKING
    ];

    /** @var string счетчик создан пользователем в Яндекс.Метрике; */
    public const TYPE_SIMPLE = 'simple';

    /** @var string счетчик импортирован из РСЯ. */
    public const TYPE_PARTNER = 'partner';

    /** @var string[] */
    public const TYPES = [
        self::TYPE_SIMPLE, self::TYPE_PARTNER
    ];

    /** @var string счетчик, принадлежащий пользователю; */
    public const PERMISSION_OWN = 'own';

    /** @var string гостевой счетчик с уровнем доступа «только просмотр»; */
    public const PERMISSION_VIEW = 'view';

    /** @var string гостевой счетчик с уровнем доступа «полный доступ» */
    public const PERMISSION_EDIT = 'edit';

    /** @var string[] */
    public const PERMISSIONS = [
        self::PERMISSION_OWN, self::PERMISSION_VIEW, self::PERMISSION_EDIT
    ];

    /**
     * @var string Счетчик не привязан к организации в Коннекте.
     * В веб-интерфейсе Метрики на странице Настройка (вкладка Доступ) владельцу счетчика не предлагали привязать
     * его к организации. Возможно, из-за того, что не соблюдены условия.
     */
    public const CONNECT_STATUS_NOT_CONNECTED = 'not_connected';

    /**
     * @var string Счетчик может быть привязан к организации в Коннекте.
     * В веб-интерфейсе Метрики на странице Настройка (вкладка Доступ) владельцу счетчика предложили привязать
     * его к организации.
     */
    public const CONNECT_STATUS_READY_CONNECT = 'ready_to_connect';

    /** @var string Счетчик привязан к организации */
    public const CONNECT_STATUS_CONNECTED = 'connected';

    /** @var string[] */
    public const CONNECT_STATUSES = [
        self::CONNECT_STATUS_NOT_CONNECTED, self::CONNECT_STATUS_READY_CONNECT, self::CONNECT_STATUS_CONNECTED
    ];

    /** @var int учитывать визиты всех роботов */
    public const FILTER_ROBOTS_NO = 0;

    /** @var int фильтровать роботов только по строгим правилам (по умолчанию) */
    public const FILTER_ROBOTS_STRICT = 1;

    /** @var int фильтровать роботов по строгим правилам и по поведению */
    public const FILTER_ROBOTS_BEHAVIOR = 2;

    /** @var int Идентификатор счетчика */
    public $id;

    /** @var string Статус счетчика. (STATUS_*) */
    public $status;

    /** @var string Логин владельца счетчика */
    public $ownerLogin;

    /** @var string Статус установки кода счетчика. (CODE_STATUS_*) */
    public $codeStatus;

    /** @var ?CodeStatusInfo Информация о статусе счетчика */
    public $codeStatusInfo;

    /** @var string Наименование счетчика (Крупномеры Урала) */
    public $name;

    /** @var Site информация о сайте */
    public $site2;

    /** @var string (TYPE_*) */
    public $type;

    /** @var bool Добавлен ли счетчик в избранное */
    public $favorite;

    /** @var bool Согласие с Договором об обработке данных в сервисе «Яндекс.Метрика». */
    public $gdprAgreementAccepted;

    /** @var ?string Уровень доступа к счетчику. (PERMISSION_*) */
    public $permission;

    /** @var Site[] Список зеркал (доменов) сайта */
    public $mirrors2;

    /** @var Goal[]|null Список структур с информацией о целях счетчика */
    public $goals;

    /** @var Filter[]|null Список структур с информацией о фильтрах счетчика */
    public $filters;

    /** @var Operation[]|null Список структур с информацией об операциях счетчика */
    public $operations;

    /** @var Grant[]|null Список структур с информацией о правах доступа к счетчику. */
    public $grants;

    /** @var Label[]|null Список структур с информацией о метках */
    public $labels;

    /** @var Webvisor Структура с информацией о настройках Вебвизора */
    public $webvisor;

    /** @var CodeOptions Настройки кода счетчика */
    public $codeOptions;

    /** @var string Дата и время создания счетчика (2013-06-20T12:04:49+03:00) */
    public $createTime;

    /** @var string Часовой пояс для расчета статистики. (Asia/Yekaterinburg) */
    public $timeZoneName;

    /** @var int Текущее смещение часового пояса от Гринвича, минуты (300) */
    public $timeZoneOffset;

    /** @var string Признак привязки счетчика к организации в Яндекс.Коннекте. (CONNECT_STATUS_*) */
    public $connectStatus;

    /** @var ?int ID организации в Яндекс.Коннекте */
    public $organizationId;

    /** @var ?string Название организации в Яндекс.Коннекте */
    public $organizationName;

    /* при запросе информации о конкретном счетчике **********************************************************/

    /** @var string Время последнего изменения счетчика (2020-02-18 19:27:42) */
    public $updateTime;

    /** @var ?string Время удаления счетчика */
    public $deleteTime;

    /** @var string HTML-код счетчика ("\<\!-- Yandex.Metrika counter --\>\<\script t...) */
    public $code;

    /** @var Monitoring Настройки мониторинга доступности сайта */
    public $monitoring;

    /** @var int Фильтрация роботов (FILTER_ROBOTS_*) */
    public $filterRobots;

    /** @var int Тайм-аут визита в секундах (1800) */
    public $visitThreshold;

    /** @var OfflineOptions */
    public $offlineOptions;

    /** @var PublisherOptions */
    public $publisherOptions;

    /* Недокументированные из JSON-ответов */

    /** @var bool */
    public $hideAddress;

    /** @var int */
    public $partnerId;

    /** @var string название сайта с путем, куда установлен счетчик (metrika.yandex.com/about/) */
    public $site;

    /** @var int валюта (643) */
    public $currency;

    /** @var int (200) */
    public $maxGoals;

    /** @var int (30) */
    public $maxOperations;

    /** @var int (30) */
    public $maxFilters;

    /**
     * @var string[]
     *
     * ["socdem","crossdevice","publishers","direct","expenses","turbo_page","russian_market","webvisor2",
     * "ecommerce","target_calls"]
     */
    public $features;

    /**
     * @var string[] домены зеркал
     * ["metrica.yandex.com/about/"]
     */
    public $mirrors;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'codeStatusInfo' => CodeStatusInfo::class,
            'site2' => Site::class,
            'mirrors2' => [Site::class],
            'goals' => [Goal::class],
            'filters' => [Filter::class],
            'operations' => [Operation::class],
            'grants' => [Grant::class],
            'labels' => [Label::class],
            'webvisor' => Webvisor::class,
            'codeOptions' => CodeOptions::class,
            'monitoring' => Monitoring::class,
            'offlineOptions' => OfflineOptions::class,
            'publisherOptions' => PublisherOptions::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['codeStatusInfo', EntityValidator::class],
            ['site2', EntityValidator::class],
            ['mirrors2', EntityValidator::class],
            ['goals', EntityValidator::class],
            ['filters', EntityValidator::class],
            ['operations', EntityValidator::class],
            ['grants', EntityValidator::class],
            ['labels', EntityValidator::class],
            ['webvisor', EntityValidator::class],
            ['codeOptions', EntityValidator::class],
            ['monitoring', EntityValidator::class],
            ['offlineOptions', EntityValidator::class],
            ['publisherOptions', EntityValidator::class]
        ];
    }
}

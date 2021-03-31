<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 20:09:59
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage;

use dicr\validate\StringsValidator;
use dicr\validate\ValidateException;
use dicr\yandex\metrika\AbstractRequest;
use yii\httpclient\Request;

use function array_merge;

/**
 * Список доступных счетчиков.
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/management/counters/counters.html
 */
class CounterListRequest extends AbstractRequest
{
    /**
     * @var string
     * Счетчик не привязан к организации в Коннекте. В веб-интерфейсе Метрики на странице Настройка (вкладка Доступ)
     * владельцу счетчика не предлагали привязать его к организации. Возможно, из-за того, что не соблюдены условия.
     */
    public const CONNECT_STATUS_NOT_CONNECTED = 'NOT_CONNECTED';

    /**
     * @var string
     * Счетчик может быть привязан к организации в Коннекте. В веб-интерфейсе Метрики на странице Настройка
     * (вкладка Доступ) владельцу счетчика предложили привязать его к организации.
     */
    public const CONNECT_STATUS_READY_TO_CONNECT = 'READY_TO_CONNECT';

    /** @var string Счетчик привязан к организации. */
    public const CONNECT_STATUS_CONNECTED = 'CONNECTED';

    /** @var string[] */
    public const CONNECT_STATUSES = [
        self::CONNECT_STATUS_NOT_CONNECTED, self::CONNECT_STATUS_READY_TO_CONNECT, self::CONNECT_STATUS_CONNECTED
    ];

    /** @var string счетчик, принадлежащий пользователю */
    public const PERMISSION_OWN = 'own';

    /** @var string гостевой счетчик с уровнем доступа «только просмотр»; */
    public const PERMISSION_VIEW = 'view';

    /** @var string гостевой счетчик с уровнем доступа «полный доступ». */
    public const PERMISSION_EDIT = 'edit';

    /** @var string[] */
    public const PERMISSIONS = [
        self::PERMISSION_OWN, self::PERMISSION_VIEW, self::PERMISSION_EDIT
    ];

    /** @var string Без сортировки */
    public const SORT_NONE = 'None';

    /** @var string По умолчанию */
    public const SORT_DEFAULT = 'Default';

    /** @var string Количество визитов */
    public const SORT_VISITS = 'Visits';

    /** @var string Количество хитов */
    public const SORT_HITS = 'Hits';

    /** @var string Количество посетителей */
    public const SORT_UNIQUES = 'Uniques';

    /** @var string Название счетчика */
    public const SORT_NAME = 'Name';

    /** @var string[] */
    public const SORTS = [
        self::SORT_NONE, self::SORT_DEFAULT, self::SORT_VISITS, self::SORT_HITS, self::SORT_UNIQUES, self::SORT_NAME
    ];

    /** @var string Счетчик активен */
    public const STATUS_ACTIVE = 'Active';

    /** @var string Счетчик удален */
    public const STATUS_DELETED = 'Deleted';

    /** @var string[] */
    public const STATUSES = [
        self::STATUS_ACTIVE, self::STATUS_DELETED
    ];

    /** @var string счетчик создан пользователем в Яндекс.Метрике */
    public const TYPE_SIMPLE = 'simple';

    /** @var string счетчик импортирован из РСЯ */
    public const TYPE_PARTNER = 'partner';

    /** @var string[] */
    public const TYPES = [
        self::TYPE_PARTNER, self::TYPE_PARTNER
    ];

    /** @var ?string статус CONNECT_STATUS_* */
    public $connectStatus;

    /**
     * @var ?bool Фильтр по счетчикам, которые были добавлены в Избранные.
     * Значение по умолчанию: 0
     */
    public $favorite;

    /**
     * @var string[]|null Один или несколько дополнительных параметров возвращаемого объекта.
     * Названия дополнительных параметров указываются в любом порядке через запятую, без пробелов.
     * Например: field=goals,mirrors,grants,filters,operations.
     */
    public $field;

    /** @var ?int Фильтр по метке. */
    public $labelId;

    /**
     * @var ?int Порядковый номер счетчика, с которого начнется выдача списка счетчиков. Первый счетчик имеет номер 1.
     * Значение по умолчанию: 1
     */
    public $offset;

    /**
     * @var ?int Количество счетчиков, которые вы хотите получить.
     * Значение по умолчанию: 1000
     */
    public $perPage;

    /**
     * @var string[]|null Фильтр по уровню доступа к счетчику (PERMISSION_*)
     * Параметр может содержать несколько значений, разделенных запятой.
     */
    public $permission;

    /**
     * @var ?bool Выдать счетчики в обратном или прямом порядке сортировки.
     * Значение по умолчанию: true
     */
    public $reverse;

    /**
     * @var ?string Фильтр по строке.
     * Можно указать:
     * идентификатор счетчика, название счетчика, адрес сайта, на котором установлен счетчик, дополнительный адрес.
     * Будут показаны счетчики, имя, сайт или зеркала которых содержат заданную подстроку.
     * При фильтрации по идентификатору укажите его полностью.
     */
    public $searchString;

    /** @var ?string Сортировка (SORT_*) */
    public $sort;

    /**
     * @var ?string Фильтр по статусу счетчика. По умолчанию включен. (STATUS_*)
     * Значение по умолчанию: Active
     */
    public $status;

    /** @var ?string Фильтр по типу счетчика. (TYPE_*) */
    public $type;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['connectStatus', 'default'],
            ['connectStatus', 'in', 'range' => self::CONNECT_STATUSES],

            ['favorite', 'default'],
            ['favorite', 'boolean'],
            ['favorite', 'filter', 'filter' => 'intval'],

            ['field', 'default'],
            ['field', StringsValidator::class, 'separator' => '~[\s\,]+~u'],

            ['labelId', 'default'],
            ['labelId', 'integer'],
            ['labelId', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['offset', 'default'],
            ['offset', 'integer', 'min' => 1],
            ['offset', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['perPage', 'default'],
            ['perPage', 'integer', 'min' => 1],
            ['perPage', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['permission', 'default'],
            ['permission', StringsValidator::class, 'skipOnEmpty' => true],
            ['permission', 'each', 'rule' => ['in', 'range' => self::PERMISSIONS]],

            ['reverse', 'default'],
            ['reverse', 'boolean'],
            ['reverse', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['searchString', 'trim'],
            ['searchString', 'default'],

            ['sort', 'default'],
            ['sort', 'in', 'range' => self::SORTS],

            ['status', 'default'],
            ['status', 'in', 'range' => self::STATUSES],

            ['type', 'default'],
            ['type', 'in', 'range' => self::TYPES]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson() : array
    {
        return array_merge(parent::attributesToJson(), [
            'favorite' => [static::class, 'formatBoolean'],
            'field' => [static::class, 'formatArray'],
            'permission' => [static::class, 'formatArray'],
            'reverse' => [static::class, 'formatBoolean'],
        ]);
    }

    /**
     * @inheritDoc
     * @return Request
     */
    protected function httpRequest() : Request
    {
        if (! $this->validate()) {
            throw new ValidateException($this);
        }

        return $this->client->httpClient
            ->get(['/management/v1/counters'] + $this->json);
    }

    /**
     * @inheritDoc
     */
    public function send() : CounterListResponse
    {
        return new CounterListResponse([
            'json' => parent::send()
        ]);
    }
}

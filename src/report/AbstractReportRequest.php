<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 23:43:26
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\AbstractRequest;
use yii\httpclient\Request;

use function array_merge;

/**
 * Базовый класс для запросов отчета.
 */
abstract class AbstractReportRequest extends AbstractRequest
{
    /** @var string возвращает быстрый результат на основе сокращенной выборки данных */
    public const ACCURACY_LOW = 'low';

    /** @var string возвращает результат на основе выборки, сочетающей скорость и точность данных */
    public const ACCURACY_MEDIUM = 'medium';

    /** @var string возвращает наиболее точное значение, используя наибольшую выборку данных. */
    public const ACCURACY_HIGH = 'high';

    /** @var string возвращает все данные */
    public const ACCURACY_FULL = 'full';

    /** @var string[] */
    public const ACCURACY = [
        self::ACCURACY_LOW, self::ACCURACY_MEDIUM, self::ACCURACY_HIGH, self::ACCURACY_FULL
    ];

    /** @var string первый источник */
    public const ATTRIBUTION_FIRST = 'first';

    /** @var string последний источник */
    public const ATTRIBUTION_LAST = 'last';

    /** @var string последний значимый источник */
    public const ATTRIBUTION_LAST_SIGN = 'lastsign';

    /** @var string последний переход из Директа */
    public const ATTRIBUTION_LAST_DIRECT = 'last_yandex_direct_click';

    /** @var string[] */
    public const ATTRIBUTIONS = [
        self::ATTRIBUTION_FIRST, self::ATTRIBUTION_LAST, self::ATTRIBUTION_LAST_SIGN, self::ATTRIBUTION_LAST_DIRECT
    ];

    /** @var string */
    public const CURRENCY_RUB = 'RUB';

    /** @var string */
    public const CURRENCY_USD = 'USD';

    /** @var string */
    public const CURRENCY_EUR = 'EUR';

    /** @var string фишки */
    public const CURRENCY_YND = 'YND';

    /** @var string[] */
    public const CURRENCIES = [
        self::CURRENCY_RUB, self::CURRENCY_USD, self::CURRENCY_EUR, self::CURRENCY_YND
    ];

    /** @var string временной интервал не разбивается */
    public const GROUP_ALL = 'all';

    /**
     * @var string интервал устанавливается с учетом выбранного отчетного периода и количества данных,
     * достаточного для этого периода.
     */
    public const GROUP_AUTO = 'auto';

    /** @var string временной интервал разбивается на интервалы из некоторого количества минут. */
    public const GROUP_MINUTES = 'minutes';

    /** @var string временной интервал разбивается на 10-минутные интервалы. */
    public const GROUP_DEKAMINUTE = 'dekaminute';

    /** @var string временной интервал разбивается на минутные интервалы. */
    public const GROUP_MINUTE = 'minute';

    /** @var string временной интервал разбивается на часовые интервалы. */
    public const GROUP_HOUR = 'hour';

    /** @var string временной интервал разбивается на интервалы из нескольких часов. */
    public const GROUP_HOURS = 'hours';

    /** @var string временной интервал разбивается по дням. */
    public const GROUP_DAY = 'day';

    /** @var string временной интервал разбивается по неделям. */
    public const GROUP_WEEK = 'week';

    /** @var string временной интервал разбивается по месяцам */
    public const GROUP_MONTH = 'month';

    /** @var string  временной интервал разбивается по кварталам */
    public const GROUP_QUARTER = 'quarter';

    /** @var string временной интервал разбивается по годам */
    public const GROUP_YEAR = 'year';

    /** @var string[] */
    public const GROUPS = [
        self::GROUP_ALL, self::GROUP_AUTO, self::GROUP_MINUTES, self::GROUP_DEKAMINUTE, self::GROUP_MINUTE,
        self::GROUP_HOUR, self::GROUP_HOURS, self::GROUP_DAY, self::GROUP_WEEK, self::GROUP_MONTH, self::GROUP_YEAR
    ];

    /** @var int[] Идентификаторы счетчиков, через запятую. */
    public $ids;

    /** @var ?string шаблон */
    public $preset;

    /** @var string[]|null Список метрик, разделенных запятой. */
    public $metrics;

    /** @var string[]|null Список группировок, разделенных запятой. Лимит: 10 группировок в запросе. */
    public $dimensions;

    /**
     * @var ?string Фильтр сегментации.
     * Лимит:
     * - количество уникальных группировок и метрик — до 10,
     * - количество отдельных фильтров — до 20,
     * - длина строки в фильтре — до 10000 символов.
     */
    public $filters;

    /**
     * @var ?bool Включает в ответ строки, для которых значения группировок не определены.
     * Влияет только на первую группировку. По умолчанию выключено.
     */
    public $includeUndefined;

    /**
     * @var ?string Точность вычисления результата. (ACCURACY_*)
     * Позволяет управлять семплированием (количеством визитов, использованных при расчете итогового значения).
     * Значение по умолчанию: medium
     */
    public $accuracy;

    /**
     * @var ?bool Если параметр выставлен в true, API имеет право автоматически увеличивать accuracy
     * до рекомендованного значения. Когда идет запрос в маленькую таблицу с очень маленьким семплингом,
     * параметр поможет получить осмысленные результаты
     */
    public $proposedAccuracy;

    /**
     * @var string[]|null Логины клиентов Яндекс.Директа, через запятую.
     * Могут использоваться для формирования отчета Директ-расходы.
     */
    public $directClientLogins;

    /** @var ?string Язык */
    public $lang;

    /** @var ?bool форматирование результата */
    public $pretty;

    /**
     * @var ?string Часовой пояс в формате ±hh:mm в диапазоне [-23:59; +23:59], в котором будут расчитан период
     * выборки запроса, а также связанные с датой и временем группировки.
     * По умолчанию используется часовой пояс счетчика.
     */
    public $timezone;

    /**
     * @var ?string Модель атрибуции (ATTRIBUTION_*) По-умолчанию LastSign.
     * Некоторые группировки позволяют задать модель атрибуции.
     * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/param.html/
     */
    public $attribution;

    /** @var ?string Некоторые группировки позволяют настраивать валюту (CURRENCY_*) */
    public $currency;

    /** @var ?int Идентификатор цели */
    public $goalId;

    /**
     * @var ?string Группировка по времени для некоторых группировок а также для отчета по времени. (GROUP_*)
     * Значение по умолчанию: week
     */
    public $group;

    /** @var ?string Идентификатор эксперимента в Директе или Аудиториях */
    public $experimentAb;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['ids', 'required'],
            ['ids', 'each', 'rule' => ['integer', 'min' => 1]],
            ['ids', 'each', 'rule' => ['filter', 'filter' => 'intval']],

            ['preset', 'default'],
            ['preset', 'string'],

            ['metrics', 'default'],
            ['metrics', StringsValidator::class],
            ['metrics', 'required', 'when' => function () : bool {
                return empty($this->preset);
            }],

            ['dimensions', 'default'],
            ['dimensions', StringsValidator::class],

            ['filters', 'trim'],
            ['filters', 'default'],
            ['filters', 'string', 'max' => 10000],

            ['includeUndefined', 'default'],
            ['includeUndefined', 'boolean'],
            ['includeUndefined', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['accuracy', 'default'],
            ['accuracy', 'in', 'range' => self::ACCURACY],

            ['proposedAccuracy', 'default'],
            ['proposedAccuracy', 'boolean'],
            ['proposedAccuracy', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['directClientLogins', 'default'],
            ['directClientLogins', StringsValidator::class],

            ['lang', 'default'],
            ['lang', 'string'],

            ['pretty', 'default'],
            ['pretty', 'boolean'],
            ['pretty', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['timezone', 'default'],
            ['timezone', 'match', 'pattern' => '~^[+-]\d{2}\:\d{2}$~u'],

            ['attribution', 'default'],
            ['attribution', 'in', 'range' => self::ATTRIBUTIONS],

            ['currency', 'default'],
            ['currency', 'in', 'range' => self::CURRENCIES],

            ['goalId', 'default'],
            ['goalId', 'integer', 'min' => 1],
            ['goalId', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['group', 'default'],
            ['group', 'in', 'range' => self::GROUPS],

            ['experimentAb', 'default']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson() : array
    {
        return [
            'ids' => [static::class, 'formatArray'],
            'metrics' => [static::class, 'formatArray'],
            'dimensions' => [static::class, 'formatArray'],
            'includeUndefined' => [static::class, 'formatBoolean'],
            'proposedAccuracy' => [static::class, 'formatBoolean'],
            'directClientLogins' => [static::class, 'formatArray'],
            'pretty' => [static::class, 'formatBoolean']
        ];
    }

    /**
     * URL
     *
     * @return string
     */
    abstract protected function url() : string;

    /**
     * @inheritDoc
     */
    protected function httpRequest() : Request
    {
        return $this->client->httpClient
            ->get(array_merge($this->json, [$this->url()]), null, $this->headers());
    }

    /**
     * @inheritDoc
     */
    public function send() : ReportResponse
    {
        return new ReportResponse([
            'json' => parent::send()
        ]);
    }
}

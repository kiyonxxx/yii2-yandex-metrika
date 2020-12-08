<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 23:33:33
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;

use function array_merge;

/**
 * Drill down
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/drilldown.html/
 */
class TableDrilldownRequest extends AbstractReportRequest
{
    /** @var ?string Дата начала периода выборки в формате YYYY-MM-DD */
    public $date1;

    /** @var ?string Дата окончания периода выборки в формате YYYY-MM-DD */
    public $date2;

    /** @var string[]|null Выбор строки для дальнейшего развертывания. Состоит из json-списка ключей. */
    public $parentId;

    /**
     * @var ?bool Удалять из результата нераскрывающиеся неопределённые значения.
     * Имеет смысл только в случае include_undefined=true
     */
    public $onlyExpandableUndefined;

    /**
     * @var string[]|null Список группировок и метрик, разделенных запятой, по которым осуществляется сортировка.
     * По умолчанию сортировка производится по убыванию (указан знак «-» перед группировкой или метрикой).
     * Чтобы отсортировать данные по возрастанию, удалите знак «-»
     */
    public $sort;

    /** @var ?int Индекс первой строки выборки, начиная с 1. Значение по умолчанию: 1 */
    public $offset;

    /** @var ?int Количество элементов на странице выдачи. Лимит: 100 000. Значение по умолчанию: 100 */
    public $limit;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            [['date1', 'date2'], 'default'],
            [['date1', 'date2'], 'date', 'format' => 'php:Y-m-d'],

            ['parentId', 'default'],
            ['parentId', StringsValidator::class],

            ['onlyExpandableUndefined', 'default'],
            ['onlyExpandableUndefined', 'boolean'],
            ['onlyExpandableUndefined', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['sort', 'default'],
            ['sort', StringsValidator::class],

            ['offset', 'default'],
            ['offset', 'integer', 'min' => 1],
            ['offset', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['limit', 'default'],
            ['limit', 'integer', 'min' => 1, 'max' => 100000],
            ['limit', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson() : array
    {
        return array_merge(parent::attributesToJson(), [
            'parentId' => [static::class, 'formatArray'],
            'onlyExpandableUndefined' => [static::class, 'formatBoolean'],
            'sort' => [static::class, 'formatArray'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function url() : string
    {
        return '/stat/v1/data/drilldown';
    }
}

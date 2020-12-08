<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:34:44
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;

use function array_merge;

/**
 * Получение ветви дерева сводной таблицы
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/pivot_drilldown.html
 */
class PivotDrilldownRequest extends AbstractReportRequest
{
    /** @var ?string Дата начала периода выборки в формате YYYY-MM-DD */
    public $date1;

    /** @var ?string Дата окончания периода выборки в формате YYYY-MM-DD */
    public $date2;

    /** @var string[]|null Список группировок, разделенных запятой. Лимит: 10 группировок в запросе. */
    public $pivotDimensions;

    /** @var ?int Индекс первой строки выборки, начиная с 1. Значение по умолчанию: 1 */
    public $pivotOffset;

    /** @var ?int Количество столбцов на странице выдачи. Лимит: 100. Значение по умолчанию: 5 */
    public $pivotLimit;

    /** @var string[]|null Выбор столбца для дальнейшего развертывания. Состоит из json-списка ключей */
    public $pivotParentId;

    /** @var string[]|null Выбор столбцов для построения таблицы. Содержит перечисление списков ключей */
    public $pivotRowIds;

    /** @var string[]|null Выбор строк для построения графиков. Содержит перечисление списков ключей. */
    public $rowIds;

    /** @var string[]|null Выбор строки для дальнейшего развертывания. Состоит из json-списка ключей. */
    public $parentId;

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

            ['pivotDimensions', 'default'],
            ['pivotDimensions', StringsValidator::class],

            ['pivotOffset', 'default'],
            ['pivotOffset', 'integer', 'min' => 1],
            ['pivotOffset', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['pivotLimit', 'default'],
            ['pivotLimit', 'integer', 'min' => 1, 'max' => 100],
            ['pivotLimit', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['pivotParentId', 'default'],
            ['pivotParentId', StringsValidator::class],

            ['pivotRowIds', 'default'],
            ['pivotRowIds', StringsValidator::class],

            ['rowIds', 'default'],
            ['rowIds', StringsValidator::class],

            ['parentId', 'default'],
            ['parentId', StringsValidator::class],

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
            'pivotDimensions' => [static::class, 'formatArray'],
            'pivotParentId' => [static::class, 'formatArray'],
            'pivotRowIds' => [static::class, 'formatArray'],
            'rowIds' => [static::class, 'formatArray'],
            'parentId' => [static::class, 'formatArray'],
            'sort' => [static::class, 'formatArray']
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function url() : string
    {
        return '/stat/v1/data/pivot/drilldown';
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:34:22
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;

use function array_merge;

/**
 * Сравнение сегментов
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/requestcompareab.html/
 */
class CompareRequest extends AbstractReportRequest
{
    /** @var string Дата начала периода выборки для сегмента A в формате YYYY-MM-DD. */
    public $date1A;

    /** @var string Дата окончания периода выборки для сегмента A в формате YYYY-MM-DD */
    public $date2A;

    /** @var string Дата начала периода выборки для сегмента B в формате YYYY-MM-DD */
    public $date1B;

    /** @var string Дата окончания периода выборки для сегмента B в формате YYYY-MM-DD */
    public $date2B;

    /** @var ?string Фильтр сегментации для сегмента A */
    public $filtersA;

    /** @var ?string Фильтр сегментации для сегмента B */
    public $filtersB;

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
            [['date1A', 'date2A', 'date1B', 'date2B'], 'default'],
            [['date1A', 'date2A', 'date1B', 'date2B'], 'date', 'format' => 'php:Y-m-d'],

            [['filtersA', 'filtersB'], 'default'],
            [['filtersA', 'filtersB'], 'string'],

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
            'sort' => [static::class, 'formatArray']
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function url() : string
    {
        return '/stat/v1/data/comparison';
    }
}

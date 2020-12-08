<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 23:42:33
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\report\entity\Annotation;

/**
 * Получение данных по времени
 *
 * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/bytime.html
 */
class ByTimeRequest extends AbstractReportRequest
{
    /** @var ?string Дата начала периода выборки в формате YYYY-MM-DD */
    public $date1;

    /** @var ?string Дата окончания периода выборки в формате YYYY-MM-DD */
    public $date2;

    /** @var ?bool Признак включения в ответ примечания. По умолчанию выключено. Значение по умолчанию: false */
    public $includeAnnotations;

    /**
     * @var string[]|null Группы примечаний, разделенные запятой, которые должны вернуться в ответе.
     * Передается, если параметр include_annotations принимает значение true (ANNOTATION_GROUP_*)
     */
    public $annotationGroups;

    /** @var string[]|null Выбор строк для построения графиков. Содержит перечисление списков ключей. */
    public $rowIds;

    /** @var ?int Задает количество строк результата, если не указан параметр row_ids. Значение по умолчанию: 7 */
    public $topKeys;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            [['date1', 'date2'], 'default'],
            [['date1', 'date2'], 'date', 'format' => 'php:Y-m-d'],

            ['group', 'default'],
            ['group', 'in', 'range' => self::GROUPS],

            ['includeAnnotations', 'default'],
            ['includeAnnotations', 'boolean'],
            ['includeAnnotations', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['annotationGroups', 'default'],
            ['annotationGroups', StringsValidator::class],
            ['annotationGroups', 'each', 'rule' => ['in', 'range' => Annotation::GROUPS]],

            ['rowIds', 'default'],
            ['rowIds', StringsValidator::class],

            ['topKeys', 'default'],
            ['topKeys', 'integer', 'min' => 1],
            ['topKeys', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributesToJson() : array
    {
        return array_merge(parent::attributesToJson(), [
            'includeAnnotations' => [static::class, 'formatBoolean'],
            'annotationGroups' => [static::class, 'formatArray'],
            'rowIds' => [static::class, 'formatArray'],
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function url() : string
    {
        return '/stat/v1/data/bytime';
    }
}

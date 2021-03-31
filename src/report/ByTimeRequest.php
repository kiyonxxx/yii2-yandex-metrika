<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 21:53:41
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\report\entity\Annotation;
use yii\helpers\Json;

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

    /**
     * @var string[][]|null Выбор строк для построения графиков. Содержит перечисление списков ключей.
     * Массив массивов в формате JSON. Каждый подмассив может содержать значения измерений (name или id)
     * соответственно заданному в запросе набору значений параметра dimensions. Длина подмассива указывает на
     * измерения, по которым будут сгруппированы данные.
     *   [['Россия']]
     * или
     *  [['Россия','Саратовская область','Саратов']]
     * @link https://yandex.ru/dev/metrika/doc/api2/api_v1/examples.html#query
     */
    public $rowIds;

    /**
     * @var ?int Задает количество строк результата, если не указан параметр row_ids. Значение по умолчанию: 7
     * Параметр top_keys выбирает первые значения из набора данных первого измерения, указанного в запросе.
     * Вы можете задать количество этих значений (максимум 30). Сортировка данных в ответе API производится
     * по убыванию первого значения параметра metrics.
     */
    public $topKeys;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['date1', 'date2'], 'default'],
            [['date1', 'date2'], 'date', 'format' => 'php:Y-m-d'],

            ['group', 'default'],
            ['group', 'in', 'range' => self::GROUP],

            ['includeAnnotations', 'default'],
            ['includeAnnotations', 'boolean'],
            ['includeAnnotations', 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],

            ['annotationGroups', 'default'],
            ['annotationGroups', StringsValidator::class],
            ['annotationGroups', 'each', 'rule' => ['in', 'range' => Annotation::GROUPS]],

            ['rowIds', 'default'],

            ['topKeys', 'default'],
            ['topKeys', 'integer', 'min' => 1, 'max' => 30],
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
            'rowIds' => static fn($val) => Json::encode($val),
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

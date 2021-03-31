<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 19:30:40
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\report;

use dicr\yandex\metrika\AbstractResponse;
use dicr\yandex\metrika\report\entity\Annotation;

use function array_merge;

/**
 * Базовый класс ответа на запрос отчета.
 */
class ReportResponse extends AbstractResponse
{
    /** @var int Общее количество строк в ответе по всему множеству данных (с учетом фильтра). */
    public $totalRows;

    /** @var bool Признак того, что общее количество строк было округлено. */
    public $totalRowsRounded;

    /** @var bool Признак сэмплирования. Показывает, был ли применен сэмплинг. Возможные значения: true, false. */
    public $sampled;

    /** @var ?bool Признак возможного отсутствия конфиденциальных данных в ответе. Возможные значения: true, false. */
    public $sampleable;

    /** @var float Доля данных, по которым осуществлялся расчет. Доступно значение в пределах от 0 до 1. */
    public $sampleShare;

    /** @var int Количество строк в выборке данных */
    public $sampleSize;

    /** @var int Количество строк данных */
    public $sampleSpace;

    /** @var int Задержка в обновлении данных, в секундах */
    public $dataLag;

    /** @var array параметры запроса */
    public $query;

    /** @var array[] данные отчета */
    public $data;

    /** @var array суммарная информация */
    public $totals;

    /** @var float[]|null Минимальные результаты для метрик среди попавших в выдачу ключей */
    public $min;

    /** @var float[]|null Максимальные результаты для метрик среди попавших в выдачу ключей. */
    public $max;

    /** @var Annotation[]|null аннотации */
    public $annotations;

    /* недокументированные поля JSON-ответа *************************************************/

    /** @var int */
    public $lastPeriodIndex;

    /** @var array ([["2020-12-02", "2020-12-06"], ["2020-12-07", "2020-12-08"]]) */
    public $timeIntervals;

    /** @var ?bool */
    public $containsSensitiveData;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return array_merge(parent::attributeEntities(), [
            'annotations' => [Annotation::class]
        ]);
    }
}

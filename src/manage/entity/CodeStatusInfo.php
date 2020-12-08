<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:21:30
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Информация о статусе счетчика.
 */
class CodeStatusInfo extends Entity
{
    /** @var int Длина контента в байтах. */
    public $length;

    /** @var int Количество найденных валидных кодов Яндекс.Метрики. */
    public $found;

    /** @var int Количество найденных валидных кодов проверяемого счетчика. */
    public $match;

    /** @var int HTTP-код ответа («200» при успешном выполнении). */
    public $httpCode;

    /** @var string Строковое отображение HTTP-кода ответа («OK» при успешном выполнении). */
    public $httpMsg;

    /** @var float Время ответа сайта в секундах. */
    public $duration;

    /** @var string Инфицированный сайт (сайт, на котором установлен счетчик или одно из его зеркал). */
    public $infected;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            [['length', 'found', 'match', 'httpCode'], 'default'],
            [['length', 'found', 'match', 'httpCode'], 'integer', 'min' => 0],
            [['length', 'found', 'match', 'httpCode'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['httpMsg', 'default'],
            ['httpMsg', 'string'],

            ['duration', 'default'],
            ['duration', 'number', 'min' => 0],
            ['duration', 'filter', 'filter' => 'floatval', 'skipOnEmpty' => true],

            ['infected', 'default'],
            ['infected', 'string']
        ]);
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 03.12.20 20:55:27
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Информация о статусе счетчика.
 */
class CodeStatusInfo extends JsonEntity
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
}

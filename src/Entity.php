<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 20:31:41
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

use dicr\json\JsonEntity;

use function implode;

/**
 * Элемент данных
 */
abstract class Entity extends JsonEntity
{
    /**
     * Форматирует boolean значение в GET-параметрах.
     *
     * @param ?bool|?int $val
     * @return ?string
     */
    public static function formatBoolean($val) : ?string
    {
        return $val === null ? null : ($val ? 'true' : 'false');
    }

    /**
     * Форматирует массивы в GET-параметры
     *
     * @param ?array|?string $val
     * @return ?string
     */
    public static function formatArray($val) : ?string
    {
        return empty($val) ? null : implode(',', (array)$val);
    }
}

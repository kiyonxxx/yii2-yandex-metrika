<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 06:37:58
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika;

/**
 * Константы Яндекс.Метрики
 */
interface Metrika
{
    /** @var int id счетчика к которому доступ без авторизации */
    public const TEST_COUNTER_ID = 44147844;
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 07.12.20 21:54:48
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Настройки офлайн-событий счетчика.
 */
class OfflineOptions extends JsonEntity
{
    /** @var bool Расширенный период учета офлайн-конверсий */
    public $offlineConversionExtendedThreshold;

    /** @var bool Расширенный период учета звонков. */
    public $offlineCallsExtendedThreshold;

    /** @var bool Расширенный период учета оффлайн-заходов. */
    public $offlineVisitsExtendedThreshold;
}

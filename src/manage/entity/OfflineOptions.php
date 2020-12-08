<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:37:13
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

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'default'],
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'boolean'],
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'filter', 'filter' => 'intval', 'skipOnEmpty' => true]
        ];
    }
}

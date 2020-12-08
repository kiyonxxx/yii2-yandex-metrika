<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:27:28
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Настройки офлайн-событий счетчика.
 */
class OfflineOptions extends Entity
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
        return array_merge(parent::rules(), [
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'default'],
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'boolean'],
            [['offlineConversionExtendedThreshold', 'offlineCallsExtendedThreshold', 'offlineVisitsExtendedThreshold'],
                'filter', 'filter' => 'intval', 'skipOnEmpty' => true]
        ]);
    }
}

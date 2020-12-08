<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:27:15
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Настройки мониторинга сайта счетчика.
 */
class Monitoring extends Entity
{
    /** @var bool Уведомления для мониторинга доступности сайта. */
    public $enableMonitoring;

    /**
     * @var string|string[] Список адресов электронной почты для получения уведомлений мониторинга сайта.
     * Может содержать один или несколько адресов, разделенных запятыми.
     */
    public $emails;

    /**
     * @var bool настроены телефоны для SMS-уведомления.
     * Для получения уведомлений необходимо на них подписаться и подтвердить подписку.
     * Номер телефона хранится в персональных данных пользователя для всех сервисов Яндекса.
     */
    public $smsAllowed;

    /** @var bool включены SMS-уведомления. */
    public $enableSms;

    /**
     * @var string Разрешенные часовые диапазоны для отправки SMS-уведомлений.
     * Диапазоны указываются по дням недели с понедельника по воскресение. Если диапазон не указан для какого-либо дня,
     * в этот день SMS-уведомления не отправляются.
     * Дни недели разделяются точкой с запятой, как показано в следующем примере:
     * 8-9;8-9;;20-22;;;
     * Данное значение разрешает отправку SMS с 8:00 по 9:59 в понедельник и вторник и с 20:00 по 22:59 в четверг.
     * Каждый указанный час соответствует интервалу времени от начала до окончания этого часа. Так, число 9 означает
     * интервал между 9 часов 00 минут и 9 часов 59 минут включительно. Диапазоны могут состоять из интервалов «с–по»
     * и отдельных часов, например 7-12,16,18,22-23. Компоненты таких диапазонов разделяются запятой.
     */
    public $smsTime;

    /**
     * @var string|string[] Список телефонных номеров для получения уведомлений мониторинга сайта.
     * Может содержать один или несколько номеров через запятую.
     */
    public $phones;

    /**
     * @var int[] Идентификаторы телефонных номеров для получения уведомлений мониторинга.
     * Порядок идентификаторов соответствует порядку телефонных номеров в параметре phones.
     */
    public $phoneIds;

    /**
     * @var string|string[] Возможные телефонные номера для получения уведомлений мониторинга сайта.
     * Может содержать один или несколько номеров через запятую.
     */
    public $possiblePhones;

    /**
     * @var int[] Идентификаторы возможных телефонных номеров для получения уведомлений мониторинга сайта.
     * Порядок идентификаторов соответствует порядку телефонных номеров в параметре possible_phones.
     */
    public $possiblePhoneIds;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['enableMonitoring', 'default'],
            ['enableMonitoring', 'boolean'],
            ['enableMonitoring', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['emails', 'default'],
            ['emails', StringsValidator::class],

            [['smsAllowed', 'enableSms'], 'default'],
            [['smsAllowed', 'enableSms'], 'boolean'],
            [['smsAllowed', 'enableSms'], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['smsTime', 'default'],
            ['smsTime', 'string'],

            [['phones', 'possiblePhones'], 'default'],
            [['phones', 'possiblePhones'], StringsValidator::class],

            [['phoneIds', 'possiblePhoneIds'], 'default'],
            [['phoneIds', 'possiblePhoneIds'], 'each', 'rule' => ['integer', 'min' => 1]],
        ]);
    }
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:03:03
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\EntityValidator;
use dicr\json\JsonEntity;

/**
 * Настройки кода счетчика.
 */
class CodeOptions extends JsonEntity
{
    /** @var bool Асинхронный код счетчика. */
    public $async;

    /** @var Informer Настройки информера */
    public $informer;

    /** @var bool Запись и анализ поведения посетителей сайта. */
    public $visor;

    /** @var bool Отслеживание хеша в адресной строке браузера. Опция применима для AJAX-сайтов. */
    public $trackHash;

    /** @var bool Для XML-сайтов. Элемент noscript не должен использоваться в XML документах. */
    public $xmlSite;

    /** @var bool Сбор статистики для работы отчета Карта кликов. */
    public $clickmap;

    /** @var bool Выводить код счетчика в одну строку. */
    public $inOneLine;

    /** @var bool Сбор данных по электронной коммерции. */
    public $ecommerce;

    /**
     * @var bool Позволяет корректно учитывать посещения из регионов, в которых ограничен доступ к ресурсам Яндекса.
     * Использование этой опции может снизить скорость загрузки кода счётчика.
     */
    public $alternativeCdn;

    /* Недокументированные из JSON-ответа */

    /** @var string название javascript-переменной для даных. По-умолчанию "dataLayer" */
    public $ecommerceObject;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'informer' => Informer::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['informer', EntityValidator::class, 'class' => Informer::class]
        ];
    }
}

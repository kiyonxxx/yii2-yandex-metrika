<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:24:59
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Информация о сайте.
 */
class Site extends JsonEntity
{
    /** @var string полный домен сайта, включая URL раздела (metrika.yandex.com/about/) */
    public $site;

    /* Недокументированные из JSON-ответа */

    /** @var string домен сайта (metrika.yandex.com) */
    public $domain;
}

<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:28:20
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Информация о сайте.
 */
class Site extends Entity
{
    /** @var string полный домен сайта, включая URL раздела (metrika.yandex.com/about/) */
    public $site;

    /* Недокументированные из JSON-ответа */

    /** @var string домен сайта (metrika.yandex.com) */
    public $domain;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['site', 'required'],
            ['site', 'string'],

            ['domain', 'default'],
            ['domain', 'string']
        ]);
    }
}

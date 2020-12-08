<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:21:58
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;

/**
 * Информация о метках счетчика.
 */
class Label extends JsonEntity
{
    /** @var int Идентификатор метки */
    public $id;

    /** @var string Имя метки */
    public $name;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['id', 'default'],
            ['id', 'integer', 'min' => 1],
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['name', 'required'],
            ['name', 'string']
        ];
    }
}

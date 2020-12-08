<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:26:56
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Информация о метках счетчика.
 */
class Label extends Entity
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
        return array_merge(parent::rules(), [
            ['id', 'default'],
            ['id', 'integer', 'min' => 1],
            ['id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['name', 'required'],
            ['name', 'string']
        ]);
    }
}

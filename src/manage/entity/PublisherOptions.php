<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 21:28:07
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\validate\StringsValidator;
use dicr\yandex\metrika\Entity;

use function array_merge;

/**
 * Настройки контентной аналитики для счетчика.
 */
class PublisherOptions extends Entity
{
    /** @var bool Сбор данных контентной аналитики */
    public $enabled;

    /**
     * @var string Используемый на сайте тип разметки.
     * При создании или редактировании счетчика передайте в этом поле значение из поля schema_options.
     */
    public $schema;

    /** @var string[] Доступные варианты разметки сайта. */
    public $schemaOptions;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['enabled', 'default'],
            ['enabled', 'boolean'],
            ['enabled', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['schema', 'required'],
            ['schema', 'string'],

            ['schemaOptions', 'default'],
            ['schemaOptions', StringsValidator::class]
        ]);
    }
}

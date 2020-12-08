<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 11:46:29
 */

declare(strict_types = 1);
namespace dicr\yandex\metrika\manage\entity;

use dicr\json\JsonEntity;
use dicr\validate\StringsValidator;

/**
 * Настройки контентной аналитики для счетчика.
 */
class PublisherOptions extends JsonEntity
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
        return [
            ['enabled', 'default'],
            ['enabled', 'boolean'],
            ['enabled', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['schema', 'required'],
            ['schema', 'string'],

            ['schemaOptions', 'default'],
            ['schemaOptions', StringsValidator::class]
        ];
    }
}

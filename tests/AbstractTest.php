<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 06:40:59
 */

declare(strict_types = 1);
namespace dicr\tests;

use dicr\yandex\metrika\MetrikaClient;
use PHPUnit\Framework\TestCase;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Базовый тест.
 */
abstract class AbstractTest extends TestCase
{
    /**
     * API Client.
     *
     * @return MetrikaClient
     * @throws InvalidConfigException
     */
    protected static function client() : MetrikaClient
    {
        return Yii::$app->get('metrika');
    }
}

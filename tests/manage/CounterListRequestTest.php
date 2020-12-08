<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 09.12.20 00:12:43
 */

declare(strict_types = 1);
namespace dicr\tests\manage;

use dicr\tests\AbstractTest;
use dicr\yandex\metrika\manage\CounterListRequest;
use yii\base\Exception;

/**
 * Class CounterListRequestTest
 */
class CounterListRequestTest extends AbstractTest
{
    /**
     * Test
     *
     * @throws Exception
     */
    public function testSend() : void
    {
        $client = self::client();

        /** @var CounterListRequest $req */
        $req = $client->createRequest([
            'class' => CounterListRequest::class,
            'perPage' => 10
        ]);

        $res = $req->send();
        self::assertNotEmpty($res->rows);
        self::assertNotEmpty($res->counters);
        echo 'Всего счетчиков: ' . $res->rows . "\n";
    }
}

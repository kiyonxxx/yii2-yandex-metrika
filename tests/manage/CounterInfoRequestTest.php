<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 08.12.20 07:34:01
 */

namespace dicr\tests\manage;

use dicr\tests\AbstractTest;
use dicr\yandex\metrika\manage\CounterInfoRequest;
use dicr\yandex\metrika\Metrika;
use yii\base\Exception;

/**
 * Class CounterInfoRequestTest
 */
class CounterInfoRequestTest extends AbstractTest
{
    /**
     * Test.
     *
     * @throws Exception
     */
    public function testSend() : void
    {
        $client = self::client();

        /** @var CounterInfoRequest $req */
        $req = $client->createRequest([
            'class' => CounterInfoRequest::class,
            'counterId' => Metrika::TEST_COUNTER_ID
        ]);

        $res = $req->send();
        self::assertNotEmpty($res->id);
        self::assertNotEmpty($res->site2->site);
        echo 'Сайт счетчика: ' . $res->site2->site . "\n";
    }
}

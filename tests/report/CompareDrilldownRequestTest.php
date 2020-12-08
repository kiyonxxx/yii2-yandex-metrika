<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 09.12.20 00:09:07
 */

declare(strict_types = 1);

namespace dicr\tests\report;

use dicr\tests\AbstractTest;
use dicr\yandex\metrika\Metrika;
use dicr\yandex\metrika\report\CompareDrilldownRequest;
use yii\base\Exception;

/**
 * Class CompareDrilldownRequestTest
 */
class CompareDrilldownRequestTest extends AbstractTest
{
    /**
     * Test
     *
     * @throws Exception
     */
    public function testSend() : void
    {
        /** @var CompareDrilldownRequest $req */
        $req = self::client()->createRequest([
            'class' => CompareDrilldownRequest::class,
            'ids' => [Metrika::TEST_COUNTER_ID],
            'metrics' => ['ym:s:pageviews']
        ]);

        $res = $req->send();
        self::assertNotEmpty($res->totalRows);
        self::assertIsArray($res->query);
        self::assertNotEmpty($res->query);
        self::assertIsArray($res->data);
        self::assertNotEmpty($res->data);

        echo 'Результатов: ' . $res->totalRows . "\n";
    }
}

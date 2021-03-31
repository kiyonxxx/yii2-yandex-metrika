<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 31.03.21 23:48:05
 */

declare(strict_types = 1);

namespace dicr\tests\report;

use dicr\tests\AbstractTest;
use dicr\yandex\metrika\report\ByTimeRequest;
use yii\base\Exception;

use function var_export;

use const COUNTER_ID;

/**
 * Class TableRequest Test.
 */
class TestTest extends AbstractTest
{
    /**
     * Test
     *
     * @throws Exception
     */
    public function testSend(): void
    {
        /** @var ByTimeRequest $req */
        $req = self::client()->createRequest([
            'class' => ByTimeRequest::class,
            'ids' => [COUNTER_ID],
            'metrics' => ['ym:s:visits'],
            'filters' => 'ym:s:lastSignTrafficSource==\'organic\'',
            'date1' => '2021-03-29',
            'date2' => '2021-03-30',
            'group' => ByTimeRequest::GROUP_DAY,
            'pretty' => 1,
        ]);

        $res = $req->send();

        var_export($res->data);
    }
}

<?php

namespace Tests\Unit;

use App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\Impl\FuzzworkMarketDataBulkEstimator;
use Tests\TestCase;

class FuzzworkMarketDataBulkEstimatorTest extends TestCase
{


    public function testInitialize() {
        $a = resolve('App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\Impl\FuzzworkMarketDataBulkEstimator');

        $this->assertNotNull($a);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMultipleItems()
    {
        $c = collect([48112,12005]);
        /** @var FuzzworkMarketDataBulkEstimator $a */
        $a = resolve('App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator\Impl\FuzzworkMarketDataBulkEstimator', ['listOfTypeIds' =>$c]);
        $a->getPrice();


        $this->assertTrue(true);
    }
}

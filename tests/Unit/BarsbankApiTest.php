<?php
namespace Maxwkf\Barsbank\Tests;

use Maxwkf\Barsbank\Tests\TestCase;

class BarsbankApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testConnectivity() {

        $result = $this->client
            ->setDateFrom('2022-09-26')
            ->setDateTo('2022-09-30')
            ->setNumberAdults(1)
            ->getAvailabilities();
        
        $this->assertTrue(is_array($result));

    }
}

<?php

namespace Tests\Unit;

use App\Models\Pelanggan;
use PHPUnit\Framework\TestCase;

class PelangganTest extends TestCase
{
    /**
     * Test bronze level logic.
     */
    public function test_bronze_level_logic()
    {
        $pelanggan = new Pelanggan(['poin' => 0]);
        $this->assertEquals('Bronze', $pelanggan->member_level);
        $this->assertEquals(1, $pelanggan->discount_rate);

        $pelanggan->poin = 100;
        $this->assertEquals('Bronze', $pelanggan->member_level);
        $this->assertEquals(1, $pelanggan->discount_rate);
    }

    /**
     * Test silver level logic.
     */
    public function test_silver_level_logic()
    {
        $pelanggan = new Pelanggan(['poin' => 101]);
        $this->assertEquals('Silver', $pelanggan->member_level);
        $this->assertEquals(3, $pelanggan->discount_rate);

        $pelanggan->poin = 500;
        $this->assertEquals('Silver', $pelanggan->member_level);
        $this->assertEquals(3, $pelanggan->discount_rate);
    }

    /**
     * Test gold level logic.
     */
    public function test_gold_level_logic()
    {
        $pelanggan = new Pelanggan(['poin' => 501]);
        $this->assertEquals('Gold', $pelanggan->member_level);
        $this->assertEquals(5, $pelanggan->discount_rate);

        $pelanggan->poin = 1000;
        $this->assertEquals('Gold', $pelanggan->member_level);
        $this->assertEquals(5, $pelanggan->discount_rate);
    }
}

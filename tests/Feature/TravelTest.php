<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TravelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travel = Travel::factory()->create([
            'price' => 199900,
            'moods' => ['nature' => 80, 'relax' => 20],
        ]);
    }

    #[Test]
    public function it_correctly_sets_and_gets_price()
    {
        $this->assertEquals(1999.00, $this->travel->price);
    }

    #[Test]
    public function it_correctly_casts_moods_to_array()
    {
        $this->assertIsArray($this->travel->moods);
        $this->assertEquals(['nature' => 80, 'relax' => 20], $this->travel->moods);
    }
}

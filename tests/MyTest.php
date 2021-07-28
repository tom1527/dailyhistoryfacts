<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MyTest extends TestCase
{

    public function testTwoPlusTwoEqualsFour(): void
    {
        $this->assertEquals(5, 2+2);
    }

}



?>


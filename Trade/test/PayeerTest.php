<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PayeerTest extends TestCase
{
    public function testEmpty(): array
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }


}

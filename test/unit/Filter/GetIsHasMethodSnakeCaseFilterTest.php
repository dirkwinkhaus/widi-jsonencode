<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Filter;

use PHPUnit\Framework\TestCase;

class GetIsHasMethodSnakeCaseFilterTest extends TestCase
{
    /**
     * @test
     * @dataProvider getMethods
     */
    public function itShouldFilterGetAndIsMethods(string $method, bool $result): void
    {
        $filter = new GetIsHasMethodSnakeCaseFilter();

        $f = $filter->filter();

        $this->assertEquals($result, $f($method));
    }

    public function getMethods(): array
    {
        return [
            ['getProvider', false],
            ['getValue', false],
            ['get_value', true],
            ['getvalue', false],
            ['isProvider', false],
            ['isValue', false],
            ['is_value', true],
            ['isvalue', false],
            ['hasProvider', false],
            ['hasValue', false],
            ['has_value', true],
            ['hasvalue', false],
        ];
    }

    /**
     * @test
     * @dataProvider getMethodsProperties
     */
    public function itShouldExtractPropertyName(string $method, string $result): void
    {
        $filter = new GetIsHasMethodSnakeCaseFilter();

        $this->assertEquals($result, $filter->getPropertyName($method));
    }

    public function getMethodsProperties(): array
    {
        return [
            ['getProvider', 'getProvider'],
            ['getValue', 'getValue'],
            ['get_value', 'value'],
            ['getvalue', 'getvalue'],
            ['isProvider', 'isProvider'],
            ['isValue', 'isValue'],
            ['is_value', 'value'],
            ['isvalue', 'isvalue'],
            ['hasProvider', 'hasProvider'],
            ['hasValue', 'hasValue'],
            ['has_value', 'value'],
            ['hasvalue', 'hasvalue'],
        ];
    }
}

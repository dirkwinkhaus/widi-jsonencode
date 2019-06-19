<?php
declare(strict_types=1);

namespace Widi\JsonEncode\Filter;

use PHPUnit\Framework\TestCase;

class GetIsHasMethodFilterTest extends TestCase
{
    /**
     * @test
     * @dataProvider getMethods
     */
    public function itShouldFilterGetAndIsMethods(string $method, bool $result): void
    {
        $filter = new GetIsHasMethodFilter();

        $f = $filter->filter();

        $this->assertEquals($result, $f($method));
    }

    public function getMethods(): array
    {
        return [
            ['getProvider', true],
            ['getValue', true],
            ['get_value', false],
            ['getvalue', false],
            ['isProvider', true],
            ['isValue', true],
            ['is_value', false],
            ['isvalue', false],
            ['hasProvider', true],
            ['hasValue', true],
            ['has_value', false],
            ['hasvalue', false],
        ];
    }

    /**
     * @test
     * @dataProvider getMethodsProperties
     */
    public function itShouldExtractPropertyName(string $method, string $result): void
    {
        $filter = new GetIsHasMethodFilter();

        $this->assertEquals($result, $filter->getPropertyName($method));
    }

    public function getMethodsProperties(): array
    {
        return [
            ['getProvider', 'provider'],
            ['getValue', 'value'],
            ['get_value', 'get_value'],
            ['getvalue', 'getvalue'],
            ['isProvider', 'provider'],
            ['isValue', 'value'],
            ['is_value', 'is_value'],
            ['isvalue', 'isvalue'],
            ['hasProvider', 'provider'],
            ['hasValue', 'value'],
            ['has_value', 'has_value'],
            ['hasvalue', 'hasvalue'],
        ];
    }
}
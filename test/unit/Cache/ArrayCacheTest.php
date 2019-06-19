<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

use PHPUnit\Framework\TestCase;

class ArrayCacheTest extends TestCase
{

    /**
     * @test
     */
    public function itShouldTestCachedMethods(): void {
        $cache = new ArrayCache(true, true);

        $cache->setMethods('AClass', ['getMethod']);

        $this->assertTrue($cache->isClassMethodsCached('AClass'));
        $this->assertEquals(['getMethod'], $cache->getMethods('AClass'));
    }

    /**
     * @test
     */
    public function itShouldTestCachedProperties(): void
    {
        $cache = new ArrayCache(true, true);

        $cache->setPropertyName('AClass', 'getValue', 'value');
        $this->assertTrue($cache->isClassPropertiesCached('AClass', 'getValue'));
        $this->assertEquals('value', $cache->getPropertyName('AClass', 'getValue'));
    }
}
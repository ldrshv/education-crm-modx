<?php

use Zoomx\Support\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    public function testGetAndHasMethods()
    {
        $array = [
            'key1' => [
                'skey' => 'value',
            ],
            'key2' => true,
            'key3' => 'baz'
        ];
        $store = new Repository($array);
        self::assertSame(3, $store->count());
        self::assertTrue($store->has('key1'));
        $key1 = $store->get('key1');
        self::assertNotNull($key1);
        self::assertNotNull($store->get('key2'));
        self::assertNull($store->get('key'));
        self::assertSame('value', $store->get('key1')['skey']);
        self::assertSame(['key2' => true, 'key3' => 'baz'], $store->get(['key2', 'key3']));
        self::assertSame(['key2' => true, 'key3' => 'baz'], $store->getMany(['key2', 'key3']));
    }

    public function testSetAndAddMethods()
    {
        $store = new Repository();
        $store->set('key1', 'value');
        self::assertSame('value', $store->get('key1'));

        $store->set('array', ['foo' => 'bar', 'boo' => 'far']);
        self::assertSame('far', $store->get('array')['boo']);
        $array = $store->all();
        self::assertSame($array, [
            'key1' => 'value',
            'array' => [
                'foo' => 'bar',
                'boo' => 'far',
            ]
        ]);
        self::assertSame(2, $store->count());
        self::assertNull($store->get('key10'));
    }

    public function testAddMethod()
    {
        $store = new Repository();
        $store->add('foo', 'bar');
        self::assertSame('bar', $store->get('foo'));
        $store->add('foo', 'baz');
        self::assertSame('bar', $store->get('foo'));
    }

    public function testPrependAndPushMethod()
    {
        $store = new Repository();
        $store->add('array', ['foo']);
        $store->prepend('array', 'first');
        self::assertSame(['first', 'foo'], $store->get('array'));
        $store->push('array', 'last');
        self::assertSame(['first', 'foo', 'last'], $store->get('array'));
    }

    public function testArrayMethods()
    {
        $store = new Repository();
        self::assertFalse(isset($store['foo']));
        $store['foo'] = 'bar';
        self::assertSame('bar', $store['foo']);
        unset($store['foo']);
        self::assertNull($store['foo']);
    }
}

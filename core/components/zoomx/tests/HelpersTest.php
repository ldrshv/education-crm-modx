<?php

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        include __DIR__ . '/modx.php';
    }

    public function testZoomxFunction()
    {
        $service = zoomx();
        self::assertInstanceOf('Zoomx\Service', $service);
    }

    public function testParserxFunction()
    {
        $parser = parserx();
        self::assertInstanceOf('Zoomx\Contracts\ParserInterface', $parser);
    }

    public function testViewxFunction()
    {
        $tpl = viewx('test.tpl');
        self::assertInstanceOf('Zoomx\View', $tpl);
    }

    public function testJsonxFunction()
    {
        $response = jsonx(['foo' => 'bar']);
        self::assertInstanceOf('Zoomx\Json\Response', $response);
    }

    public function testAbortxFunction()
    {
        $_SERVER['SERVER_PROTOCOL'] = $_SERVER['SERVER_PROTOCOL'] ?? 'https';
        try {
        	abortx(404);
        } catch (\Exception $e) {
            self::assertInstanceOf('Zoomx\Exceptions\HttpException', $e);
        }
    }

    /*public static function tearDownAfterClass(): void
    {

    }*/
}

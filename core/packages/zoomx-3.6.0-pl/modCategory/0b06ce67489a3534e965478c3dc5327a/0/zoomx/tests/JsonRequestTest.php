<?php

use PHPUnit\Framework\TestCase;

class JsonRequestTest extends TestCase
{
    protected static $modx;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
        self::$modx->request = null;
        self::$modx->response = null;
        zoomx()->setRequest(null)->setResponse(null);
        self::$modx->request = zoomx()->getJsonRequest();
    }

    public function testCheckJsonRequestClass()
    {
        self::assertInstanceOf('Zoomx\Json\Request', self::$modx->request);
    }

    public function testCheckJsonResponseClass()
    {
        self::assertInstanceOf('Zoomx\Json\Response', self::$modx->response);
    }
}

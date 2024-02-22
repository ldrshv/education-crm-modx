<?php

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /** @var modX */
    protected static $modx;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
        self::$modx->request = null;
        self::$modx->response = null;
        zoomx()->setRequest(null)->setResponse(null);
    }

    public function testCheckRequestClass()
    {
        self::$modx->request = zoomx()->getRequest();
        self::assertInstanceOf('Zoomx\Request', self::$modx->request);
    }

    public function testCheckRequestHandlerClass()
    {
        $requestHandler = self::$modx->request->getRequestHandler();
        self::assertInstanceOf('Zoomx\RequestHandler', $requestHandler);
    }

    public function testHandlerDetectingForFriendlyUrls()
    {
        $modx = self::$modx;
        $modx->setOption('friendly_urls', true);
        $requestHandler = $modx->request->getRequestHandler(true);
        self::assertInstanceOf('Zoomx\AliasRequestHandler', $requestHandler);
    }

    public function testHandlerDetectingForNotFriendlyUrls()
    {
        $modx = self::$modx;
        $modx->setOption('friendly_urls', false);
        $requestHandler = $modx->request->getRequestHandler(true);
        self::assertInstanceOf('Zoomx\IdRequestHandler', $requestHandler);
    }

    /**
     * @depends testCheckRequestClass
     */
    public function testCheckResponseClass()
    {
        self::$modx->response = zoomx()->getResponse();
        self::assertInstanceOf('Zoomx\Response', self::$modx->response);
    }
}

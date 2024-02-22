<?php

use PHPUnit\Framework\TestCase;

class ModxTagTest extends TestCase
{
    /** @var modX */
    protected static $modx;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
    }

    public function testSystemSettingTag()
    {
        self::$modx->setOption('testing', 'Testing');
        $string = "{'++testing'}";
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('Testing', $parsed);
    }

    public function testPagetitleTag()
    {
        self::$modx->resource = self::$modx->newObject('modResource', ['pagetitle' => 'Article 1']);
        $string = "{'*pagetitle'}";
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('Article 1', $parsed);
    }

    public static function tearDownAfterClass(): void
    {
        parserx()->clearCompiledTemplate();
    }
}

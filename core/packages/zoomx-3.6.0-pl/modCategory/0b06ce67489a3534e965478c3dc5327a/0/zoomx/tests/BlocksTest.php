<?php

use PHPUnit\Framework\TestCase;

class BlocksTest extends TestCase
{
    /** @var modX */
    protected static $modx;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
    }

    public static function tearDownAfterClass(): void
    {
        parserx()->clearCompiledTemplate();
    }

    public function testBlockModxForSmartyParser()
    {
        self::$modx->setPlaceholder('foo', 'bar');
        $string = "{modx}[[+foo]]{/modx}";
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('bar', $parsed);
        self::$modx->unsetPlaceholder('foo');
    }

    public function testBlockParseForSmartyParser()
    {
        $string = '{parse}Var: {$foo}{/parse}';
        /** @var \Zoomx\Smarty $parser */
        $parser = parserx();
        $parsed = $parser->parse($string, ['foo' => 'bar']);
        self::assertSame('Var: bar', $parsed);
    }

    public function testAuthBlockForSmartyParser()
    {
        $string = '{auth}User content{/auth}';
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertEmpty($parsed);

        self::$modx->user = self::$modx->newObject('modUser', [
            'username' => "user",
        ]);
        self::$modx->user->id = 1000;
        self::$modx->user->addSessionContext('web');
        $parsed = $parser->parse($string);
        self::assertSame('User content', $parsed);
        self::$modx->user->removeSessionContext('web');
    }

    public function testGuestBlockForSmartyParser()
    {
        $string = '{guest}User content{/guest}';
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('User content', $parsed);

        self::$modx->user = self::$modx->newObject('modUser', [
            'username' => "user",
        ]);
        self::$modx->user->id = 1000;
        self::$modx->user->addSessionContext('web');
        $parsed = $parser->parse($string);
        self::$modx->user->removeSessionContext('web');
        self::assertEmpty($parsed);
    }
}

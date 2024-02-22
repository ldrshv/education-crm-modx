<?php

use Zoomx\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /** @var modX */
    protected static $modx;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
    }

    public function testParsing()
    {
        $string = '[[+foo]] means [[+bar]].';
        $parser = new Parser(self::$modx);
        $output = $parser->parse($string, ['foo' => 'FOO', 'bar' => 'BAR']);
        self::assertSame('FOO means BAR.', $output);
    }
}

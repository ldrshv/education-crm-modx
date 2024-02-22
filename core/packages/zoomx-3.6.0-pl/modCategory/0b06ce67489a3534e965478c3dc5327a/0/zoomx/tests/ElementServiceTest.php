<?php

use Zoomx\View;
use PHPUnit\Framework\TestCase;

class ElementServiceTest extends TestCase
{
    /** @var modX */
    protected static $modx;
    protected static $templateDir;

    public static function setUpBeforeClass(): void
    {
        self::$modx = include __DIR__ . '/modx.php';
        zoomx()->config(['zoomx_file_snippets_path' => __DIR__ . '/snippets/']);
        // Smarty parser
        self::$templateDir = parserx()->template_dir;
        parserx()->template_dir = __DIR__ . '/chunks';
    }

    public function testFileSnippetFoo()
    {
        $service = zoomx('elementService');

        self::assertSame('Bar', $service->runFileSnippet('foo_snippet.php', ['foo' => 'Bar']));
    }

    public function testFileSnippetWithInlineChunk()
    {
        $service = zoomx('elementService');

        self::assertSame('<p>Bar</p>', $service->runFileSnippet('inline_chunk_snippet.php', ['tpl' => '@INLINE <p>{$foo}</p>', 'foo' => 'Bar']));
    }

    public function testFileSnippetWithIncorrectName()
    {
        $service = zoomx('elementService');

        self::assertFalse($service->runFileSnippet('not_exists_snippet.php', ['tpl' => '@INLINE <p>{$foo}</p>', 'foo' => 'Bar']));

    }

    public function testSnippetWithIncorrectName()
    {
        $service = zoomx('elementService');
        $params = ['tpl' => '@INLINE <p>{$foo}</p>', 'foo' => 'Bar'];

        self::assertFalse($service->runSnippet('', $params));
        self::assertFalse($service->runSnippet('not_exist_snippet', $params));
    }

    public function testInlineChunk()
    {
        $service = zoomx('elementService');

        self::assertSame('<p>Bar</p>', $service->getChunk('@INLINE <p>{$foo}</p>', ['foo' => 'Bar']));
    }

    public function testFileChunk()
    {
        $service = zoomx('elementService');

        self::assertSame('<p>File chunk</p>', $service->getChunk('@FILE chunk.tpl', ['type' => 'chunk']));
    }

    public function testChunkWithIncorrectName()
    {
        $service = zoomx('elementService');
        $params = ['foo' => 'bar'];

        self::assertFalse($service->getChunk('', $params));
        self::assertFalse($service->getChunk('fake_chunk', $params));
    }

    public static function tearDownAfterClass():void
    {
        parserx()->template_dir = self::$templateDir;
    }
}

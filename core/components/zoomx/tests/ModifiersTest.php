<?php

use PHPUnit\Framework\TestCase;

class ModifiersTest extends TestCase
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

    public function testModxModifierForSmartyParser()
    {
        self::$modx->setPlaceholder('foo', 'bar');
        $string = "{'[[+foo]]'|modx}";
        $parser = parserx();
        $parsed = $parser->parse($string, ['foo' => 'bar']);
        self::assertSame('bar', $parsed);
        self::$modx->unsetPlaceholder('foo');
    }

    public function testParseModifierForSmartyParser()
    {
        $string = '{"Hello, $name"|parse}!';
        $parser = parserx();
        $parsed = $parser->parse($string, ['name' => 'Bob']);
        self::assertSame('Hello, Bob!', $parsed);
    }

    public function testPhModifierForSmartyParser()
    {
        self::$modx->setPlaceholder('foo', 'bar');
        $string = '{"foo"|ph}';
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('bar', $parsed);
    }

    public function testPrintModifierForSmartyParser()
    {
        $array = ['foo' => 'bar'];
        $string = '{$array|print:true:false}';
        $parser = parserx();
        $parsed = preg_replace('/[\s+]/', '', $parser->parse($string, compact('array')));
        self::assertSame('<pre>Array([foo]=>bar)</pre>', $parsed);
        $string = '{$array|print:false:false}';
        $parsed = preg_replace('/[\s+]/', '', $parser->parse($string, compact('array')));
        self::assertSame('Array([foo]=>bar)', $parsed);
    }

    public function testConfigModifierForSmartyParser()
    {
        self::$modx->setOption('foo_config', 'bar');
        $string = '{"foo_config"|config}';
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('bar', $parsed);
        unset(self::$modx->config['foo_config']);
    }

    public function testUserModifierForSmartyParser()
    {
        $excluded = ['cachepwd', 'salt','sessionid', 'password', 'session_stale'];
        self::$modx->user = self::$modx->newObject('modUser', [
            'username' => "user",
            'email' => 'user@mail.com',
            'cachepwd' => '123aasd123',
            'salt' => '123aasd123',
            'sessionid' => '123aasd123',
            'password' => '123aasd123',
            'session_stale' => '{}',
        ]);
        $string = "{'username'|user:'default'}";
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('user', $parsed);

        foreach ($excluded as $item) {
            $string = "{'{$item}'|user:'default'}";
            $parsed = $parser->parse($string);
            self::assertSame('default', $parsed);
        }
    }

    public function testUserinfoModifierForSmartyParser()
    {
        $excluded = ['cachepwd', 'salt','sessionid', 'password', 'session_stale', 'remote_key', 'remote_data', 'hash_class', 'internalKey'];
        self::$modx->user = self::$modx->newObject('modUser', [
            'username' => "user",
            'email' => 'user@mail.com',
            'cachepwd' => '123aasd123',
            'salt' => '123aasd123',
            'sessionid' => '123aasd123',
            'password' => '123aasd123',
            'session_stale' => '{}',
            'remote_key' => 'remote_key',
            'remote_data' => 'remote_data',
            'hash_class' => 'hash_class',
            'internalKey' => '100',
        ]);
        self::$modx->user->Profile = self::$modx->newObject('modUserProfile');
        $string = "{1|userinfo:'username'}";
        $parser = parserx();
        $parsed = $parser->parse($string);
        self::assertSame('user', $parsed);

        foreach ($excluded as $item) {
            $string = "{1|userinfo:'{$item}'}";
            $parsed = $parser->parse($string);
            self::assertSame('', $parsed);
        }
    }

    public function testParsedownModifierForSmartyParser()
    {
        $parser = parserx();
        $string = "{'# Heading'|markdown}";
        $stringUnsafe = "{'<script>alert(1)</script>'|markdown:true}";
        self::assertSame('<h1>Heading</h1>', $parser->parse($string));
        self::assertSame('<p>&lt;script&gt;alert(1)&lt;/script&gt;</p>', $parser->parse($stringUnsafe));
    }

    public function testResourceModifierForSmartyParser()
    {
        $parser = parserx();
        $modx = self::$modx;
        $modx->resource = $modx->newObject('modDocument');
        $modx->resource->fromArray([
            'id' => 1,
            'type' => 'document',
            'contentType' => 'text/html',
            'pagetitle' => 'Главная страница',
            'longtitle' => '',
            'description' => '',
            'alias' => 'second',
            'alias_visible' => 1,
            'link_attributes' => '',
            'published' => 1,
            'pub_date' => 0,
            'unpub_date' => 0,
            'parent' => 0,
            'isfolder' => 0,
            'introtext' => '',
            'content' => '',
            'richtext' => 0,
            'template' => 1,
            'menuindex' => 1,
            'searchable' => 1,
            'cacheable' => 1,
            'createdby' => 1,
            'createdon' => 1613379158,
            'editedby' => 1,
            'editedon' => 1657898373,
            'deleted' => 0,
            'deletedon' => 0,
            'deletedby' => 0,
            'publishedon' => 1636701300,
            'publishedby' => 1,
            'menutitle' => '',
            'donthit' => 0,
            'privateweb' => 0,
            'privatemgr' => 0,
            'content_dispo' => 0,
            'hidemenu' => 0,
            'class_key' => 'modDocument',
            'context_key' => 'web',
            'content_type' => 1,
            'uri' => 'second.html',
            'uri_override' => 0,
            'hide_children_in_tree' => 0,
            'show_in_tree' => 1,
            'properties' => null,
            'tvKey' =>  [
                    0 => 'tvKey',
                    1 => 'Значение ТВ поля',
                    2 => 'default',
                    3 => null,
                    4 => 'text',
            ],
        ], '', true, true);

        self::assertSame('Главная страница', $parser->parse('{"pagetitle"|resource}'));
        self::assertSame('Главная страница', $parser->parse('{"longtitle"|resource:pagetitle}'));
        self::assertSame('Главная страница', $parser->parse('{"not"|resource:pagetitle}'));
        self::assertSame('', $parser->parse('{"not"|resource}'));
        self::assertSame('Нет данных', $parser->parse('{"longtitle"|resource|default:"Нет данных"}'));
        self::assertSame('Значение ТВ поля', $parser->parse('{"tvKey"|resource}'));
    }
}

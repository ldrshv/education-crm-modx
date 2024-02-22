<?php

use Zoomx\View;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    public function testAllMethods()
    {
        $name = 'test.tpl';
        $data = [
            'foo' => 'bar'
        ];
        $tpl = new View($name, $data);
        self::assertSame($name, $tpl->name);
        self::assertTrue($tpl->hasData());
        self::assertFalse($tpl->hasContent());
        $tpl->setContent('New content');
        self::assertTrue($tpl->hasContent());
        self::assertSame($name, (string)$tpl );
    }


}

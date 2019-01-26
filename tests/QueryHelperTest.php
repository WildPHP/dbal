<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

use PHPUnit\Framework\TestCase;
use WildPHP\Database\QueryTypes\QueryHelper;

class QueryHelperTest extends TestCase
{

    public function testPrepareTableNameException()
    {
        $this->expectException(\WildPHP\Database\DatabaseException::class);
        QueryHelper::prepareTableName('ing');
    }

    public function testPrepareColumnName()
    {
        $this->assertEquals('"test"', QueryHelper::prepareColumnName('test', true));
        $this->assertEquals('test', QueryHelper::prepareColumnName('test'));
        $this->assertEquals('"test"', QueryHelper::prepareColumnName('"test"'));
        $this->assertEquals('"te\\"st"', QueryHelper::prepareColumnName('te"st'));
    }

    public function testAddKnownTableName()
    {
        QueryHelper::addKnownTableName('test');
        $this->assertEquals('test', QueryHelper::prepareTableName('test'));
    }

    public function testPrepareJoinStatement()
    {
        QueryHelper::addKnownTableName('test');
        QueryHelper::addKnownTableName('foo');
        $expected = 'JOIN test ON ing = foo';
        $this->assertEquals('', QueryHelper::prepareJoinStatement([]));
        $this->assertEquals($expected, QueryHelper::prepareJoinStatement(['test' => 'ing = foo']));

        $expected = 'JOIN test ON ing = foo JOIN foo ON bar = baz';
        $this->assertEquals($expected, QueryHelper::prepareJoinStatement(['test' => 'ing = foo', 'foo' => 'bar = baz']));
    }

    public function testPrepareColumnNames()
    {
        $expected = ['*'];

        $this->assertEquals($expected, QueryHelper::prepareColumnNames([]));

        $expected = ['test', 'ing', '"foo\\"bar"'];
        $this->assertEquals($expected, QueryHelper::prepareColumnNames(['test', 'ing', 'foo"bar']));
    }

    public function testPrepareWhereStatement()
    {
        $this->assertEmpty(QueryHelper::prepareWhereStatement([]));

        $expected = 'WHERE foo = ?';
        $this->assertEquals($expected, QueryHelper::prepareWhereStatement(['foo' => 'bar']));

        $expected = 'WHERE foo = ? AND baz = ?';
        $this->assertEquals($expected, QueryHelper::prepareWhereStatement(['foo' => 'bar', 'baz' => 'test']));
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (
            config('database.default') !== 'mysql'
            || config('database.connections.mysql.database') !== env('TEST_DB_DATABASE')
        ) {
            throw new \RuntimeException('Tests must use the configured MySQL testing database.');
        }
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Принудительно ставим environment для тестов
        config()->set('app.env', 'testing');

        // Используем SQLite in-memory
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        // Сбрасываем старое соединение и переподключаемся
        DB::purge('sqlite');
        DB::reconnect('sqlite');

        // Прогоняем миграции для in-memory базы
        $this->artisan('migrate')->run();
    }
}

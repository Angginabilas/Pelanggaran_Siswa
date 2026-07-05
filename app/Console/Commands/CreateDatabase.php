<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create MySQL database if not exists';

    public function handle()
    {
        $dbName = config('database.connections.mysql.database');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        try {
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->info("Database '$dbName' created or already exists.");
        } catch (\Exception $e) {
            $this->error("Failed: " . $e->getMessage());
        }
    }
}

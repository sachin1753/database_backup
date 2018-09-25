Useing this branch you can keep backup of all your databases in a folder and download them when needed.
Follow the steps to complete the database backup process:
1. Pull the branch
2. Install composer or git if not exist in your machine
3. Run composer install/update
4. Create .env file (You can copy and paste the existing .env.sample file)
5. Change config/database.php -> connections array to connect with the database (db1, db2, and db3 - change login credentails and database names, you can add more databases if needed)
'<Database Name>' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => "<Database Name>",
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
6. Change config/database.php -> database_list array to list our all database names on home page to download
    'database_list' => [
        "<Database Name>", "<Database Name>", "<Database Name>"
    ],
7. Give permission to storage, public, and bootstrap folder
8. You have option to download database one by one just simply click on the database name
9. You can download all the databases in single on click of Download All button

Feel free to add comments or give your feedback about the flow we develop

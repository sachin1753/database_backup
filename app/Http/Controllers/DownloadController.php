<?php namespace App\Http\Controllers;

/**
 * Class DownloadController
 *
 * @author Sachin Kumar sachin.kumar@ecotechservices.com
 */

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    /**
     * Construct
     * set meomery limit -1 so that process will not crash in between
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
    }

    /**
     * Database Listing
     *
     * @param Request $request
     * @return $this
     */
    public function databaseListing()
    {
        // Load database list from config file
        $database_list = config('database.database_list');

        return view('database-listing')->with([
            'databaseList' => $database_list
        ]);
    }

    /**
     * Save All
     *
     */
    public function saveAll()
    {
        // Load database list from config file
        $database_list = config('database.database_list');

        foreach ($database_list as $dbname)
        {
            try
            {
                $connection = DB::connection($dbname);
            }
            catch(\Exception $e) {}

            $this->exportDatabase($connection, $dbname);
        }
        return redirect()->route('index')->withFlashSuccess('Databases have been successfully saved');
    }

    /**
     * Get DataBase
     *
     * @param Request $request
     */
    public function getDataBase(Request $request)
    {
        $dbname = !empty($request->get('dbName')) ? $request->get('dbName') : '' ;


        if ($dbname != '')
        {
            try
            {
                $connection = DB::connection($dbname);
            }
            catch(\Exception $e) {return redirect()->route('index')->withFlashSuccess('Database is not exist');}
            
            try
            {
                $queryTables = $connection->select('SHOW TABLES');
            }
            catch(\Exception $e) {return redirect()->route('index')->withFlashSuccess('Database is not exist');}

            $this->exportDatabase($connection, $dbname);

        }

        return redirect()->route('index')->withFlashSuccess('Database has been successfully saved');

    }

    /**
     * Export Database
     *
     * @param Connection $connection
     * @param Name $dbname
     */
    public function exportDatabase($connection, $dbname)
    {
        $backup_name    = false;
        $target_tables  = [];


        try
        {
            $queryTables = $connection->select('SHOW TABLES');
        }
        catch(\Exception $e) 
        {
            return redirect()->route('index')->withFlashSuccess('Database is not exist');
        }

        if($queryTables !='')
        {

            // Create an array of all tables
            foreach ($queryTables as $tables)
            {
                foreach ($tables as $table)
                {
                    $target_tables[] = $table;
                }

            }
        }

        if(count($target_tables) > 0)
        {
            foreach ($target_tables as $table)
            {
                $result         = $connection->table($table)->get();
                $fields_amount  = $result->count();
                $res            = $connection->select('SHOW CREATE TABLE ' . $table);
                $dbcreateQ      = $connection->select('SHOW CREATE DATABASE '. $dbname);
                $content        = (!isset($content) ? '' : $content) . "\n\n";

                $dbCount = 0;
                foreach ($dbcreateQ[0] as $rd)
                {
                    if ($dbCount++ != 0)
                    {
                        $content .= $rd . ";\n\n";
                    }

                }

                $resCount = 0;
                foreach ($res[0] as $r)
                {
                    if ($resCount++ != 0)
                    {
                        $content .= $r . ";\n\n";
                    }

                }

                // Insert row data in content
                for ($i = 0, $st_counter = 0; $i < count($result); $i++, $st_counter++)
                {
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    $j = 0;

                    $row_amount = count((array) $result[$i]);

                    foreach ($result[$i] as $value)
                    {
                        $value = str_replace("\n", "\\n", addslashes($value));

                        if (isset($value))
                        {
                            $content .= '"' . $value . '"';
                        }
                        else
                        {
                            $content .= '""';
                        }

                        if ($j++ < ($row_amount - 1))
                        {
                            $content .= ',';
                        }
                    }
                    $content .= ")";

                    //   every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $fields_amount)
                    {
                        $content .= ";";
                    }
                    else
                    {
                        $content .= ",";
                    }
                }

            }

            $fileName = $backup_name ? $backup_name : $dbname . "_(" . date('d-m-Y') . "_" . date('H-i-s') . ").sql";

            $this->saveSqlFile($fileName, $content);

        }
    }

    /**
     * Save SQL File
     *
     * @param String $fileName
     * @param Data $data
     */
    public function saveSqlFile($fileName, $data)
    {
        File::put(public_path('/download/databases/' . $fileName), $data);
    }
}

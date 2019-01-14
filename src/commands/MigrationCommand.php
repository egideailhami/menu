<?php namespace GritTekno\Menu;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'grittekno:migration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('grittekno', substr(__DIR__, 0, -8).'views');

        if ($this->confirm("Proceed with the migration creation? [yes|no]", "yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration()) {

                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions".
                    " within the database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createMigration()
    {
        $cek = 0;
        $migrationFile = base_path("/database/migrations")."/".date('Y_m_d_His')."_grit-tekno_setup_tables.php";
        $output = $this->laravel->view->make('grittekno::migration')->render();
        $cek = count(glob(base_path("/database/migrations")."/*_grit-tekno_setup_tables.php"));
        if ($cek == 0 && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}

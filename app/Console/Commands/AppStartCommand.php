<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use TheSeer\Tokenizer\Exception;

class AppStartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ativar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        Esse comando serve para iniciar um projeto novo do zero, criando a estrutura basica da base de dados
    ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        printf("\nInicio da criação da estrutura da base de dados\n");
        try{
        //    printf("\n". exec('php -v'));
            DB::transaction(function () {

                // printf("\n{$migration}");
                // exec('php artisan migrate');
                system('php artisan migrate --path=database/migrations/Ativar', $migration);
                printf("\nbase criada, iniciando a população das tabelas com algumas configurações padrão.\n");
                // exec('php artisan db:seed');
                system('php artisan db:seed', $seeders);
                printf("\nCriando os arquivos de tradução\n");
                system('php artisan app:trans', $trans);
                printf("\nTudo pronto, Have a little fun!!!");
            });
        }
        catch (Exception $e){

            printf("\nErro ! Rollback realizado");
        }
    }
}

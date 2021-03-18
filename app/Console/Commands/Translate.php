<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Api\Trans;
class Translate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trans';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile translation files';
    private $trans;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Trans $trans)
    {
        parent::__construct();
        $this->trans = $trans;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Executando');
        $this->trans->exec();
        $this->info('Fim....');
    }
}
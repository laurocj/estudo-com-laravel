<?php

namespace App\Console\CrudGenerator\Commands;

use App\Console\CrudGenerator\Traits\MakeController;
use App\Console\CrudGenerator\Traits\MakeModel;
use App\Console\CrudGenerator\Traits\MakeRepository;
use App\Console\CrudGenerator\Traits\MakeRequest;
use App\Console\CrudGenerator\Traits\MakeService;
use App\Console\CrudGenerator\Traits\MakeViews;

/**
 * Class CrudGenerator.
 */
class CrudGenerator extends GeneratorCommand
{
    use MakeController,
        MakeModel,
        MakeRepository,
        MakeRequest,
        MakeService,
        MakeViews;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:make-crud
                            {tabela : Nome da tabela}
                            {modulo : Nome do modulo}
                            {--alias= : O nome que será usado em substituição ao nome da tabela.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um CRUD inicíal para o desenvolvimento.';

    /**
     * Execute o comando do console.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->info('Executando o gerador de CRUD ...');

        // verifica se a tabela existe no banco de dados
        if (!$this->tableExists()) {
            $this->error("`{$this->getTabela()}` essa tabela não existe.");

            return false;
        }

        // Gera as partes do CRUD
        $this->buildController()
            ->buildModel()
            ->buildViews()
            ->buildService()
            ->buildRepository()
            ->buildRequest();

        $this->info('Criado com sucesso.');

        return true;
    }
}

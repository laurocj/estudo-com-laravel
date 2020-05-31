<?php

namespace App\Console\CrudGenerator\Commands;

use App\Console\CrudGenerator\Traits\MakeModel;

/**
 * Class ModelGenerator.
 */
class ModelGenerator extends GeneratorCommand
{
    use MakeModel;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:make-model
                            {tabela : Nome da tabela}
                            {modulo : Nome do modulo}
                            {--alias= : O nome que será usado em substituição ao nome da tabela.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um model inicíal para o desenvolvimento.';

    /**
     * Execute o comando do console.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->info('Executando o gerador de Model ...');


        // verifica se a tabela existe no banco de dados
        if (!$this->tableExists()) {
            $this->error("`{$this->getTabela()}` essa tabela não existe.");

            return false;
        }

        // Gera as partes do CRUD
        $this->buildModel();

        $this->info('Criado com sucesso.');

        return true;
    }
}

<?php

namespace App\Console\CrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GeneratorCommand.
 */
abstract class GeneratorCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Table name from argument.
     *
     * @var string
     */
    protected $table = null;

    /**
     * Formatted Class name from Table.
     *
     * @var string
     */
    protected $name = null;

    /**
     * Store the DB table columns.
     *
     * @var array
     */
    private $tableColumns = null;

    /**
     * Regras para o validador
     *
     * @var array
     */
    private $rulesArray = [];

    /**
     * Model Namespace.
     *
     * @var string
     */
    protected $modelNamespace = 'Entities';

    /**
     * Service Namespace.
     *
     * @var string
     */
    protected $serviceNamespace = 'Services';

    /**
     * Repository Namespace.
     *
     * @var string
     */
    protected $repositoryNamespace = 'Repository';

    /**
     * Controller Namespace.
     *
     * @var string
     */
    protected $controllerNamespace = 'Http\Controllers';

    /**
     * Request Namespace.
     *
     * @var string
     */
    protected $requestNamespace = 'Http\Requests';

    /**
     * Custom Options name
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Build the directory if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Nomaliza o nome da coluna da tabela
     * @param string $name
     * @return string
     */
    protected function normalizeName(string $name)
    {
        return str_replace(['-','__'],'_',Str::snake($name));
    }

    /**
     * Write the file/Class.
     *
     * @param $path
     * @param $content
     */
    protected function write($path, $content)
    {
        $this->files->put($path, $content);
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function _getPath($namespace)
    {
        return module_path($this->getModulo(), $namespace);
    }

    /**
     * Get the path from namespace.
     *
     * @param $namespace
     *
     * @return string
     */
    protected function _spacePath($namespace)
    {
        return module_path($this->getModulo(), $namespace);
    }

    /**
     * Obtenha o namespace para a classe
     */
    private function space($namespace)
    {
        return config('modules.namespace')."\\".$this->getModulo().'\\'.$namespace;
    }

    protected function getModelName()
    {
        return $this->getNome();
    }

    protected function getModelTitle()
    {
        return Str::title(Str::snake($this->getNome(), ' '));
    }

    protected function getModelNamespace()
    {
        return $this->space($this->modelNamespace);
    }

    protected function getServiceNamespace()
    {
        return $this->space($this->serviceNamespace);
    }

    protected function getRepositoryNamespace()
    {
        return $this->space($this->repositoryNamespace);
    }

    protected function getControllerNamespace()
    {
        return $this->space($this->controllerNamespace);
    }

    protected function getRequestNamespace()
    {
        return $this->space($this->requestNamespace);
    }

    protected function getModuleLower()
    {
        return strtolower($this->getModulo());
    }

    protected function getModelNamePluralLowerCase()
    {
        return Str::camel(Str::plural($this->getNome()));
    }

    protected function getModelNamePluralUpperCase()
    {
        return ucfirst(Str::plural($this->getNome()));
    }

    protected function getModelNameLowerCase()
    {
        return Str::camel($this->getNome());
    }

    protected function getRouterName()
    {
        return Str::kebab(Str::plural($this->getNome()));
    }

    protected function getPathViewsName()
    {
        return Str::kebab($this->getNome());
    }

    /**
     * Build the replacement.
     *
     * @return array
     */
    protected function buildReplacements()
    {
        return [
            '{{modelName}}'                 => $this->getModelName(),
            '{{modelTitle}}'                => $this->getModelTitle(),
            '{{modelNamespace}}'            => $this->getModelNamespace(),
            '{{serviceNamespace}}'          => $this->getServiceNamespace(),
            '{{repositoryNamespace}}'       => $this->getRepositoryNamespace(),
            '{{controllerNamespace}}'       => $this->getControllerNamespace(),
            '{{requestNamespace}}'          => $this->getRequestNamespace(),
            '{{moduleLower}}'               => $this->getModuleLower(),
            '{{modelNamePluralLowerCase}}'  => $this->getModelNamePluralLowerCase(),
            '{{modelNamePluralUpperCase}}'  => $this->getModelNamePluralUpperCase(),
            '{{modelNameLowerCase}}'        => $this->getModelNameLowerCase(),
            '{{modelRoute}}'                => $this->getRouterName(),
            '{{modelView}}'                 => $this->getPathViewsName(),
        ];
    }

    /**
     * Get the DB Table columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (empty($this->tableColumns)) {
            $this->tableColumns = DB::select('SHOW COLUMNS FROM ' . $this->getTabela());
        }

        return $this->tableColumns;
    }

    /**
     * Obtenha o nome da tabele da entrada.
     *
     * @return string
     */
    protected function getTabela()
    {
        return trim($this->argument('tabela'));
    }

    /**
     * Obtenha o nome do modulo da entrada.
     *
     * @return string
     */
    protected function getModulo()
    {
        return trim($this->argument('modulo'));
    }

    /**
     * Obtenha o alias que será usado em substituição ao nome da tabela.
     *
     * @return string
     */
    protected function getNome()
    {
        if($this->hasOption('alias') && !is_null($this->option('alias'))){
            return $this->_buildClassName($this->option('alias'));
        }
        return $this->_buildClassName($this->getTabela());
    }

    /**
     * @param string $name
     * @return string
     */
    protected function _buildClassName($name)
    {
        return Str::studly(Str::singular($name));
    }

    /**
     * Obter os argumentos de comando do console.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['tabela', InputArgument::REQUIRED, 'O nome da tabela.'],
            ['module', InputArgument::REQUIRED, 'O nome do modulo.'],
        ];
    }

    /**
     * Verifica se a tabela existe.
     *
     * @return mixed
     */
    protected function tableExists()
    {
        return Schema::hasTable($this->getTabela());
    }

    /**
     * Get the stub file.
     *
     * @param string $type
     * @param boolean $content
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function getStub($type, $content = true)
    {
        $path = __DIR__ . "/../stubs/{$type}.stub";

        if (!$content) {
            return $path;
        }

        return $this->files->get($path);
    }

    /**
     * @param $no
     *
     * @return string
     */
    private function _getSpace($no = 1)
    {
        $tabs = '';
        for ($i = 0; $i < $no; $i++) {
            $tabs .= "\t";
        }

        return $tabs;
    }
}

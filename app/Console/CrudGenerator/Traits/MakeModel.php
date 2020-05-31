<?php

namespace App\Console\CrudGenerator\Traits;

use App\Console\CrudGenerator\ModelGenerator;
use Illuminate\Support\Str;

trait MakeModel
{

    /**
     * Make model attributes/replacements.
     *
     * @return array
     */
    protected function modelReplacements()
    {
        $properties = '*';
        $primaryKey = 'id';
        $fieldMap = '';
        $softDeletesNamespace = $softDeletes = '';

        foreach ($this->getColumns() as $value) {

            $type = 'string';
            if (Str::is('*int*', $value->Type)) {
                $type = 'int';
            } else if (Str::is('*date*', $value->Type)) {
                $type = '\DateTime';
            }
            if ($value->Key == 'PRI') {
                $properties .= "\n * @property $type ".'$id';
            } else {
                $properties .= "\n * @property $type $".$this->normalizeName($value->Field);
            }

            if ($value->Key == 'PRI') {
                $primaryKey = $value->Field;
                $fieldMap .= "\n\t\t'id' => '{$value->Field}',";
            } else {
                $fieldMap .= "\n\t\t'".$this->normalizeName($value->Field)."' => '{$value->Field}',";
            }

            if ($value->Field == 'deleted_at') {
                $softDeletesNamespace = "use Illuminate\Database\Eloquent\SoftDeletes;\n";
                $softDeletes = "use SoftDeletes;\n";
            }
        }

        $properties .= "\n *";

        list($relations, $properties) = (new ModelGenerator($this->getTabela(), $properties, $this->getModelNamespace()))->getEloquentRelations();

        return [
            '{{relations}}' => $relations,
            '{{table}}' => $this->getTabela(),
            '{{primaryKey}}' => $primaryKey,
            '{{fieldMap}}' => $fieldMap,
            '{{properties}}' => $properties,
            '{{softDeletesNamespace}}' => $softDeletesNamespace,
            '{{softDeletes}}' => $softDeletes,
        ];
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function _getModelPath($name)
    {
        return $this->makeDirectory($this->_spacePath($this->modelNamespace) . "/{$name}.php");
    }

    /**
     * Cria o Model class
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildModel()
    {
        $modelPath = $this->_getModelPath($this->getNome());

        if ($this->files->exists($modelPath) && $this->ask('Já existe uma Model com esse nome. Deseja sobreescrever (s/n)?', 's') == 'n') {
            return $this;
        }

        $this->info('Criando o Model ...');

        $replace = array_merge($this->buildReplacements(), $this->modelReplacements());

        $modelTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Model')
        );

        $this->write($modelPath, $modelTemplate);

        return $this;
    }
}

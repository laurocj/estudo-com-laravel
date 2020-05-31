<?php

namespace App\Console\CrudGenerator\Traits;

use Illuminate\Support\Str;

trait MakeService
{
    /**
     * @return array
     */
    protected function replaceAttributes()
    {
        $params = "";
        $attributes = "";
        foreach ($this->getColumns() as $value) {

            if(in_array($value->Field,['id','created_at','updated_at','deleted_at']))
                continue;

            if (Str::is('*int*', $value->Type)) {
                $param = "int";

            } else
            if (Str::is('*bouble*', $value->Type) ||
                Str::is('*float*', $value->Type) ||
                Str::is('*decimal*', $value->Type)) {
                $param = "float";
            } else
                $param = "string";


            $name = $this->normalizeName($value->Field);

            $attributes .= "\n\t\t$".$this->getModelNameLowerCase()."->".$name." = $".$name.";";


            $params .= "\n\t\t".$param." $".$name.",";
       }

       $params = Str::replaceLast(',','',$params);

       return [
           '{{attributes}}' => $attributes,
           '{{params}}' => $params
       ];
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function _getServicePath($name)
    {
        return $this->makeDirectory($this->_spacePath($this->serviceNamespace) . "/{$name}Service.php");
    }

    /**
     * Cria Service Class.
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildService()
    {
        $servicePath = $this->_getServicePath($this->getNome());

        if ($this->files->exists($servicePath) && $this->ask('Já existe uma Service com esse nome. Deseja sobreescrever (s/n)?', 's') == 'n') {
            return $this;
        }

        $this->info('Criando a service ...');

        $replace = array_merge($this->buildReplacements(),$this->replaceAttributes());

        $serviceTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Service')
        );

        $this->write($servicePath, $serviceTemplate);

        return $this;
    }
}

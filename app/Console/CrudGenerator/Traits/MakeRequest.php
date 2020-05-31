<?php

namespace App\Console\CrudGenerator\Traits;

use App\Support\Assistant;
use Illuminate\Support\Str;

trait MakeRequest
{
    /**
     * Obtem as regras de validação
     * @return array
     */
    protected function replaceValidade()
    {
        $rules = '';
        foreach ($this->getColumns() as $value) {

            if(in_array($value->Field,['id','created_at','updated_at','deleted_at']))
                continue;

            $rule = [];
            if ($value->Null == 'NO') {
                $rule[] = "required";
            } else {
                $rule[] = "nullable";
            }

            if (Str::is('*int*', $value->Type)) {
                $rule[] = "numeric";
            }

            if (Str::is('*date*', $value->Type)) {
                $rule[] = "date_format:d/m/Y";
            }

            if (Str::is('varchar*', $value->Type) || Str::is('char*', $value->Type)) {
                $rule[] = "string|max:".Assistant::onlyNumber($value->Type);
            }

            if (Str::is('text*', $value->Type)) {
                $rule[] = "string";
            }

            $rules .= "\n\t\t\t'".$this->normalizeName($value->Field)."' => '".implode("|",$rule)."',";
       }

       return [
           '{{rules}}' => $rules
       ];
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function _getRequestPath($name)
    {
        return $this->makeDirectory($this->_spacePath($this->requestNamespace) . "/{$this->getNome()}/{$this->getNome()}{$name}.php");
    }

    /**
     * Cria os Requests Class
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRequest()
    {
        $this->info('Criando os Request ...');

        $replace = array_merge($this->buildReplacements(),$this->replaceValidade());

        foreach (['StoreRequest', 'UpdateRequest'] as $request) {
            $requestTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub("requests/{$request}")
            );

            $this->write($this->_getRequestPath($request), $requestTemplate);
        }

        return $this;
    }
}

<?php

namespace App\Console\CrudGenerator\Traits;

use Illuminate\Support\Str;

trait MakeViews
{
    /**
     * @param $view
     *
     * @return string
     */
    protected function _getViewPath($view)
    {
        $name = Str::kebab($this->getNome());

        return $this->makeDirectory($this->_spacePath("Resources/views/{$name}/{$view}.blade.php"));
    }

    /**
     * Cria as Views
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildViews()
    {
        $this->info('Criando as Views ...');

        $replace = $this->buildReplacements();

        foreach (['index', 'create', 'edit'] as $view) {
            $viewTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub("views/{$view}")
            );

            $this->write($this->_getViewPath($view), $viewTemplate);
        }

        return $this;
    }

    /**
     * Build the form fields for form.
     *
     * @param $title
     * @param $column
     * @param string $type
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function getField($title, $column, $type = 'form-field')
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{title}}' => $title,
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace), array_values($replace), $this->getStub("views/{$type}")
        );
    }

    /**
     * @param $title
     *
     * @return mixed
     */
    protected function getHead($title)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{title}}' => $title,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $this->_getSpace(10) . '<th>{{title}}</th>' . "\n"
        );
    }

    /**
     * @param $column
     *
     * @return mixed
     */
    protected function getBody($column)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{column}}' => $column,
        ]);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $this->_getSpace(11) . '<td>{{ ${{modelNameLowerCase}}->{{column}} }}</td>' . "\n"
        );
    }
}

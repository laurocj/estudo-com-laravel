<?php

namespace App\Support;

class Assistant
{
    /**
     * @param string|null $string
     * @return string
     */
    public static function standardizeName(?string $string)
    {
        if(empty($string)) return $string;

        $ignore = array('do', 'dos', 'da', 'das', 'de');
        $out = '';
        foreach (explode(' ', mb_strtolower($string, 'UTF-8')) as $word) {
            $out .= (in_array($word, $ignore) ? $word : mb_convert_case($word, MB_CASE_TITLE, "UTF-8")) . ' ';
        }
        return trim($out);
    }

    /**
     * @param String $string
     *
     * @return numeric
     */
    public static function onlyNumber($string)
    {
        return is_null($string) || empty($string) ? trim($string) : preg_replace('/[^0-9]/', '', $string);
    }

    /**
     * @param String $data Y-m-d ou Y-m-d H:i:s
     *
     * @return String d/m/Y ou d/m/Y H:i:s
     */
    public static function dateFormatBR($data)
    {
        if(!$data) { return $data; }

        $dataHora = explode(' ',$data);
        return implode('/',array_reverse(explode('-',$dataHora[0]))) . (isset($dataHora[1]) ? ' ' . $dataHora[1] : '');
    }

    /**
     * @param String $data d/m/Y ou d/m/Y H:i:s
     *
     * @return String Y-m-d ou Y-m-d H:i:s
     */
    public static function dateFormatIso($data)
    {
        if(!$data) { return $data; }

        $dataHora = explode(' ',$data);
        return implode('-',array_reverse(explode('/',$dataHora[0]))) . (isset($dataHora[1]) ? ' ' . $dataHora[1] : '');
    }

    /**
     * @param string $number
     *
     * @return string
     */
    public static function money($number)
    {
        $number = static::onlyNumber($number);
        if(strlen($number) < 3) {
            $number = sprintf("%03d", $number);
        }
        $number = $number/100;
        return number_format($number, 2, ',', '.');
    }

    /**
     * Mask cnpj
     * @param string $string
     */
    public static function cnpj($string)
    {
        return static::mask("##.###.###/####-##",static::onlyNumber($string));
    }

    /**
     * Aplica uma mask a uma palavra.
     *
     * @param string $mask ex.: ###.###.###-## ou money
     * @param string $word
     * @param bool $precise se a word form maior que a mask, ela não será concatenada com o restante da word já com a mask
     *
     * @return string
     */
    public static function mask($mask, $word, $precise = false)
    {
        $word = str_replace(" ","", (string) $word);

        if($mask == 'money') {
            return static::money($word);
        }

        if(empty($word)) return $word;

        for($i=0; $i < strlen($word); $i++) {
            if(($pos = strpos($mask,"#")) !== false) {
                $mask[$pos] = $word[$i];
            } else if(!$precise) {
                $mask .= $word[$i];
            }
        }

        return $mask;

    }
}

<?php


namespace App\Traits;


use Illuminate\Http\Request;

trait QueryToString
{
    private function convertQueryToString(Request $request): string
    {
        $string = 'query.';
        $arrayKeys = $request->all();
        foreach (array_keys($arrayKeys) as $key){
            $string .= $key . '=' . $request->get($key);
        }

        return $string;
    }
}
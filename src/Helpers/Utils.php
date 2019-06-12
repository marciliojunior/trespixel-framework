<?php


namespace trespixel\framework\Helpers;

use Carbon\Carbon;

class Utils
{
    /**
     * @param $data
     * @return Carbon Date
     */
    public static function toDate($data) : Carbon
    {
        if(!is_string($data)){
            return $data;
        }
        elseif(empty($data)){
            return null;
        }
        $data = preg_replace("/_/", "", $data);
        $data = preg_replace("/ :/", "", $data);
        $data = trim($data);

        //Array de formatos
        $form_data = array(
            "/\d{12}/" => ['format' => "dmYHi", 'hastime' => true],
            "/\d{8}/" => ['format' => 'dmY', 'hastime' => false],
            "/\d{6}/" => ['format' => 'dmy', 'hastime' => false],
            "/\d{2}\/\d{2}\/\d{4}/" => ['format' => 'd/m/Y', 'hastime' => false],
            "/\d{2}\/\d{2}\/\d{2}/" => ['format' => 'd/m/y', 'hastime' => false],
            "/\d{4}\/\d{2}\/\d{2}/" => ['format' => 'Y/m/d', 'hastime' => false],
            "/\d{4}-\d{2}-\d{2}/" => ['format' => 'Y-m-d', 'hastime' => false]
        );
        $form_hora = array(
            "/\d{2}:\d{2}:\d{2}/" => "H:i:s",
            "/\d{2}:\d{2}/" => "H:i"
        );

        $hastime = false;
        $dat_format = '';
        $hor_format = '';
        foreach ($form_data as $patt => $val) {
            if(preg_match($patt, $data)){
                $dat_format = $val['format'];
                $hastime = $val['hastime'];
                $hor_format = !$hastime ? 'H:i:s' : '';
                break;
            }
        }
        foreach ($form_hora as $patt => $val) {
            if(preg_match($patt, $data)){
                $hor_format = $val;
                $hastime = true;
                break;
            }
        }
        if(!empty($dat_format)){
            $data .= !$hastime ? ' 23:59:59' : '';
            $final_format = trim($dat_format.' '.$hor_format);
            $date = Carbon::createFromFormat($final_format, $data);
            if($date && $date->format($final_format) == $data)
                return $date;
        }
        return null;
    }
}

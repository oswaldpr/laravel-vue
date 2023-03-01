<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TolleController extends Controller
{
    public static function index()
    {
        $char = 'alkdflh0lkjskj@lojh4KLJDF9u2réjhcsKJufdjkh32eo29872$H#%56hisd79782uH$3HKré8719u32NHDFhjsikjfkdhh45988uwkndsré8uSKNDsKDJHufh3#%(*9csré89usÀsch)lhdsjsdH@@$H$#jKh110dskné983737usjhsdkjwhrKHJFDJHFIhckjbcaALHLKHœKLHAOPaoödsgiudjdmcCNBK$';

        // 1 - On doit pouvoir déterminer le pourcentage de caractères spéciaux VS les lettres et chiffres de la chaîne
        $noHtmlChar = self::removeSpecialCharacter($char);
        $defaultCount = strlen($char);
        $count = strlen($noHtmlChar);

        $normalPercent = self::percent($defaultCount, $count);
        $htmlPercent = 100 - $normalPercent;

        // 2 - On doit retourner l'addition de tous les nombres qui se situent entre chaque occurrence des caractères "ré" et "u"
        // En effet au debut j'étais parti sur l'idée de parcourir la chaine de caractère tout en ressortant les intervalles (d'où les deux dernières fonctions)
        // Mais je je me suis rendu compte que ca allait prendre plus de ressources que le spliter directement et y aller par occurrences
        $list = self::findList($char, 'ré', 'u');
        $total = 0;
        foreach ($list as $line) {
            $total = $total + $line;
        }

        // 3 - On doit pouvoir transformer la chaîne en majuscule
        $uppercase = strtoupper($char);

        // 4 - On doit pouvoir retourner un tableau illustrant chaque caractère unique et le nombre d'occurrences de chaque caractère, trié en ordre décroissant de nombre d'occurrences
        $occurrences = self::findCharOccurrences($char);

        $data = array(
            'normalPercent' => $normalPercent,
            'htmlPercent' => $htmlPercent,
            'total' => $total,
            'uppercase' => $uppercase,
            'occurrences' => $occurrences,
        );

        return view('tolle', ['data' => $data]);
    }

    public static function removeSpecialCharacter($string): string
    {
        $string = str_replace(' ', '-', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public static function percent(int $total, int $numb): float
    {
        $percent = $numb * 100 / $total;
        return (float)number_format((float)$percent, 2, '.', '');
    }

    public static function findList(string $source, string $strStart, string $strEnd): array
    {
        $exp = explode($strStart, $source);
        $startWith = str_starts_with($source, 'ré');
        if(!$startWith){
            array_shift($exp);
        }

        $intervalList = [];
        foreach ($exp as $occur) {
            $expChild = explode($strEnd, $occur);
            if($expChild && preg_match('~[0-9]+~', $expChild[0])){
                $num = preg_replace("/[^0-9]/", '', $expChild[0]);
                $intervalList[] = (int)$num;
            }
        }

        return $intervalList;
    }

    public static function findCharOccurrences(string $source): array
    {
        $definition = array(
            'unique' => [],
        );

        $chars = str_split($source);
        foreach($chars as $char){
            $count = substr_count($source,$char);
            $definition[$char] = $count;
            if($count === 1 && !in_array($char, $definition['unique'])){
                $definition['unique'][] = $char;
            }
        }
        arsort($definition);

        return $definition;
    }

    public static function findSingleInterval(string $source, string $strStart, string $strEnd): ?array
    {
        $str = self::removeBeginning($source, $strStart);
        $posEnd = strpos($str, $strEnd);
        if(!$posEnd){
            return array(
                'interval' => null,
                'strLeft' => null,
            );
        }
        $exp = explode($strEnd, $str);

        return array(
            'interval' => $exp[0],
            'strLeft' => substr($str, 0, -$posEnd),
        );
    }

    public static function removeBeginning(string $source, string $strStart): string
    {
        $posStart = strpos($source, $strStart);

        $output = '';
        if (substr($source, $posStart, strlen($strStart)) == $strStart) {
            $output = substr($source, $posStart + strlen($strStart));
        }
        return $output;
    }
}

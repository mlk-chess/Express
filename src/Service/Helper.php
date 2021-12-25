<?php

namespace App\Service;

class Helper
{

    static public function readJsonFile($file): array
    {

        $data = file_get_contents($file);
        $obj = json_decode($data,true);

        foreach ($obj as $value){
            $stations[$value['Nom_Gare']] = $value['Nom_Gare'];
        }

        return $stations;
    }

    static public function checkStationJsonFile($name): bool
    {

        $stations = self::readJsonFile("../public/stations.json");
        return in_array($name,$stations);
    }

    static public function getLineByName($file,$name){

        $data = file_get_contents($file);
        $obj = json_decode($data,true);

        foreach ($obj as $value){
           if ($value['Nom_Gare'] == $name){
               return $value;
           }
        }
        return null;
    }

}
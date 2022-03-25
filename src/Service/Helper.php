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

    static public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $radlat1 = pi() * $lat1/180;
            $radlat2 = pi() * $lat2/180;
            $theta = $lon1-$lon2;
            $radtheta = pi() * $theta/180;
            $dist = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
            if ($dist > 1) {
                $dist = 1;
            }
            $dist = acos($dist);
            $dist = $dist * 180/pi();
            $dist = $dist * 60 * 1.1515;
            if ($unit=="K") $dist = $dist * 1.609344;
            if ($unit=="N") $dist = $dist * 0.8684 ;
            return $dist;
        }
    }
    

}
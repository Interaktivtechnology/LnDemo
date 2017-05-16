<?php


namespace app\components;

class Helper{

	public static function GetMonthName($month, $format = 'F'){
		return date($format, strtotime(Date('Y')."-".$month.'-01'));
	}


	public static function GetSGIdType($id_no){
		$nric_pattern =  '/([S|T]{1}[0-9]{7}[a-zA-Z]{1})/';
        if(preg_match($nric_pattern,$id_no))
            return 'NRIC';

        $fin_pattern =  '/([G|F]{1}[0-9]{7}[a-zA-Z]{1})/';
        if(preg_match($fin_pattern, $id_no))
        	return "FIN";

        $uen_pattern = '/([0-9]{8,9}[a-zA-Z]{1})/';
        $uen_pattern2 = '/([T][0-9]{2}[a-zA-Z]{2}[0-9]{4}[a-zA-Z]{1})/';
        if(preg_match($uen_pattern, $id_no) || preg_match($uen_pattern2, $id_no))
            return 'UEN';

        return "OTHERS";
	}


	public static function getFileDelimiter($file, $checkLines = 2)
	{
        $file = new \SplFileObject($file);
        $delimiters = array(
          ',',
          '\t',
          ';',
          '|',
          ':'
        );
        $results = array();
        $i = 0;

         while(!$file->eof() && $i <= $checkLines){
            try{
                $line = $file->fgets();
                foreach ($delimiters as $delimiter){
                    $regExp = '/['.$delimiter.']/';
                    $fields = preg_split($regExp, $line);
                    if(count($fields) > 1){
                        if(!empty($results[$delimiter])){
                            $results[$delimiter]++;
                        } else {
                            $results[$delimiter] = 1;
                        }
                    }
                }
            }
            catch(Exception $ex){

            }

           $i++;
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }

    public static function getUsersJson(){
        $json   = file_get_contents("../assets/users.json");
        $users  = json_decode($json, true);

        return $users;
    }

    public static function validateNRIC($str){
        if (strlen($str) != 9)
        return false;

        $str = strtoupper($str);
        $i = array();
        $icArray = array();
        for($i = 0; $i < 9; $i++) {
            $icArray[$i] = $str[$i];
        }
        $icArray[1] = $icArray[1] * 2;
        $icArray[2] = $icArray[2] * 7;
        $icArray[3] = $icArray[3] * 6;
        $icArray[4] = $icArray[4] * 5;
        $icArray[5] = $icArray[5] * 4;
        $icArray[6] = $icArray[6] * 3;
        $icArray[7] = $icArray[7] * 2;
        $weight = 0;
        for($i = 1; $i < 8; $i++) {
            $weight += $icArray[$i];
        }
        $offset = ($icArray[0] == "T" || $icArray[0] == "G") ? 4:0;
        $temp = ($offset + $weight) % 11;
        $st = ["J","Z","I","H","G","F","E","D","C","B","A"];
        $fg = ["X","W","U","T","R","Q","P","N","M","L","K"];
        if ($icArray[0] == "S" || $icArray[0] == "T") {
            $theAlpha = $st[$temp];
        }
        else if ($icArray[0] == "F" || $icArray[0] == "G") {
            $theAlpha = $fg[$temp];
        }
        if($icArray[8] === $theAlpha){
            return true;
        }
        else{
            return false;
        }
    }


    public static function getAllCountries(){
        return [
            'Singapore',
            'Malaysia',
            'Qatar',
            'Hong',
            "S'pore",
            "Spore",
            "S'PORE"
        ];

    }

}

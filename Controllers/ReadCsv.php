<?php namespace Controllers;

class ReadCsv {

    public $countcontent;
    public $countheader;
    
    public function getCsv ($file) {
        $getfile = fopen($file, "r");
        $content = []; //contenido del csv
        $csv = [];
        $header = [];
        while(($datafile = fgetcsv($getfile, 1500, ";")) !== false) {
            if(count($header) == 0) {
                foreach($datafile as $value) {
                    array_push($header, $value);
                }
            } else {
                $temp=[];
                foreach ($datafile as $value) {
                    array_push($temp, $value);
                }
                $res=[];
                for($i=0;$i<count($header);$i++) {
                    array_push($res, $temp[$i]);
                }
                array_push($csv, $res);
            }   
        }
        fclose($getfile);
        $this->countcontent = count($csv);
        $arraycontent = compact('header','csv');
        return $arraycontent;
    }

}
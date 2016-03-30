<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 25/02/2016
 * Time: 17:26
 */

namespace api\controller;
require_once('/var/www/app/libs/runeaudio.php');

class testController
{
    public static function test($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $socket = openMpdSocket('/run/mpd.sock');
        sendMpdCommand($socket, 'playlistinfo');
        $infos = readMpdResponse($socket);
        $obj = array("infos" => self::parsePlaylist($infos));
        echo json_encode($obj);
    }

    public static function test3($app)
    {
        $data = $app->request->getBody();
        $key = json_decode($data);
        if(isset($key[0]->dir)){
            $dir = '/mnt/MPD/USB/'.$key[0]->dir;
        }else{
            $dir = '/mnt/MPD/USB/';
        }
        //     $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        $files1 = scandir($dir);
        $arr = [];
        foreach($files1 as $file){
            array_push($arr, array("name" => $file));
        }
        $obj = array(
            "root" => $key[0]->dir,
            "dir" => $arr
        );


        echo json_encode($obj);
    }

    public static function parsePlaylist($resp)
    {
        if (is_null($resp)) {
            return null;
        } else {
            $dirCounter=-1;
            $plistArray = array();
            $plistLine = strtok($resp, "\n");
            // $plistFile = "";
            $plCounter = -1;
            $browseMode = TRUE;
            while ($plistLine) {
                if($plistLine == "OK")
                    break;
                // list ( $element, $value ) = explode(": ",$plistLine);
                if (!strpos($plistLine, '@eaDir')) list ($element, $value) = explode(': ', $plistLine, 2);
                if ($element === 'file' OR $element === 'playlist') {
                    $plCounter++;
                    $browseMode = FALSE;
                    // $plistFile = $value;
                    $plistArray[$plCounter][$element] = $value;
                    $plistArray[$plCounter]['fileext'] = parseFileStr($value, '.');
                } elseif ($element === 'directory') {
                    $plCounter++;
                    // record directory index for further processing
                    $dirCounter++;
                    // $plistFile = $value;
                    $plistArray[$plCounter]['directory'] = $value;
                } else if ($browseMode) {
                    if ($element === 'Album') {
                        $plCounter++;
                        $plistArray[$plCounter]['album'] = $value;
                    } else if ($element === 'Artist') {
                        $plCounter++;
                        $plistArray[$plCounter]['artist'] = $value;
                    } else if ($element === 'Genre') {
                        $plCounter++;
                        $plistArray[$plCounter]['genre'] = $value;
                    }
                } else {
                    $plistArray[$plCounter][$element] = $value;
//                    $plistArray[$plCounter]['Time2'] = songTime($plistArray[$plCounter]['Time']);
                }
                $plistLine = strtok("\n");
            }
        }
        return $plistArray;
    }
}
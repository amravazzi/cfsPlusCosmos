<?php
/**
 * Watchdog controller
 */
namespace App\Http\Controllers;

use App\Controllers\FirebaseController;
use App\Http\Controllers\FirebaseController as Firebase;

class WatchdogController extends Controller {

    protected $replacementArray;

    function __construct()
    {
      $this->replacementArray = [
                                  'Target: ',
                                  'TIME_AT_PI:',
                                  'TEMP:',
                                  'LIGHT:',
                                  ' C',
                                  "\t"
                               ];
    }

    private function getFullPath($path)
    {
      $fullPath = base_path().  '/public/' . $path . '/';
      return $fullPath;
    }

    private function getMostRecentFile($path)
    {
      $allFiles = scandir($this->getFullPath($path), SCANDIR_SORT_DESCENDING);
      return $allFiles[0];
    }

    public function readFromTxt($path)
    {
      $mostRecentFile = $this->getMostRecentFile($path);

      $fh = fopen($this->getFullPath($path) . $mostRecentFile, 'r');

      $i = 0;

      while ($line = fgets($fh)) {
        $fullContent[$i] = $line;
        $i++;
      }

      fclose($fh);

      $a = $this->cleanContent($fullContent);

      return $this->serializeContent($a);
    }

    public function readFromPost(\Illuminate\Http\Request $request)
    {

      $fullContent = $request->json()->get('data');

      $a = $this->cleanContent($fullContent);

      return $this->serializeContent($a);
    }

    private function cleanContent($content)
    {

        if((strpos($content, 'TIME_AT_PI') !== false) ||
           (strpos($content, 'Target') !== false))
        {
          $cleanContent = str_replace($this->replacementArray, '', $content);
        }

      return $cleanContent;
    }

    private function serializeContent($content)
    {

        $serializedContent = explode(' ', str_replace("\n", '' , $content));

        $serializedContent[0] = $serializedContent[0] . '-' . str_replace(':', '-', $serializedContent[1]) . '-' . $serializedContent[2];
        $serializedContent[1] = null;
        $serializedContent[2] = null;


        // $serializedContentFinal[$i] = array_values(array_filter($serializedContent[$i]));
        // $serializedContentFinal[$i][3] = "false";

        $serializedContentFinal = array_values(array_filter($serializedContent));
        $serializedContentFinal[3] = "false";

      return $serializedContentFinal;
    }

    public function setContentOnFirebase(\Illuminate\Http\Request $request, Firebase $firebase)
    {
      $data = $this->readFromPost($request);

      //dd($data);

      for($i=0; $i<=sizeof($data); $i++)
      {
        $finalData = array(
          'temp' => $data[1],
          'light' => $data[2],
          'status' => $data[3]
        );
      }

      $fb = $firebase->firebaseCreate($data[0], $finalData);

      return $fb;
      //return $fb;
    }


}

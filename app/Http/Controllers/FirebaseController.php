<?php
/**
 * Firebase controller
 */
namespace App\Http\Controllers;

use \Firebase;

class FirebaseController extends ApiController {

    protected $firebase;

    function __construct()
    {
        $this->firebase = new \Firebase\FirebaseLib(env('FIREBASE_DB_URL'), env('FIREBASE_SECRET'));
    }
    
    public function firebaseRoot()
    {
      return $this->firebase->get('/');
    }

    public function firebaseIndex($path)
    {
      return $this->firebase->get('/data/' . $path);
    }

    public function firebaseCreate($path, $data)
    {
      return $this->firebase->set('/data/' . $path, $data);
    }

    public function firebaseUpdate($path, $data)
    {
      return $this->firebase->update('/data/' . $path, $data);
    }

}

<?php
/*-------------------------------------------------\
 * Created by TrioDesign (trio@tgitriodesign.com).
 * Date: 11/26/13
 * Time: 2:58 PM
 *
 \------------------------------------------------*/

namespace Skully\App\Session;

use RedBean_Facade as R;
use Skully\Core\ApplicationAware;

/**
 * Class DBSession
 * Instead of storing data directly in $_SESSION variable, we can use this class
 * to store data in session database instead using key from session_id()
 * @package App\Session
 */
class DBSession extends ApplicationAware implements SessionInterface{

    /**
     * @var null|\Skully\App\Models\Session
     */
    private $sessionModel = null;

    public function __construct($app)
    {
        $this->setApp($app);
        return $this;
    }

    /**
     * @return \Skully\App\Models\Session
     */
    public function getSessionModel(){
        //read session with current session id
        // todo: empty($this->sessionModel) is required to keep connection to db as low as possible,
        //       but somehow enabling this make session disappears on new page.
//        if(empty($this->sessionModel)){
            //echo "try to find with session id: ". session_id() . "\n";
            $sessionBean = R::findOne('session', "session_id = ?", array(session_id()));
            if(empty($sessionBean)){
                //echo "create with session id: ". session_id()."\n";
                $this->sessionModel = $this->app->createModel('session', array(
                    "session_id" => session_id()
                ));
                R::store($this->sessionModel);
                //echo "after creation, session model is".get_class($this->sessionModel)."\n";
            }
            else {
                $this->sessionModel = $sessionBean->box();
            }
//        }
//        else {
            //echo "this sessionModel not empty, data is ".$this->sessionModel->get('data');
//        }

        return $this->sessionModel;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get( $key = "" ){
        $sessionModel = $this->getSessionModel();
        $data = json_decode($sessionModel->get('data'), true);

        if(empty($key)) return $data;
        if (!isset($data[$key])) {
            return null;
        }
        return $data[$key];
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function has( $key ){
        $sessionModel = $this->getSessionModel();
        $dataJson = $sessionModel->get('data');
        if (!empty($dataJson)) {
            $data = json_decode($dataJson, true);
        }
        else {
            $data = array();
        }
        return isset($data[$key]);
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    public function set( $key, $value )
    {
        $data = $this->get();
        $data[$key] = $value;
        $this->sessionModel = $this->getSessionModel();
        $dataJson = json_encode($data);
        $this->sessionModel->set('data', $dataJson);
        R::store($this->sessionModel);
    }

    public function remove($key)
    {
        $data = $this->get();
        unset($data[$key]);
        $this->sessionModel = $this->getSessionModel();
        $dataJson = json_encode($data);
        $this->sessionModel->set('data', $dataJson);
        R::store($this->sessionModel);
    }

}
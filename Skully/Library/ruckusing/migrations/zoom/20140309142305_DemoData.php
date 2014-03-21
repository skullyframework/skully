<?php

require_once(dirname(__FILE__)."/../../../../bootstrap.php");

use RedBean_Facade as R;

class DemoData extends Ruckusing_Migration_Base
{
    public function up()
    {
        $app = __setupApp();
        $about = $app->createModel('about', array(
            'title' => 'OUR PROFILE',
            'intro_image' => 'our_profile.png',
            'image' => 'our_profile-detail.png'
        ));
        R::store($about);
        $about = $app->createModel('about', array(
            'title' => 'SERVICE',
            'intro_image' => 'service.png',
            'image' => 'service-detail.png'
        ));
        R::store($about);
        $about = $app->createModel('about', array(
            'title' => 'CAREER',
            'intro_image' => 'career.png',
            'image' => 'career-detail.png'
        ));
        R::store($about);
    }//up()

    public function down()
    {
    }//down()
}

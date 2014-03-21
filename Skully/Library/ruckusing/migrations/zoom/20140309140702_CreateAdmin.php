<?php

use App\Models\Admin;
use RedBean_Facade as R;

class CreateAdmin extends Ruckusing_Migration_Base
{
    public function up()
    {
        $app = __setupApp();
        $admin = $app->createModel('admin', array(
            'name' => 'Admin',
            'email' => 'admin@zoomsmarthotels.com',
            'password' => 'passw0rd',
            'password_confirmation' => 'passw0rd',
            'status' => Admin::STATUS_ACTIVE
        ));
        R::store($admin);
    }//up()

    public function down()
    {
    }//down()
}

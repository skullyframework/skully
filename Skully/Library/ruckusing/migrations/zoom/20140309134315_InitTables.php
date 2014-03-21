<?php

class InitTables extends Ruckusing_Migration_Base
{
    public function up()
    {
        $t = $this->create_table('about', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('title', 'text');
        $t->column('intro_image', 'string');
        $t->column('image', 'string');
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('room', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('title', 'text');
        $t->column('intro_image', 'string');
        $t->column('images', 'text');
        $t->column('panoramic_image', 'string');
        $t->column('is_active', 'boolean', array('default' => true));
        $t->column('position', 'integer', array('default' => 0));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('facility', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('title', 'text');
        $t->column('intro_image', 'string');
        $t->column('images', 'text');
        $t->column('is_active', 'boolean', array('default' => true));
        $t->column('position', 'integer', array('default' => 0));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('news', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('title', 'text');
        $t->column('url', 'string', array('length' => 100));
        $t->column('content', 'text');
        $t->column('intro_image', 'string');
        $t->column('images', 'text');
        $t->column('date', 'date');
        $t->column('is_active', 'boolean', array('default' => true));
        $t->column('position', 'integer', array('default' => 0));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('location', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('name', 'string');
        $t->column('description', 'text');
        $t->column('address', 'string');
        $t->column('city', 'string');
        $t->column('country', 'string');
        $t->column('lat', 'decimal', array('scale' => 10, 'precision' => 15));
        $t->column('lng', 'decimal', array('scale' => 10, 'precision' => 15));
        $t->column('phone', 'string', array('length' => 40));
        $t->column('email', 'string', array('length' => 100, 'default' => 'info@zoomsmarthotels.com'));
        $t->column('is_active', 'boolean', array('default' => true));
        $t->column('position', 'integer', array('default' => 0));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('admin', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('name', 'string', array('length' => 100));
        $t->column('email', 'string', array('length' => 100));
        $t->column('salt', 'string', array('length' => 10));
        $t->column('password_hash', 'string', array('length' => 64));
        $t->column('status', 'string', array('length' => 20));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('adminsession', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('admin_id', 'integer');
        $t->column('session_id', 'string', array('length' => 32));
        $t->column('created_at', 'timestamp');
        $t->column('updated_at', 'timestamp');
        $t->finish();

        $t = $this->create_table('setting', array('options' => 'Engine=InnoDB default charset=utf8 collate=utf8_unicode_ci'));
        $t->column('name', 'string', array('length' => 100));
        $t->column('value', 'text');
        $t->column('type', 'string', array('length' => 20, 'default' => 'string'));
        $t->column('is_client', 'boolean', array('default' => false));
        $t->column('input_type', 'string', array('length' => 20, 'default' => 'text'));
        $t->column('position', 'integer', array('default' => 0));
        $t->column('info', 'text');
        $t->finish();
    }//up()

    public function down()
    {
        $this->drop_table('about');
        $this->drop_table('room');
        $this->drop_table('facility');
        $this->drop_table('news');
        $this->drop_table('location');
        $this->drop_table('admin');
        $this->drop_table('adminsession');
        $this->drop_table('setting');
    }//down()
}

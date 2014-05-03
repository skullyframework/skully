<?php

class Setup extends Ruckusing_Migration_Base
{
    public function up()
    {
        $this->drop_table('foo');
        $this->drop_table('bar');
        $t = $this->create_table('foo');
        $t->column('name', 'string');
        $t->finish();
        $t = $this->create_table('bar');
        $t->column('title', 'string');
        $t->column('newscategory_id', 'integer');
        $t->finish();
    }//up()

    public function down()
    {
        $this->drop_table('foo');
        $this->drop_table('bar');
    }//down()
}

<?php

class SkullyInit extends Ruckusing_Migration_Base
{
    public function up()
    {
        $this->execute("
        drop table if exists `session`;
create table `session` (
  `id` int(11) not null auto_increment,
  `session_id` varchar(32) collate utf8_unicode_ci default null,
  `data` longtext collate utf8_unicode_ci,
  `created_at` timestamp,
  `updated_at` timestamp,
  primary key (`id`)
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;");
    }//up()

    public function down()
    {
    }//down()
}

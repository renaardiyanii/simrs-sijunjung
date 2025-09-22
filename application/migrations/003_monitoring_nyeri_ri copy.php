<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_monitoring_nyeri_ri extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'id_pemeriksa' => array(
                'type' => 'varchar',
            ),
            'no_ipd' => array(
                'type' => 'varchar',
                'constraint' => 12,
            ),
            'tgl' => array(
                'type' => 'timestamp',
            ),
            'formjson' => array(
                'type' => 'JSON',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('monitoring_nyeri_ri');
    }

    public function down()
    {
        $this->dbforge->drop_table('monitoring_nyeri_ri');
    }
}

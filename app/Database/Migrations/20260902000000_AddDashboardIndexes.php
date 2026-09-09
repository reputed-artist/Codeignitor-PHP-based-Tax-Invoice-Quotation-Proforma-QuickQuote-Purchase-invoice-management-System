<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDashboardIndexes extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE client ADD INDEX idx_client_created (created)');
        $this->db->query('ALTER TABLE invtest2 ADD INDEX idx_invtest2_created (created), ADD INDEX idx_invtest2_orderid (orderid), ADD INDEX idx_invtest2_cid (cid)');
        $this->db->query('ALTER TABLE invtest ADD INDEX idx_invtest_orderid (orderid), ADD INDEX idx_invtest_item_name (item_name)');
        $this->db->query('ALTER TABLE products ADD INDEX idx_products_name (name)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE client DROP INDEX idx_client_created');
        $this->db->query('ALTER TABLE invtest2 DROP INDEX idx_invtest2_created, DROP INDEX idx_invtest2_orderid, DROP INDEX idx_invtest2_cid');
        $this->db->query('ALTER TABLE invtest DROP INDEX idx_invtest_orderid, DROP INDEX idx_invtest_item_name');
        $this->db->query('ALTER TABLE products DROP INDEX idx_products_name');
    }
}
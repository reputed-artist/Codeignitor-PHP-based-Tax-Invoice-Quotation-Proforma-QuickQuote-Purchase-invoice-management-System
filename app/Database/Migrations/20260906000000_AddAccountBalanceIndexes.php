<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountBalanceIndexes extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE paidhistory ADD INDEX idx_paidhistory_cid (cid), ADD INDEX idx_paidhistory_cid_date (cid, dateofpayment), ADD INDEX idx_paidhistory_cid_amount (cid, amount)');
        $this->db->query('ALTER TABLE purchaseinv2 ADD INDEX idx_purchaseinv2_cid (cid), ADD INDEX idx_purchaseinv2_cid_invdate (cid, invdate), ADD INDEX idx_purchaseinv2_cid_total (cid, totalamount)');
        $this->db->query('ALTER TABLE invtest2 ADD INDEX idx_invtest2_cid_created (cid, created), ADD INDEX idx_invtest2_cid_total (cid, totalamount)');
        $this->db->query('ALTER TABLE account ADD INDEX idx_account_cid (cid)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE paidhistory DROP INDEX idx_paidhistory_cid, DROP INDEX idx_paidhistory_cid_date, DROP INDEX idx_paidhistory_cid_amount');
        $this->db->query('ALTER TABLE purchaseinv2 DROP INDEX idx_purchaseinv2_cid, DROP INDEX idx_purchaseinv2_cid_invdate, DROP INDEX idx_purchaseinv2_cid_total');
        $this->db->query('ALTER TABLE invtest2 DROP INDEX idx_invtest2_cid_created, DROP INDEX idx_invtest2_cid_total');
        $this->db->query('ALTER TABLE account DROP INDEX idx_account_cid');
    }
}
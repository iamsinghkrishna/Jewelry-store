<?php

class Report_model extends CI_Model {

	public function getWeeklyInventoryReport($start_date ,$end_date) {
		$weekinterval = 'YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)';
		$this->db->select("od.ord_det_item_name,od.ord_det_quantity,od.ord_det_id,os.ord_order_number,os.ord_date,pr.id,pr.quantity");
		$this->db->from("order_details as od");
		$this->db->join("order_summary as os",'od.ord_det_order_number_fk=os.ord_order_number','inner');
		$this->db->join("it_products as pr",'pr.id=od.ord_det_item_fk','right');
		$this->db->where('os.ord_status <>',1);
		$this->db->where('os.ord_status <>',6);
		$this->db->where('os.ord_status <>',5);
		if($start_date != "" && $end_date !=""){
			$this->db->where('os.ord_date >=',$start_date);
			$this->db->where('os.ord_date <=',$end_date);
		}else{
			$this->db->where('YEARWEEK(os.ord_date) = '.$weekinterval);
		}

		$query = $this->db->get();
        // echo $this->db->last_query();
        // die;
		return $query->result_array();
	}

}

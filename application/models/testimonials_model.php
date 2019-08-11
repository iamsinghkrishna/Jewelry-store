<?php

class testimonials_model extends CI_Model {

    public function getTestimonials() {

        $this->db->select("t.*");
        $this->db->from("mst_testimonial as t");
        // $this->db->join("mst_languages as lang",'lang.lang_id=t.lang_id','inner');
        $this->db->order_by('t.testimonial_id DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

}

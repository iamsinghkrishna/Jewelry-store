<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Model
{
    public $_table             = 'it_products';
    public $primary_key        = 'id';
    protected $soft_delete     = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id)
    {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    function get_product_by_category_id($categoryId = null,
                                        $subCategoryId = null, $start = null,
                                        $limit = null, $conditions = null,
                                        $subcatThird = null)
    {

        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id',
            'left');

        if (isset($categoryId) && $categoryId != null) {
            //$this->db->where_in($categoryId);
            $this->db->where("FIND_IN_SET('".$categoryId."',ip.category_id)");
            // $this->db->like('ip.category_id', $categoryId);
        }
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->join('it_product_attributes ipa',
                'ipa.product_id = ip.id', 'left');
            //$this->db->where_in('ipa.attribute_id', $subCategoryId);
            //  $this->db->where('$subCategoryId','FIND_IN_SET(ip.sub_category_id)');
            $this->db->where("FIND_IN_SET('$subCategoryId',ip.sub_category_id)");
            //$this->db->like('ip.sub_category_id', $subCategoryId);
        }
        if (isset($conditions) && $conditions != null) {
            $this->db->where('ip.is_instagram_product', '1');
        }
        if ($subcatThird != '' && $subcatThird != null) {
            $this->db->where("FIND_IN_SET('$subcatThird',ip.sub_attribute_id_new)");
        }
		$this->db->where('ip.price > 0');

//        if ($categoryId = null && $subCategoryId = null)
        if($subCategoryId == 39){
        $this->db->order_by('ip.initial_letter','ASC');
        }else{
        $this->db->order_by('ip.id', 'DESC');
        }
        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.product_name');
        //echo $start;die;
        if ($limit != '') {
            $this->db->limit($limit, $start);
        } else {
            $this->db->limit(6, 0);
        }
        $query  = $this->db->get();
        $query2 = $this->db->last_query();
        //$query2 = $this->db->get();
        $query2 = str_replace("IS NULL", '', $query2);
        //echo $query2;
        $query3 = $this->db->query($query2);

        return $query3->result_array();

        //echo $query2;
        // return $query2->result_array();
    }

    function get_product_by_category_page($categoryId = null, $start = 0, $limit)
    {

        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->join('it_product_attributes ipa',
                'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $subCategoryId);
        }
//        if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_product_by_count($categoryId = null)
    {
        $this->db->select('ip.*,ipm.*,count(ip.id) as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        // if (isset($subCategoryId) && $subCategoryId != null) {
        $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
        //$this->db->where('ipa.attribute_id', $subCategoryId);
        // }
        //if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        // $//this->db->limit($limit, $start);
        $query = $this->db->get();

        return $query->result_array();
    }

    function get_filter_product_count($make_id = null, $year_id = null,
                                      $model_id = null,
                                      $product_category_id = null,
                                      $product_sub_category = null,
                                      $searchTearm = null)
    {

//
//        if (strstr($product_category_id, '_')) {
//            $id = explode('_', $product_category_id);
//            $product_category_id = $id[0];
//            $product_sub_category = $id[1];
//        } else {
//            $product_category_id = $product_category_id;
//            $product_sub_category = null;
//        }


        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        if (isset($product_category_id) && $product_category_id != '' && $searchTearm
            == null) $this->db->where('ip.category_id', $product_category_id);
        if ($make_id != null) $this->db->where('ip.make_id', $make_id);
        if ($year_id != null) $this->db->where('ip.year_id', $year_id);
        if ($model_id != null) $this->db->where('ip.model_id', $model_id);

        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm
            == null) {
            $this->db->join('it_product_attributes ipa',
                'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $product_sub_category);
        }
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm
            == 'brand') {
            $this->db->join('it_product_attributes ipa',
                'ipa.product_id = ip.id');
            $this->db->where('ipa.sub_attribute_dp_id', $product_sub_category);
        }

        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');
        if (isset($start) && $start != NULL) $this->db->limit($start, $limit);
//        else
//            $this->db->limit(6);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $query->result_array();
    }

    public function get_all_plugin_images_by_category($make_id = null,
                                                      $year_id = null,
                                                      $model_id = null,
                                                      $product_category_id = null)
    {
        $this->db->select('ipa.sub_attribute_value');
        $this->db->from('it_products ip');
        $this->db->join('it_product_attributes ipa', 'ipa.product_id = ip.id');
        if ($make_id != null) $this->db->where('ip.make_id', $make_id);
        if ($year_id != null) $this->db->where('ip.year_id', $year_id);
        if ($model_id != null) $this->db->where('ip.model_id', $model_id);

        if (isset($product_category_id) && $product_category_id != '')
                $this->db->where('ip.category_id', $product_category_id);

        $this->db->where('ipa.attribute_type', 2);
        $this->db->group_by('ip.id');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $query->result_array();
    }

    function get_feature_product()
    {
        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->where('ip.product_is_feature', '1');
        $this->db->where('ip.is_instagram_product', '0');
        $this->db->group_by('ip.id');
        $this->db->order_by('ip.id', 'DESC');
        $this->db->limit(4);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_product_by_product_id($profuctId)
    {
        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id',
            'left');
        $this->db->where('ip.id', $profuctId);
        $this->db->where('ip.isactive', '0');
        $this->db->group_by('ip.id');
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_offer_product($categoryId)
    {

        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->where('ip.is_offer_publish', 1);
        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.id');
        $this->db->limit(3);
        $query     = $this->db->get();
        $offerData = $query->result_array();
        if (!empty($offerData)) return $offerData;
        else return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_all_offer_product()
    {

        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->where('ip.is_offer_publish', 1);
//        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.id');
        $this->db->order_by('ip.id', 'DESC');
        $this->db->limit(1);
        $query     = $this->db->get();
        $offerData = $query->result_array();
        if (!empty($offerData)) return $offerData;
        else return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function get_product_by_cat_id($id)
    {

        $this->db->select('*');
        $this->db->from('it_products');
        $this->db->where('isactive', 0);
        if ($id != '') {
            $this->db->where('category_id', $id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_product($id)
    {
        $this->db->where('id', $id)->delete('it_products');
        return true;
    }

    public function get_all_products()
    {
        $q = $this->db->where('isactive', 0)->get('it_products');
        return $q->result_array();
    }

    public function get_all_inactive_product()
    {
        $q = $this->db->where('isactive', 1)->get('it_products');
        return $q->result_array();
    }

    public function get_product_tags($product_id)
    {
        $q = $this->db->where('product_id', $product_id)->get('it_product_tags');
        return $q->result_array();
    }

    function get_product_by_tag($tagname)
    {

        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_product_tags ipm', 'ipm.product_id = ip.id');
        $this->db->where('ip.isactive', '0');
        $this->db->like('ipm.tag_name', $tagname);
        $this->db->order_by('ip.id', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_products_by_limit($catid, $limit = '')
    {

        $this->db->select('*');
        $this->db->from('it_products');
        $this->db->where('isactive', '0');
        if ($catid != 'all') {
            $this->db->where('category_id', $catid);
        }
        $this->db->order_by('id', 'DESC');
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function filter_products($categoryId = null, $range = null,
                             $subCategoryId = null, $start = null,
                             $limit = null, $subcatThird = null, $order = null)
    {
        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id',
            'left');

        if (isset($categoryId) && $categoryId != null) {
            //$this->db->where_in($categoryId);
            $this->db->where("FIND_IN_SET('".$categoryId."',ip.category_id)");
            // $this->db->like('ip.category_id', $categoryId);
        }
        if ($subCategoryId != '' && $subCategoryId != null) {
            $this->db->join('it_product_attributes ipa',
                'ipa.product_id = ip.id', 'left');
            $this->db->where("FIND_IN_SET('$subCategoryId',ip.sub_category_id)");
        }
        if ($range != '' && $range != null) {
            $this->db->where("price BETWEEN $range");
        }

        if ($subcatThird != '' && $subcatThird != null) {
            $this->db->where("FIND_IN_SET('$subcatThird',ip.sub_attribute_id_new)");
        }

//        if ($categoryId = null && $subCategoryId = null)
        if ($order != '' && $order != null) {
            $this->db->order_by('ip.price', $order);
        } else {
            $this->db->order_by('ip.price', 'DESC');
        }
        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.product_name');
        //echo $start;die;
        if ($limit != '') {
            $this->db->limit($limit, $start);
        } else {
            $this->db->limit(6, 0);
        }
        $query = $this->db->get();

        $query2 = $this->db->last_query();
        //$query2 = $this->db->get();
        $query2 = str_replace("IS NULL", '', $query2);
        //echo $query2;
        $query3 = $this->db->query($query2);
//        echo $this->db->last_query();
        return $query3->result_array();

        //echo $query2;
        // return $query2->result_array();
    }

    public function getGroupProducts($product_name)
    {
		$conditions = "variant_color != '' AND variant_size != ''";
        $this->db->select('id,variant_color,variant_size');
        $this->db->from('it_products');
        $this->db->where('isactive', '0');
        $this->db->where('product_name', $product_name);
        $this->db->where('variant_color is NOT NULL', NULL, FALSE);
        $this->db->where('variant_size is NOT NULL', NULL, FALSE);
		$this->db->where($conditions);
        
//        $this->db->group_by('product_name');
        $query = $this->db->get();
        return $query->result_array();
    }

     public function get_essential_product()
    {
        $this->db->select('ip.*,ipm.*,ip.id as id');
        $this->db->from('it_products ip');
        $this->db->join('it_products_image ipm', 'ipm.product_id = ip.id',
            'left');
        $this->db->order_by('ip.id', 'RANDOM');
        $this->db->where("FIND_IN_SET('16',ip.sub_category_id)");
        $this->db->where('ip.isactive', 0);
        $this->db->where('ipm.url !=', "");
        $this->db->group_by('ip.product_name');
        $this->db->limit(4, 0);
        $query = $this->db->get();
        $query2 = $this->db->last_query();
        //$query2 = $this->db->get();
        $query2 = str_replace("IS NULL", '', $query2);
        //echo $query2;
        $query3 = $this->db->query($query2);

        return $query3->result_array();
    }
}
/* End of file Product.php */
/* Location: ./models/backend/Product.php */
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Class will do all necessary action for blog functionalities
 */

class Blog_Model extends CI_Model {

    public function getCategories($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0, $lang = '') {
        if ($fields == '') {
            if ($lang == "") {
                $fields = "c.*,IF(c.parent_id > 0,(select category_name from " . $this->db->dbprefix('mst_blog_categories') . " c2 where c2.category_id = c.parent_id limit 1),'-') as parent_category,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.type='blog-category' and u.rel_id=c.category_id) as page_url";
                $table_to_pass = "";
            } else {
                $fields = "c.category_id,c.created_on,c.parent_id,";
                $fields.="IF(isnull(tc.category_name),c.category_name,tc.category_name) as category_name,";
                $fields.="IF(isnull(tc.page_title),c.page_title,tc.page_title) as page_title,";
                $fields.="IF(isnull(tc.page_keyword_content),c.page_description,tc.page_keyword_content) as page_description,";
                $fields.="IF(isnull(tc.page_keywords),c.page_keywords,tc.page_keywords) as page_keywords,";
                $fields.="(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.type='blog-category' and u.rel_id=c.category_id) as page_url,";
                $fields.="IF(c.parent_id > 0,(select category_name from " . $this->db->dbprefix('mst_blog_categories') . " c2 where c2.category_id = c.parent_id limit 1),'-') as parent_category,";
                $fields.="(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.type='blog-category' and u.rel_id=c.category_id) as page_url";
                $table_to_pass = "mst_blog_categories c left join  " . $this->db->dbprefix('trans_blog_categories_lang_map') . " tc on c.category_id=tc.category_id and tc.lang_id = '" . $lang . "' ";
            }
        }

        $this->db->select($fields, FALSE);

        if ($lang != "") {

            $this->db->from("mst_blog_categories c");
            $this->db->join("trans_blog_categories_lang_map tc", "c.category_id=tc.category_id and tc.lang_id = '" . $lang . "'", "left");
        } else {
            $this->db->from("mst_blog_categories as c");
        }

        if ($condition_to_pass != '')
            $this->db->where($condition_to_pass);


        if ($order_by_to_pass != '')
            $this->db->order_by($order_by_to_pass);


        if ($limit_to_pass != '')
            $this->db->limit($limit_to_pass);

        $query = $this->db->get();

        if ($debug_to_pass)
            echo $this->db->last_query();

        return $query->result_array();
    }

    public function deleteCategory($arr) {
        $this->db->delete("mst_blog_categories", $arr);
    }

  
    public function getYearForBlog($year = '', $month = '') {

        $this->db->select('*');
        $this->db->from('mst_blog_posts');
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getYearsForBlog($fields = '', $condition = '', $order = '', $limit = '') {
        if ($fields == '')
            $fields = "*";

        $this->db->select($fields, FALSE);

        $this->db->from("mst_blog_posts");
        if ($condition != '')
            $this->db->where($condition);


        if ($order != '')
            $this->db->order_by($order);


        if ($limit != '')
            $this->db->limit($limit);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function updateCategory($arr, $condition) {
        $this->db->update("mst_blog_categories", $arr, $condition);
    }

    private function getCategoryTree($d, $r = 0, $pk = 'parent_id', $k = 'category_id', $c = 'children') {
        $m = array();
        foreach ($d as $e) {
            isset($m[$e[$pk]]) ? : $m[$e[$pk]] = array();
            isset($m[$e[$k]]) ? : $m[$e[$k]] = array();
            $m[$e[$pk]][] = array_merge($e, array($c => &$m[$e[$k]]));
        }
        return $m[$r]; // remove [0] if there could be more than one root nodes
    }

    private function render_categories_SELECT($arr, $level, $appendUrl = 0) {
        $str = "";

        foreach ($arr as $cat) {
            $str.="\n<option>";
            if ($appendUrl) {
                $str.='<a href="' . base_url() . $cat['page_url'] . '">' . $cat['category_name'] . "</a></option>";
            } else {
                $str.=$cat['category_name'] . "</option>";
            }

            if (count($cat["children"]) > 0) {
                $level++;
                $str.="\n" . $this->render_categories_SELECT($cat["children"], $level) . "\n";
            } else {

                $str.="";
            }
        }

        return $str;
    }

    private function render_categories_UL($arr, $level, $appendUrl = 1) {
        $str = "";

        foreach ($arr as $cat) {
            $str.="\n<li>";
            if ($appendUrl) {
                $str.='<a href="' . base_url() . $cat['page_url'] . '">' . $cat['category_name'] . "</a>";
            } else {
                $str.=$cat['category_name'];
            }

            if (count($cat["children"]) > 0) {
                $level++;
                $str.="\n<ul>" . $this->render_categories_UL($cat["children"], $level, $appendUrl) . "\n</ul>\n</li>";
            } else {
                $str.="\n</li>";
            }
        }

        return $str;
    }

    public function getCategoryTreeResponse($type = 'ul', $lang_id = "") {
        $arr_categories = $this->getCategories('', '', '', '', 0, $lang_id);
        $str_categories='';
        if(count($arr_categories))
        {
        foreach ($arr_categories as $category) {
            $arr_blog_categories[] = array(
                "category_id" => $category['category_id'],
                "parent_id" => $category['parent_id'],
                "category_name" => $category['category_name'],
                "page_url" => "blog/" . $category['page_url']
            );
        }
        
        $arr_categories_tree = $this->getCategoryTree($arr_blog_categories);
       
        if ($type == 'ul')
            $str_categories = $this->render_categories_UL($arr_categories_tree, 0);
        elseif ($type == 'select')
            $str_categories = $this->render_categories_UL($arr_categories_tree, 0);
        }
        return $str_categories;
    }

    public function getPosts($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $debug_to_pass = 0,$lang_id=17) {
        if ($fields == '')
//            $fields = "b.*,lang.lang_name,(select category_name from " . $this->db->dbprefix('mst_blog_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.post_id and u.`type`='blog-post') as page_url";

        $this->db->select('b.*', FALSE);

        $this->db->from("mst_blog_posts as b");
	//$this->db->join("mst_languages as lang","lang.lang_id=b.lang_id","left");
        $this->db->join("users as u",'u.id=b.posted_by','left');     
        if ($condition_to_pass != '')
            $this->db->where($condition_to_pass);


        if ($order_by_to_pass != '')
            $this->db->order_by($order_by_to_pass);


        if ($limit_to_pass != '')
            $this->db->limit($limit_to_pass);

        $query = $this->db->get();


        if ($debug_to_pass)
            echo $this->db->last_query();

        return $query->result_array();
    }

    public function getAllBlog($fields = '', $condition_to_pass = '', $order_by_to_pass = '', $limit_to_pass = '', $offset = '', $debug_to_pass = 0) {
        if ($fields == '')
//            $fields = "b.*,u.first_name,u.last_name,u.user_name,(select category_name from " . $this->db->dbprefix('mst_blog_categories') . " bc where bc.category_id=b.category_id) as category_name,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.post_id and u.`type`='blog-post') as page_url";
       $fields="b.*,u.first_name,u.last_name";
        $this->db->select($fields, FALSE);

        $this->db->from("mst_blog_posts as b");
        $this->db->join("users as u",'u.id=b.posted_by','left');        
        if ($condition_to_pass == '')
            $condition_to_pass = "b.status = '1'";
            $this->db->where($condition_to_pass);

            $this->db->order_by('b.posted_on','DESC');


        if ($limit_to_pass > 0) {
            $this->db->limit($limit_to_pass, $offset);
        }
        $query = $this->db->get();


        if ($debug_to_pass)
            echo $this->db->last_query();
        return $query->result_array();
    }

    public function searchPosts_old($searchKey) {
        $fields = "b.*,(select `url` from " . $this->db->dbprefix('mst_uri_map') . " u where u.rel_id=b.post_id and u.`type`='blog-post') as page_url";
        $this->db->select($fields, FALSE);

        $this->db->from("mst_blog_posts as b");
         $this->db->join("users as u",'u.id=b.posted_by','left');     
        $this->db->or_like(array('post_title' => $searchKey, 'post_short_description' => $searchKey, 'post_content' => $searchKey, 'post_tags' => $searchKey));

        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_comment($arr) {
//        print_r($arr);
//        exit;
        $this->db->insert("trans_blog_comments", $arr);
        return $this->db->insert_id();
    }

    public function update_comment($arr, $condition) {
        $this->db->update("trans_blog_comments", $arr, $condition);
    }

    public function getPostComments($fields = '', $condition = '', $order = '', $limit = '') {
        if ($fields == '')
            $fields = "b.*";

        $this->db->select($fields, FALSE);

        $this->db->from("trans_blog_comments as b");
//     $this->db->join("users as u",'u.id=b.commented_id','left');

        if ($condition != '')
            $this->db->where($condition);


        if ($order != '')
            $this->db->order_by($order);


        if ($limit != '')
            $this->db->limit($limit);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function insertNewPost($arr) {
        $this->db->insert("mst_blog_posts", $arr);
        return $this->db->insert_id();
    }

    public function updatePost($arr, $condition) {
        $this->db->update("mst_blog_posts", $arr, $condition);
    }

    public function deletePost($arr) {
        $this->db->delete("mst_blog_posts", $arr);
    }

    public function deletePostComment($arr) {
        $this->db->delete("trans_blog_comments", $arr);
    }

    public function getLangValForPost($l, $p) {
        $this->db->select("*", FALSE);

        $this->db->from("trans_blog_posts_lang_map");

        $this->db->where(array("lang_id" => $l, "post_id" => $p));

        $query = $this->db->get();

        return $query->result_array();
    }

    public function updateLanguageValuesForPost($arr_fields, $arr_condition) {
        $this->db->update("trans_blog_posts_lang_map", $arr_fields, $arr_condition);
    }

    public function insertLanguageValuesForPost($arr_fields) {
        $this->db->insert("trans_blog_posts_lang_map", $arr_fields);
    }

    public function add_category($arr) {
        $this->db->insert("mst_blog_categories", $arr);
        return $this->db->insert_id();
    }

    public function insertURI($arr) {
        $this->db->insert("mst_uri_map", $arr);
        return $this->db->insert_id();
    }

    public function getCategoryList($parent_category_id, $category_name) {
        $this->db->select("*");
        $this->db->from("mst_blog_categories");
        $this->db->where("category_name", $category_name);
        $this->db->where("parent_id", $parent_category_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getRecentBlogs() {
        $this->db->select('b.post_short_description,user.first_name,user.last_name,b.blog_image,b.post_title,b.posted_on');
        $this->db->from("mst_blog_posts as b");
        $this->db->join("users as user",'user.id=b.posted_by','inner');     
     //   $this->db->join("mst_uri_map as u", 'u.rel_id = b.post_id and type="blog-post"','left');
        $this->db->where('b.status','1');
        $this->db->order_by('b.posted_on', 'DESC');
        $this->db->limit('2');
        $this->db->group_by('b.post_id');
        $query = $this->db->get();
        return $query->result_array();
    }

}

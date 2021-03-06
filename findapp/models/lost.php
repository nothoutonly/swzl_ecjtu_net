<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lost extends CI_Model {

    private $per_page_count;
    private $total_count;
    
    public function __construct()
    {
        parent::__construct();
        $this->per_page_count = 9;
        $this->total_count = $this->get_total_rows();
    }
    
    public function get_info($page = '1', $perpage = 9)
    {
        $this->per_page_count = $perpage;
        $page = intval($page);
        if ($page <= 0)
        {
            $page = 1;
        }
        $this->db->select('lt.lid AS id, lt.name, lt.place, lt.time, lt.description, cy.cname');
        $this->db->from('lost AS lt');
        $this->db->join('category AS cy', 'lt.category = cy.cid');
        $this->db->order_by("lt.lid", "desc");
        $this->db->limit($this->per_page_count, ($page - 1) * $this->per_page_count);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_detail_info($lid)
    {
        $lid = intval($lid);
        $this->db->select('lid');
        $query = $this->db->get_where('lost', array('lid' => $lid) );
        if ($query->num_rows() > 0)
        {
            $this->db->select('lt.lid AS id, lt.name, lt.place, lt.time, lt.description, lt.owner, lt.phone, cy.cname');
            $this->db->from('lost AS lt');
            $this->db->join('category AS cy', 'lt.category = cy.cid');
            $this->db->where('lid', $lid);
            return $this->db->get()->row_array();
        }
        else
        {
            show_404();
        }
    }
    
    public function get_phone($lid)
    {
        $lid = intval($lid);
        $this->db->select('lid');
        $query = $this->db->get_where('lost', array('lid' => $lid) );
        if ($query->num_rows() > 0)
        {
            $this->db->select('phone');
            $this->db->where('lid', $lid);
            return $this->db->get('lost')->row()->phone;
        }
        else
        {
            return array();
        }
    }
    
    public function insert($data)
    {
        $this->db->insert('lost', $data);
    }
    
    public function search($page, $key)
    {
        $this->db->select('lt.lid AS id, lt.name, lt.place, lt.time, lt.description, lt.owner, lt.phone, cy.cname');
        $this->db->from('lost AS lt');
        $this->db->join('category AS cy', 'lt.category = cy.cid');
        $this->db->like('lt.name', $key, 'both');
        $this->db->or_like('lt.place', $key, 'both');
        $this->db->or_like('lt.description', $key, 'both');
        $this->db->order_by("lt.lid", "desc");
        $this->db->limit($this->per_page_count, ($page - 1) * $this->per_page_count);
        $query = $this->db->get();
        if ($query->num_rows > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function get_total_rows($key = '')
    {
        if ( ! empty($key) )
        {
            $this->db->select('lid');
            $this->db->like('name', $key, 'both');
            $this->db->or_like('place', $key, 'both');
            $this->db->or_like('description', $key, 'both');
        }
        return $this->db->count_all_results('lost');
    }
    
    public function get_per_page_count()
    {
        return $this->per_page_count;
    }
}
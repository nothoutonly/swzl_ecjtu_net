<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

    public $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lost', 'lost', TRUE);
        $this->load->model('Found', 'found', TRUE);
        $this->data = array();
    }
    
    public function postfunc()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('qslx', '启事类型', 'required|xss_clean|callback_qslx_check');
        $this->form_validation->set_rules('wpmc', '物品名称', 'required|xss_clean');
        $this->form_validation->set_rules('wplx', '物品类型', 'required|xss_clean');
        $this->form_validation->set_rules('sqdd', '拾取地点', 'xss_clean');
        $this->form_validation->set_rules('sqsj', '拾取时间', 'xss_clean|callback_time_check');
        $this->form_validation->set_rules('xm', '姓名', 'required|xss_clean');
        $this->form_validation->set_rules('sjhm', '手机号码', 'required|xss_clean|integer|min_length[11]|max_length[11]');
        $this->form_validation->set_rules('xxms', '详细描述', 'required|xss_clean|max_length[110]');
        $this->form_validation->set_message('required', '%s是必填项目！');
        $this->form_validation->set_message('integer', '%s必须是数字！');
        $this->form_validation->set_message('max_length', '%s不能超过%d字！');
	$this->form_validation->set_message('min_length','%s不能小于%d字！');
        if ($this->form_validation->run() == TRUE)
        {
            $qslx = $this->input->post('qslx', TRUE);
            $this->data['name'] = $this->input->post('wpmc', TRUE);
            $this->data['category'] = $this->input->post('wplx', TRUE);
            $sqdd = $this->input->post('sqdd', TRUE);
            $this->data['place'] = empty($sqdd) ? '' : $sqdd;
            $sqsj = $this->input->post('sqsj', TRUE);
            $this->data['time'] = empty($sqsj) ? time() : strtotime($sqsj);
            $this->data['owner'] = $this->input->post('xm', TRUE);
            $this->data['phone'] = $this->input->post('sjhm', TRUE);
            $this->data['description'] = $this->input->post('xxms', TRUE);
            switch ($qslx)
            {
                case 'zlqs': // 招领启事
                    $this->found->insert($this->data);
                    break;
                case 'xwqs': // 寻物启事
                    $this->lost->insert($this->data);
                    break;
            }
            redirect('/', 'refresh');
        }
        else
        {
            $this->db->select('cid, cname');
            $query = $this->db->get('category');
            if ($query->num_rows() > 0)
            {
                $this->data['category'] = $query->result();
            }
            else
            {
                $this->data['category'] = array();
            }
            $this->load->view('post', $this->data);
        }
    }
    
    public function qslx_check($qslx)
    {
        switch ($qslx)
        {
            case 'zlqs': // 招领启事
            case 'xwqs': // 寻物启事
                return TRUE;
            default:
                $this->form_validation->set_message('qslx_check', '%s内容不对！');
                return FALSE;
        }
    }
    
    public function time_check($sqsj){
    	$now = date('Y-m-d',time());
    	if($sqsj <= $now){
    		return true;
    	}else {
    		$this->form_validation->set_message('time_check','%s超过当前时间！');
    		return false;
    	}
    }
}

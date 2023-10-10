<?php
class Project_rc_details extends AIV_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('gen_model');
    $this->load->model('St_model');
    $this->load->library('globalvar');
    $golbal_var = $this->globalvar->global_var();
  }

  protected function rules_rc() {
    $rules = array(
      array(
        'field' => 'project_rc',
        'label' => 'Project RC',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'permoter_name',
        'label' => 'Permoter name',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'project_name',
        'label' => 'Project name',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'issuing_date',
        'label' => 'RC issuing date',
        'rules' => 'required'
      ),
      array(
        'field' => 'condition_input',
        'label' => 'Details of conditions',
        'rules' => 'required'
      )
    );
    return $rules;
  }

  public function del_rc(){ 
    $uri=$this->uri->segment(3);
    $get_url_id=explode('_',$uri);
    $getid=(int)$get_url_id[1];
    $data_array=array(
      'flag'=>'0',
      'update_date'=>date('Y-m-d H:i:s')
    );
    if(is_int($getid)){
    	$del_id=$getid/16;
      $this->gen_model->edit('tbl_rc_details',$data_array,array('id'=>$del_id));
      $this->session->set_flashdata('success', 'Success');
      redirect(base_url("Project_rc_details/rc_list"));
    } else {
      $this->session->set_flashdata('error', 'Failed');
      redirect(base_url("Project_rc_details/rc_list"));
    } 
  }

  //7-feb-23
  public function index1bkp(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5){
      $this->data['array_variable']= array(
                                        'project_rc'=>'',
                                        'permoter_name'=>'',
                                        'project_name'=>'',
                                     );
      if($_POST){
        $arra_insert=$this->data['array_variable']= array(
                          'project_rc'=>$this->input->post('project_rc'),
                          'permoter_name'=>$this->input->post('permoter_name'),
                          'project_name'=>$this->input->post('project_name')
                       );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_insert['rc_condition']=$this->input->post('rc_condition');
          $arra_insert['condition_full_fill']=$this->input->post('condition_full_fill');
          $arra_insert['not_full_fill']=$this->input->post('not_full_fill');
          $arra_insert['check_or_bg']=$this->input->post('check_or_bg');
          $arra_insert['check_no']=$this->input->post('check_no');
          $arra_insert['check_date']=$this->input->post('check_date');
          $arra_insert['wether_check']=$this->input->post('wether_check');
          $arra_insert['submit_bg']=$this->input->post('submit_bg');
          $arra_insert['bg_ex_nex']=$this->input->post('bg_ex_nex');
          $arra_insert['expiry_date']=$this->input->post('expiry_date');
          $arra_insert['condition_input']=$this->input->post('condition_input');
          $arra_insert['create_date']=date('Y-m-d H:i:s');
          $arra_insert['update_date']=date('Y-m-d H:i:s');
          $this->gen_model->add('tbl_rc_details',$arra_insert);
          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data["subview"] = "project_rc_details/index_backup";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data["subview"] = "project_rc_details/index_backup";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  //23-feb-23
  public function index2bkp(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5){
      $this->data['array_variable']= array(
                                      'project_rc'=>'',
                                      'permoter_name'=>'',
                                      'project_name'=>'',
                                     );
      if($_POST){
        $arra_insert=$this->data['array_variable']= array(
														                          'project_rc'=>$this->input->post('project_rc'),
														                          'permoter_name'=>$this->input->post('permoter_name'),
														                          'project_name'=>$this->input->post('project_name')
															                      );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_insert['rc_condition']=$this->input->post('rc_condition');
          $arra_insert['condition_full_fill']=$this->input->post('condition_full_fill');
          if($this->input->post('condition_full_fill')=='Yes'){
          	$arra_insert['not_full_fill']=$this->input->post('not_full_fill');
          }
          $arra_insert['condition_input']=$this->input->post('condition_input');
          $arra_insert['create_date']=date('Y-m-d H:i:s');
          $this->gen_model->add('tbl_rc_details',$arra_insert);
          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data["subview"] = "project_rc_details/index";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data["subview"] = "project_rc_details/index";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  public function index(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5){
      $this->data['array_variable']=  array(
                                        'project_rc'=>'',
                                        'permoter_name'=>'',
                                        'project_name'=>'',
                                        'issuing_date'=>''
                                      );
      if($_POST){
        $arra_insert=$this->data['array_variable']= array(
                      'project_rc'=>$this->input->post('project_rc'),
                      'permoter_name'=>$this->input->post('permoter_name'),
                      'project_name'=>$this->input->post('project_name'),
                      'issuing_date'=>$this->input->post('issuing_date')
                     );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_insert['rc_condition']=$this->input->post('rc_condition');
          if($this->input->post('rc_condition')=='Yes'){
            $arra_insert['expiry_date']=$this->input->post('expiry_date');
            $arra_insert['date_rmvd_rc_cond']=$this->input->post('date_rmvd_rc_cond');
          }          
          $arra_insert['condition_full_fill']=$this->input->post('condition_full_fill');
          if($this->input->post('condition_full_fill')=='Yes'){
            $arra_insert['not_full_fill']=$this->input->post('not_full_fill');
          }
          $arra_insert['condition_input']=$this->input->post('condition_input');
          $arra_insert['status']=$this->input->post('status');
          if($this->input->post('status')=='For Next Date' && $this->input->post('rc_condition')=='Yes'){
            $arra_insert['hearing_date']=$this->input->post('hearing_date');
          }
          $arra_insert['create_date']=date('Y-m-d H:i:s');
          //comment removed at 14-03-22
          //dump($arra_insert);die('work pending');
          $this->gen_model->add('tbl_rc_details',$arra_insert);
          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data["subview"] = "project_rc_details/index";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data["subview"] = "project_rc_details/index";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  public function rc_list_backup(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $this->data['header_data'] ='Project RC List';
    if($usertypeID == 5){
      $this->data["subview"] = "project_rc_details/rc_list_backup";
      $this->load->view('layout_main', $this->data);
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  } 

  public function rc_list(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $this->data['header_data'] ='Project RC List';
    if($usertypeID == 5 || $usertypeID == 1){
      $this->data['st_data']=$this->gen_model->get_all_date('tbl_rc_details',array('flag' => 1));
      $this->data["subview"] = "project_rc_details/rc_list";
      $this->load->view('layout_main', $this->data);
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  } 

  public function ajax_pagination(){
    $limit_per_page= 10;
    $page="";
    if(isset($_POST['page_no'])){
      $page=$_POST["page_no"];
    }else{
      $page=1;
    }
    $offset = ($page-1)*$limit_per_page;
    $st_data = $this->St_model->get_data_limit_offset('tbl_rc_details', $limit_per_page, $offset);
    $output="";
    if(count($st_data)>0){
      $st_all_data = $this->St_model->get_data('tbl_rc_details');
      $a=count($st_all_data)/$limit_per_page;
      $a1=ceil($a);
      $output.='<table class="table table-bordered" id="main">
        <tbody>
          <tr>
            <th>S.N.</th>
            <th>Project RC</th>
            <th>Permoter name</th>
            <th>Project name</th>
            <th colspan="2">Action</th>
          </tr>';
          $i=0;foreach ($st_data as $value) {$i++;
            $base_url=base_url('project_rc_details/edit_rc/'.$value->id);
            $base_url_report=base_url('Disposereport/RCpdf/'.$value->id);
            $output .=  "<tr>
              <td>{$i}</td>
              <td align='center'>{$value->project_rc}</td>
              <td align='center'>{$value->permoter_name}</td>
              <td align='center'>{$value->project_name}</td>
              <td><a href={$base_url} class='btn btn-lg btn-primary' target='_blank'>Edit</td>
              <td><a href={$base_url_report} class='btn btn-lg btn-primary' target='_blank'>View</td>
            </tr>";
          }
        $output .= '</tbody>
      </table>';
      $output .='<div id="pagination" style="margin-top: 10px;">';
      for ($b=1; $b <= $a1 ; $b++) { 
        if($page==$b){
          $class='active';
        }else{
          $class='';
        }
        $output.="<a class='{$class}' style='padding: 5px;color:black;float:left;' id='{$b}' href=''>{$b}</a>";
      }
      $output.='</div>';
      echo $output;
    }else{
      echo "<h2>No Record Found</h2>";
    }
  }

  //7-feb-23
  public function edit_rc1(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $uri=$this->uri->segment(3);
    $get_url_id=explode('_',$uri);
    $getid=(int)$get_url_id[1];
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5 && $getid>0 && is_int($getid)){
    	$id=$getid/83;
      if($_POST){
        $arra_update=$this->data['array_variable']= array(
                          'project_rc'=>$this->input->post('project_rc'),
                          'permoter_name'=>$this->input->post('permoter_name'),
                          'project_name'=>$this->input->post('project_name')
                        );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_update['rc_condition']=$this->input->post('rc_condition');
          $arra_update['condition_full_fill']=$this->input->post('condition_full_fill');
          $arra_update['not_full_fill']=$this->input->post('not_full_fill');
          $arra_update['check_or_bg']=$this->input->post('check_or_bg');
          $arra_update['check_no']=$this->input->post('check_no');
          $arra_update['check_date']=$this->input->post('check_date');
          $arra_update['wether_check']=$this->input->post('wether_check');
          $arra_update['submit_bg']=$this->input->post('submit_bg'); 
          $arra_update['bg_ex_nex']=$this->input->post('bg_ex_nex');
          $arra_update['expiry_date']=$this->input->post('expiry_date');
          $arra_update['condition_input']=$this->input->post('condition_input');
          $arra_update['update_date']=date('Y-m-d H:i:s');
          if($this->gen_model->edit('tbl_rc_details',$arra_update,array('id'=>$id))){
          	if($this->input->post('condition_input') != ''){
	          	$array_ins= array(
	          								'trans_id'=>$id,
	                          'project_rc'=>$this->input->post('project_rc'),
	                          'permoter_name'=>$this->input->post('permoter_name'),
	                          'project_name'=>$this->input->post('project_name'),
	                          'condition_input'=>$this->input->post('condition_input'),
	                          'update_date'=>date('Y-m-d H:i:s'),
	                          'flag'=>1
	                        );
	          	$this->gen_model->add('tbl_rc_details_trans',$array_ins);
	          }
          }
          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
          $this->data["subview"] = "project_rc_details/edit_rc";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
        $this->data["subview"] = "project_rc_details/edit_rc_backup";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  //23-feb-23
  public function edit_rc2(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $uri=$this->uri->segment(3);
    $get_url_id=explode('_',$uri);
    $getid=(int)$get_url_id[1];
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5 && $getid>0 && is_int($getid)){
      $id=$getid/83;
      if($_POST){
        $arra_update=$this->data['array_variable']= array(
                          'project_rc'=>$this->input->post('project_rc'),
                          'permoter_name'=>$this->input->post('permoter_name'),
                          'project_name'=>$this->input->post('project_name')
                        );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_update['rc_condition']=$this->input->post('rc_condition');
          $arra_update['condition_full_fill']=$this->input->post('condition_full_fill');
          $arra_update['current_hearing_date']=date('Y-m-d');
          $arra_update['condition_input']=$this->input->post('condition_input');
          if($this->input->post('condition_full_fill')=='Yes'){
            $arra_update['not_full_fill']=$this->input->post('not_full_fill');
          }
          $arra_update['update_date']=date('Y-m-d H:i:s');
          if($this->gen_model->edit('tbl_rc_details',$arra_update,array('id'=>$id))){
            if($this->input->post('condition_input') != ''){
              $array_ins['trans_id']=$id;
              $array_ins['project_rc']=$this->input->post('project_rc');
              $array_ins['permoter_name']=$this->input->post('permoter_name');
              $array_ins['project_name']=$this->input->post('project_name');
              $array_ins['condition_input']=$this->input->post('condition_input');
              $array_ins['current_hearing_date']=date('Y-m-d');
              $array_ins['update_date']=date('Y-m-d H:i:s');
              $array_ins['flag']=1;
              $this->gen_model->add('tbl_rc_details_trans',$array_ins);
            }
          }

          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
          $this->data["subview"] = "project_rc_details/edit_rc";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
        $this->data["subview"] = "project_rc_details/edit_rc_21-02-23";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  public function edit_rc(){
    ob_start();
    $usertypeID = $this->session->userdata("user_type_id");
    $uri=$this->uri->segment(3);
    $get_url_id=explode('_',$uri);
    $getid=(int)$get_url_id[1];
    $this->data['header_data'] ='Project RC Details';
    if($usertypeID == 5 && $getid>0 && is_int($getid)){
      $id=$getid/83;
      if($_POST){
        $arra_update=$this->data['array_variable']= array(
                          'project_rc'=>$this->input->post('project_rc'),
                          'permoter_name'=>$this->input->post('permoter_name'),
                          'project_name'=>$this->input->post('project_name'),
                      		'issuing_date'=>$this->input->post('issuing_date')
                        );
        $rules = $this->rules_rc();
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run()){
          $arra_update['rc_condition']=$this->input->post('rc_condition');
          if($this->input->post('rc_condition')=='Yes'){
            $arra_update['expiry_date']=$this->input->post('expiry_date');
            $arra_update['date_rmvd_rc_cond']=$this->input->post('date_rmvd_rc_cond');
          }else{
            $arra_update['expiry_date']=NULL;
            $arra_update['date_rmvd_rc_cond']=NULL;
          }
          $arra_update['condition_full_fill']=$this->input->post('condition_full_fill'); 
          if($this->input->post('condition_full_fill')=='Yes'){
            $arra_update['not_full_fill']=$this->input->post('not_full_fill');
          }else{
            $arra_update['not_full_fill']=NULL;
          }
          $arra_update['condition_input']=$this->input->post('condition_input');
          $arra_update['current_hearing_date']=date('Y-m-d');
          $arra_update['status']=$this->input->post('status');
          if($this->input->post('status')=='For Next Date' && $this->input->post('rc_condition')=='Yes'){
            $arra_update['hearing_date']=$this->input->post('hearing_date');
            $array_ins['hearing_date']=$this->input->post('hearing_date');
          }else{
            $arra_update['hearing_date']=NULL;
            $array_ins['hearing_date']=NULL;
          }
          $arra_update['not_full_fill']=$this->input->post('not_full_fill');
          $arra_update['update_date']=date('Y-m-d H:i:s');
          if($this->gen_model->edit('tbl_rc_details',$arra_update,array('id'=>$id))){
            if($this->input->post('condition_input') != ''){
              $array_ins['trans_id']=$id;
              $array_ins['project_rc']=$this->input->post('project_rc');
              $array_ins['permoter_name']=$this->input->post('permoter_name');
              $array_ins['project_name']=$this->input->post('project_name');
              $array_ins['condition_input']=$this->input->post('condition_input');
              $array_ins['current_hearing_date']=date('Y-m-d');
              $array_ins['update_date']=date('Y-m-d H:i:s');
              $array_ins['flag']=1;
              $this->gen_model->add('tbl_rc_details_trans',$array_ins);
            }
          }

          $this->session->set_flashdata('success', 'Success');
          redirect(base_url("project_rc_details/rc_list"));
        }else{
          $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
          $this->data["subview"] = "project_rc_details/edit_rc";
          $this->load->view('layout_main', $this->data);
        }
      }else{
        $this->data['rc']=$this->gen_model->get_single_date('tbl_rc_details', array('id'=>$id,'flag'=>1));
        $this->data["subview"] = "project_rc_details/edit_rc";
        $this->load->view('layout_main', $this->data);
      }
    }else{
      $this->data["subview"] = "error_page/permission_error";
      $this->load->view('layout_main', $this->data);
    }
  }

  public function BG_Order(){
    $this->data['header_data'] ='Order Uploads';
    $this->data["subview"] = "project_rc_details/order_upload";
    $this->load->view('layout_main', $this->data);
  }

  public function SearchBg1(){
    $BG_Order = $this->data['BG_Order'] = $this->gen_model->get_BGOrder('aa');
    $this->data["subview"]="project_rc_details/order_list";
    $this->load->view('layout_main', $this->data);
  }

  public function SearchBg(){
    if($_POST){
    	if($_POST['search'] != ''){
	      $lcSearchWord = $_POST['search'];
	      $BG_Order = $this->data['BG_Order'] = $this->gen_model->get_BGOrder($lcSearchWord);
	      $this->load->view('project_rc_details/order_list', $this->data);
	    }else{
	    	$this->data['BG_Order'] = array();
	      $this->load->view('project_rc_details/order_list', $this->data);
	    }
    }else{
    	$this->data['BG_Order'] = $this->gen_model->get_all_date('tbl_rc_details_trans',array('flag' => 1,'order_upload'=>null));
	    $this->load->view('project_rc_details/order_list', $this->data);
    }
  }

  public function Upload_BGorder(){
    $golbal_var = $this->globalvar->global_var();
    $remarks = $this->input->post('remarks');
    $id=$this->input->post('edit_id');
    if ($_POST && isset($_FILES['order_upload']['name'])) {
      if($_FILES["order_upload"]['name'] !=""){
        $upload_array = array();
        $file_name_photo = $_FILES["order_upload"]['name'];   
        $explodePH = explode('.', $file_name_photo);
        $fileext = end($explodePH);
        if(count($explodePH) >= 2) {
          $new_file = 'order'.unicode_file_name().'.'.$fileext;
          if (!is_dir('uploads/BGorder')) {
            mkdir('./uploads/BGorder', 0777, true);
          }
          if (!is_dir('uploads/BGorder/'.$id)) {
            mkdir('./uploads/BGorder/'.$id, 0777, true);
          }
          $config['upload_path'] = "./uploads/BGorder/".$id.'/';
          $config['allowed_types'] = "PDF|pdf";
          $config['file_name'] = $new_file;
          $config['max_size'] = $golbal_var['max_size'];
          $config['max_width'] = $golbal_var['max_width'];
          $config['max_height'] = $golbal_var['max_height'];   
          $this->load->library('upload', $config);
          if(!$this->upload->do_upload("order_upload")) {
            echo "error 2";
          } else { 
            $upload_array['order_upload'] =base_url("uploads/BGorder/".$id.'/'.$new_file);
            $upload_array['remarks'] = $remarks;
            if($this->gen_model->edit('tbl_rc_details_trans', $upload_array,array('id'=>$id))){
              echo "success";
            }else{
              echo "unsuccess";
            }
          }
        }
      } else {
        echo "error 1";
      }
    }else{
    	echo "error 1";
    } 
  }
  // protected function htmlf($BG_Order = null) {
  //   $this->data['BG_Order'] = $BG_Order;
  //   return $this->load->view('project_rc_details/order_list', $this->data);
  // }
}
<?php
class Upload extends CI_Controller {

    public $controller = "upload";

    public function __construct()
    {
        parent::__construct();          
        $this->load->driver('session'); 
        $this->load->model('Upload_model');
        $this->load->library('image_lib');
        $this->load->model('Dashboard_model','',TRUE);

        // Control de Sessión
        if(!$this->session->has_userdata('id_usuario'))
        {                           
            //If no session, redirect to login page
            redirect('account/logout');

        }
    }

    public function hijos_create()
    {

        # Control de Acceso
        if(!($this->session->userdata('tipo')=='USUARIO'))
        {                           
            //If no session, redirect to login page
            redirect('account/logout');
            
        }

        # Data
        $data['meta'] = 'APA ROSA MOLAS | Hijos - Nuevo Registro';
        $data['title'] = '<i class="fa fa-users"></i> Hijos';
        $data['subtitle'] = 'Nuevo Registro';
        $data['breadcrumbs'] = 
            array(
                '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                '<i class="fa fa-users"></i> Hijos'                 => 'hijos/index',
                'Nuevo Registro'                                    => '',                  
            );      

        $this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check|callback_vdni');
        $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        $this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
        $this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
        #$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
        $this->form_validation->set_rules('fn_dia', 'Día', 'trim|required');
        $this->form_validation->set_rules('fn_mes', 'Mes', 'trim|required');
        $this->form_validation->set_rules('fn_ano', 'Año', 'trim|required|callback_fn_check');
        $this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
        $this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
        $this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');  
        $this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

        $this->form_validation->set_message('dni_check', 'El campo DNI ingresado ya se encuentra ocupado.');
        $this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
        $this->form_validation->set_message('vdni', 'DNI No Valido');       
                    
        $this->load->view($this->controller.'/hijos_create',$data);
    }

    public function hijos_update($id_hijo=false)
    {           
        
        # Control de Acceso
        if(!($this->session->userdata('tipo')=='USUARIO'))
        {                           
            //If no session, redirect to login page
            redirect('account/logout');
            
        }

        # Data
        $data['meta'] = 'APA ROSA MOLAS | Hijos - Editar Información';
        $data['title'] = '<i class="fa fa-users"></i> Hijos';
        $data['subtitle'] = 'Editar Información';
        $data['breadcrumbs'] = 
            array(
                '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                '<i class="fa fa-users"></i> Hijos'                 => 'hijos/index',
                'Editar Información'                                => '',                  
            );
            
        $data['row'] = $this->Upload_model->hijos_read($id_hijo);
            
        #$this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check2|callback_vdni');
        #$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
        #$this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
        #$this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
        #$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
        $this->form_validation->set_rules('fn_dia', 'Día', 'trim|required');
        $this->form_validation->set_rules('fn_mes', 'Mes', 'trim|required');
        $this->form_validation->set_rules('fn_ano', 'Año', 'trim|required|callback_fn_check');
        $this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
        $this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
        $this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');  
        $this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

        #$this->form_validation->set_message('dni_check2', 'El campo DNI ingresado ya se encuentra ocupado.');
        $this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
        #$this->form_validation->set_message('vdni', 'DNI No Valido');

        
        $data['row'] = $this->Upload_model->hijos_read($id_hijo);
        if(empty($data['row']))
        {
            $data['alert']['danger'] = 
                array( 
                    'No exite registro ó No puede ser eliminado',               
                );

            $this->load->view($this->controller.'/message',$data);
        }else{

            $this->load->view($this->controller.'/hijos_update',$data);           
            
        }
           
    }

    public function ahijo($id_hijo=false)
    {           

        # Config 
        $path = FCPATH.'assets/uploads/';

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpe|jpge|png'; 
        #$config['max_width']            = 100;
        #$config['max_height']           = 200;
        $this->load->library('upload', $config);

        # Data
        $data['meta'] = 'APA ROSA MOLAS | Deportistas - Subir Foto';
        $data['title'] = '<i class="fa fa-users"></i> Deportistas';
        $data['subtitle'] = 'Subir Foto';
        $data['breadcrumbs'] = 
            array(
                '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                '<i class="fa fa-users"></i> Deportistas'           => 'ahijos/index',
                'Subir Foto'                                        => '',                  
            );
            
        $data['row'] = $this->Upload_model->aread($id_hijo);
            
        $this->form_validation->set_rules('id_hijo', '', 'required');
        
        if(empty($data['row']))
        {
            $data['alert']['danger'] = 
                array( 
                    'No exite registro ó No puede ser eliminado',               
                );

            $this->load->view($this->controller.'/message',$data);
        }else{

            $this->load->view($this->controller.'/aupdate',$data);           
            
        }
       
    }

     
    public function do_upload()
    {
                
        # Data
        $type = $this->input->post('type');
        # Config 
        $path = FCPATH.'assets/uploads/';

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpe|jpge|png'; 
        #$config['max_width']            = 100;
        #$config['max_height']           = 200; 

        switch ($type) {
            case 'hijos_create':
                # CREATE HIJOS
                # Control de Acceso
                if(!($this->session->userdata('tipo')=='USUARIO'))
                {                           
                    //If no session, redirect to login page
                    redirect('account/logout');
                    
                }

                # Data
                $data['meta'] = 'APA ROSA MOLAS | Hijos - Nuevo Registro';
                $data['title'] = '<i class="fa fa-users"></i> Hijos';
                $data['subtitle'] = 'Nuevo Registro';
                $data['breadcrumbs'] = 
                    array(
                        '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                        '<i class="fa fa-users"></i> Hijos'                 => 'hijos/index',
                        'Nuevo Registro'                                    => '',                  
                    );

                $this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check|callback_vdni');
                $this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
                $this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
                $this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
                #$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
                $this->form_validation->set_rules('fn_dia', 'Día', 'trim|required');
                $this->form_validation->set_rules('fn_mes', 'Mes', 'trim|required');
                $this->form_validation->set_rules('fn_ano', 'Año', 'trim|required|callback_fn_check');
                $this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
                $this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
                $this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');  
                $this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

                #$this->form_validation->set_message('dni_check', 'El campo DNI ingresado ya se encuentra ocupado.');
                $this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
                #$this->form_validation->set_message('vdni', 'DNI No Valido'); 
                break;

            case 'hijos_update':
                # UPDATE HIJOS
                # Control de Acceso
                if(!($this->session->userdata('tipo')=='USUARIO'))
                {                           
                    //If no session, redirect to login page
                    redirect('account/logout');
                    
                }

                # Data
                $data['meta'] = 'APA ROSA MOLAS | Hijos - Editar Información';
                $data['title'] = '<i class="fa fa-users"></i> Hijos';
                $data['subtitle'] = 'Editar Información';
                $data['breadcrumbs'] = 
                    array(
                        '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                        '<i class="fa fa-users"></i> Hijos'                 => 'hijos/index',
                        'Editar Información'                                => '',                  
                    );

                $id_hijo = $this->input->post('id_hijo');
                    
                $data['row'] = $this->Upload_model->hijos_read($id_hijo);
                    
                #$this->form_validation->set_rules('dni', 'DNI', 'trim|callback_dni_check2|callback_vdni');
                #$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required');
                #$this->form_validation->set_rules('apellido_1', 'Primer Apellido', 'trim|required');
                #$this->form_validation->set_rules('apellido_2', 'Segundo Apellido', 'trim|required');
                #$this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'trim|required|callback_fn_check');
                $this->form_validation->set_rules('fn_dia', 'Día', 'trim|required');
                $this->form_validation->set_rules('fn_mes', 'Mes', 'trim|required');
                $this->form_validation->set_rules('fn_ano', 'Año', 'trim|required|callback_fn_check');
                $this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
                $this->form_validation->set_rules('colegio', 'Pertenece al Colegio', 'trim|required');
                $this->form_validation->set_rules('centro_escolar', 'Centro Escolar', 'trim');  
                $this->form_validation->set_rules('afoto', 'Autorización de Foto', 'required');

                #$this->form_validation->set_message('dni_check2', 'aEl campo DNI ingresado ya se encuentra ocupado.');
                $this->form_validation->set_message('fn_check', 'La edad no se encuentra dentro del rango (4 - 20 años).');
                $this->form_validation->set_message('vdni', 'DNI No Valido');

                
                $data['row'] = $this->Upload_model->hijos_read($id_hijo);
                break;

            case 'administrador':
                # UPDATE IMAGES ADMINISTRADOR
                # Control de Acceso
                if(!($this->session->userdata('tipo')=='ADMINISTRADOR'))
                {                           
                    //If no session, redirect to login page
                    redirect('account/logout');
                    
                }

                $data['meta'] = 'APA ROSA MOLAS | Deportistas - Subir Foto';
                $data['title'] = '<i class="fa fa-users"></i> Deportistas';
                $data['subtitle'] = 'Subir Foto';
                $data['breadcrumbs'] = 
                    array(
                        '<i class="fa fa-dashboard"></i> Home'              => 'panel/index',
                        '<i class="fa fa-users"></i> Deportistas'           => 'ahijos/index',
                        'Subir Foto'                                        => '',                  
                    );

                $id_hijo = $this->input->post('id_hijo');
                    
                $data['row'] = $this->Upload_model->aread($id_hijo);
                                                                                   
                $this->form_validation->set_rules('id_hijo', 'id_hijo', 'required');
                #$this->form_validation->set_rules('userfile', 'Subir Imagen', 'required');

                break;
            
            default:
                # NOT POST
                redirect('account/logout');
                break;
        }

        if($this->form_validation->run() == FALSE)
        {
            
            switch ($type) {
            case 'hijos_create':
                # CREATE HIJOS
                $this->load->view($this->controller.'/hijos_create',$data);
                break;

            case 'hijos_update':
                # UPDATE HIJOS
                if(empty($data['row']))
                {
                    $data['alert']['danger'] = 
                        array( 
                            'No exite registro ó No puede ser eliminado',               
                        );

                    $this->load->view($this->controller.'/message',$data);
                }else{

                    $this->load->view($this->controller.'/hijos_update',$data);           
                    
                }
                break;

            case 'administrador':
                # UPDATE IMAGES ADMINISTRADOR
                $this->load->library('upload', $config);
                if(empty($data['row']))
                {
                    $data['alert']['danger'] = 
                        array( 
                            'No exite registro ó No puede ser eliminado',               
                        );

                    $this->load->view($this->controller.'/message',$data);
                }else{
                    $this->load->view($this->controller.'/aupdate',$data);
                }
                break;
            
            default:
                # NOT POST
                redirect('account/logout');
                break;
            }

        }
        else
        {
            switch ($type) {
            case 'hijos_create':
                # CREATE HIJOS
                
                $this->load->library('upload', $config);
                $data['alert']['success'] = 
                array( 
                    'Registrado Correctamente',             
                );

                if (!$this->upload->do_upload('userfile'))
                {
                    $this->Upload_model->hijos_create();
                    $this->load->view($this->controller.'/hijos_create',$data);
                }else{
                    $id_hijo = $this->Upload_model->hijos_create();
                    $this->Upload_model->hijos_upload($id_hijo);
                    $this->load->view($this->controller.'/hijos_create_upload',$data);
                }

                break;

            case 'hijos_update':
                # UPDATE HIJOS
                $this->Upload_model->hijos_update();
                
                $data['row'] = $this->Upload_model->hijos_read($id_hijo);
                if(empty($data['row']))
                {
                    $data['alert']['danger'] = 
                        array( 
                            'No exite registro',               
                        );

                    $this->load->view($this->controller.'/message',$data);
                }else{

                    $this->load->library('upload', $config);
                    $data['alert']['success'] = 
                    array( 
                        'Registrado Correctamente',             
                    );

                    if (!$this->upload->do_upload('userfile'))
                    {
                        $this->Upload_model->hijos_update();
                        $data['row'] = $this->Upload_model->hijos_read($id_hijo);
                        $this->load->view($this->controller.'/hijos_update',$data);
                    }else{
                        $id_hijo = $this->Upload_model->hijos_update();
                        $this->Upload_model->hijos_upload($id_hijo);
                        $data['row'] = $this->Upload_model->hijos_read($id_hijo);
                        $this->load->view($this->controller.'/hijos_update_upload',$data);
                    }          
                
                }
                break;

            case 'administrador':
                # UPDATE IMAGES ADMINISTRADOR
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile'))
                {
                    $this->load->view($this->controller.'/aupdate',$data); 
                }else{
                    $upload = $this->upload->data();                                
                    $this->Upload_model->archivo($upload);

                    $data['alert']['success'] = 
                        array( 
                            'Registrado Correctamente',                                
                        );
                    $this->load->view($this->controller.'/message',$data);
                } 
                
                break;
            
            default:
                # NOT POST
                redirect('account/logout');
                break;
            }                 
        }
    }

    public function dni_check()
    {
        $check = $this->Upload_model->dni_check();
        if($check)
        {
            return false;
        }
        else
        {         
            return true;
        }
    }

    public function dni_check2()
    {
        return $this->Upload_model->dni_check();
    }

    public function fn_check()
    {
        $check = $this->Upload_model->fn_check();
        if($check)
        {
            return true;
        }
        else
        {         
            return false;
        }
    }

    public function vdni()
    {
        return $this->Upload_model->dni();
    }
}
?>
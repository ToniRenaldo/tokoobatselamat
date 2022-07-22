<?php
class Suplier extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('suplier_model');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->suplier_model->tampil_suplier();
		$this->load->view('admin/v_suplier',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_suplier(){
	if($this->session->userdata('akses')=='1'){
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->suplier_model->simpan_suplier($nama,$alamat,$notelp);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_suplier(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$notelp=$this->input->post('notelp');
		$this->suplier_model->update_suplier($kode,$nama,$alamat,$notelp);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_suplier(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->suplier_model->hapus_suplier($kode);
		redirect('admin/suplier');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}
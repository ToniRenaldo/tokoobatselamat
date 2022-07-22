<?php
class Kategori extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('kategori_model');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->kategori_model->tampil_kategori();
		$this->load->view('admin/v_kategori',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kat=$this->input->post('kategori');
		$this->kategori_model->simpan_kategori($kat);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$kat=$this->input->post('kategori');
		$this->kategori_model->update_kategori($kode,$kat);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_kategori(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->kategori_model->hapus_kategori($kode);
		redirect('admin/kategori');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}
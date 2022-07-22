<?php
class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('kategori_model');
		$this->load->model('barang_model');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->barang_model->tampil_barang();
		$data['kat']=$this->kategori_model->tampil_kategori();
		$data['kat2']=$this->kategori_model->tampil_kategori();
		$this->load->view('admin/v_barang',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function tambah_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->barang_model->get_kobar();
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul_grosir=str_replace(',', '', $this->input->post('harjul_grosir'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');
		$this->barang_model->simpan_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$harjul_grosir,$stok,$min_stok);

		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function edit_barang(){
	if($this->session->userdata('akses')=='1'){
		$kobar=$this->input->post('kobar');
		$nabar=$this->input->post('nabar');
		$kat=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$harpok=str_replace(',', '', $this->input->post('harpok'));
		$harjul=str_replace(',', '', $this->input->post('harjul'));
		$harjul_grosir=str_replace(',', '', $this->input->post('harjul_grosir'));
		$stok=$this->input->post('stok');
		$min_stok=$this->input->post('min_stok');
		$this->barang_model->update_barang($kobar,$nabar,$kat,$satuan,$harpok,$harjul,$harjul_grosir,$stok,$min_stok);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function hapus_barang(){
	if($this->session->userdata('akses')=='1'){
		$kode=$this->input->post('kode');
		$this->barang_model->hapus_barang($kode);
		redirect('admin/barang');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
}
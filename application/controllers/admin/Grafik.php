<?php
class Grafik extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('kategori_model');
		$this->load->model('barang_model');
		$this->load->model('suplier_model');
		$this->load->model('pembelian_model');
		$this->load->model('penjualan_model');
		$this->load->model('laporan_model');
		$this->load->model('grafik_model');
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->barang_model->tampil_barang();
		$data['kat']=$this->kategori_model->tampil_kategori();
		$data['jual_bln']=$this->laporan_model->get_bulan_jual();
		$data['jual_thn']=$this->laporan_model->get_tahun_jual();
		$this->load->view('admin/v_grafik',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function graf_stok_barang(){
		$x['report']=$this->grafik_model->statistik_stok();
		$this->load->view('admin/grafik/v_graf_stok_barang',$x);
	}
	
	
	function graf_penjualan_perbulan(){
		$bulan=$this->input->post('bln');
		$x['report']=$this->grafik_model->graf_penjualan_perbulan($bulan);
		$x['bln']=$bulan;
		$this->load->view('admin/grafik/v_graf_penjualan_perbulan',$x);
	}
	function graf_penjualan_pertahun(){
		$tahun=$this->input->post('thn');
		$x['report']=$this->grafik_model->graf_penjualan_pertahun($tahun);
		$x['thn']=$tahun;
		$this->load->view('admin/grafik/v_graf_penjualan_pertahun',$x);
	}
	
}
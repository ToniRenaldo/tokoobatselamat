<?php
class Laporan extends CI_Controller{
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
	}
	function index(){
	if($this->session->userdata('akses')=='1'){
		$data['data']=$this->barang_model->tampil_barang();
		$data['kat']=$this->kategori_model->tampil_kategori();
		$data['jual_bln']=$this->laporan_model->get_bulan_jual();
		$data['jual_thn']=$this->laporan_model->get_tahun_jual();
		$this->load->view('admin/v_laporan',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function lap_stok_barang(){
		$x['data']=$this->laporan_model->get_stok_barang();
		$this->load->view('admin/laporan/v_lap_stok_barang',$x);
	}
	function lap_data_barang(){
		$x['data']=$this->laporan_model->get_data_barang();
		$this->load->view('admin/laporan/v_lap_barang',$x);
	}
	function lap_data_penjualan(){
		$x['data']=$this->laporan_model->get_data_penjualan();
		$x['jml']=$this->laporan_model->get_total_penjualan();
		$this->load->view('admin/laporan/v_lap_penjualan',$x);
	}
	function lap_penjualan_pertanggal(){
		$tanggal=$this->input->post('tgl');
		$x['jml']=$this->laporan_model->get_data__total_jual_pertanggal($tanggal);
		$x['data']=$this->laporan_model->get_data_jual_pertanggal($tanggal);
		$this->load->view('admin/laporan/v_lap_jual_pertanggal',$x);
	}
	function lap_penjualan_perbulan(){
		$bulan=$this->input->post('bln');
		$x['jml']=$this->laporan_model->get_total_jual_perbulan($bulan);
		$x['data']=$this->laporan_model->get_jual_perbulan($bulan);
		$this->load->view('admin/laporan/v_lap_jual_perbulan',$x);
	}
	function lap_penjualan_pertahun(){
		$tahun=$this->input->post('thn');
		$x['jml']=$this->laporan_model->get_total_jual_pertahun($tahun);
		$x['data']=$this->laporan_model->get_jual_pertahun($tahun);
		$this->load->view('admin/laporan/v_lap_jual_pertahun',$x);
	}
	function lap_laba_rugi(){
		$bulan=$this->input->post('bln');
		$x['jml']=$this->laporan_model->get_total_lap_laba_rugi($bulan);
		$x['data']=$this->laporan_model->get_lap_laba_rugi($bulan);
		$this->load->view('admin/laporan/v_lap_laba_rugi',$x);
	}
}
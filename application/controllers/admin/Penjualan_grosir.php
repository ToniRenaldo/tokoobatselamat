<?php
class Penjualan_grosir extends CI_Controller{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url();
            redirect($url);
        };
		$this->load->model('kategori_model');
		$this->load->model('barang_model');
		$this->load->model('suplier_model');
		$this->load->model('penjualan_model');
	}
	function index(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$data['data']=$this->barang_model->tampil_barang();
		$this->load->view('admin/v_penjualan_grosir',$data);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function get_barang(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$kobar=$this->input->post('kode_brg');
		$x['brg']=$this->barang_model->get_barang($kobar);
		$this->load->view('admin/v_detail_barang_jual_grosir',$x);
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function add_to_cart(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$kobar=$this->input->post('kode_brg');
		$produk=$this->barang_model->get_barang($kobar);
		$i=$produk->row_array();
		$data = array(
               'id'       => $i['barang_id'],
               'name'     => $i['barang_nama'],
               'satuan'   => $i['barang_satuan'],
               'harpok'   => $i['barang_harpok'],
               'price'    => str_replace(",", "", $this->input->post('harjul'))-$this->input->post('diskon'),
               'disc'     => $this->input->post('diskon'),
               'qty'      => $this->input->post('qty'),
               'amount'	  => str_replace(",", "", $this->input->post('harjul'))
            );
	if(!empty($this->cart->total_items())){
		foreach ($this->cart->contents() as $items){
			$id=$items['id'];
			$qtylama=$items['qty'];
			$rowid=$items['rowid'];
			$kobar=$this->input->post('kode_brg');
			$qty=$this->input->post('qty');
			if($id==$kobar){
				$up=array(
					'rowid'=> $rowid,
					'qty'=>$qtylama+$qty
					);
				$this->cart->update($up);
			}else{
				$this->cart->insert($data);
			}
		}
	}else{
		$this->cart->insert($data);
	}
		redirect('admin/penjualan_grosir');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function remove(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$row_id=$this->uri->segment(4);
		$this->cart->update(array(
               'rowid'      => $row_id,
               'qty'     => 0
            ));
		redirect('admin/penjualan_grosir');
	}else{
        echo "Halaman tidak ditemukan";
    }
	}
	function simpan_penjualan_grosir(){
	if($this->session->userdata('akses')=='1' || $this->session->userdata('akses')=='2'){
		$total=$this->input->post('total');
		$jml_uang=str_replace(",", "", $this->input->post('jml_uang'));
		$kembalian=$jml_uang-$total;
		if(!empty($total) && !empty($jml_uang)){
			if($jml_uang < $total){
				echo $this->session->set_flashdata('msg','<label class="label label-danger">Jumlah Uang yang anda masukan Kurang</label>');
				redirect('admin/penjualan_grosir');
			}else{
				$nofak=$this->penjualan_model->get_nofak();
				$this->session->set_userdata('nofak',$nofak);
				$order_proses=$this->penjualan_model->simpan_penjualan_grosir($nofak,$total,$jml_uang,$kembalian);
				if($order_proses){
					$this->cart->destroy();
					//$this->session->unset_userdata('nofak');
					$this->session->unset_userdata('tglfak');
					$this->session->unset_userdata('suplier');
					$this->load->view('admin/alert/alert_sukses_grosir');
				}else{
					redirect('admin/penjualan_grosir');
				}
			}
			
		}else{
			echo $this->session->set_flashdata('msg','<label class="label label-danger">Penjualan Gagal di Simpan, Mohon Periksa Kembali Semua Inputan Anda!</label>');
			redirect('admin/penjualan_grosir');
		}

	}else{
        echo "Halaman tidak ditemukan";
    }
	}

	function cetak_faktur_grosir(){
		$x['data']=$this->penjualan_model->cetak_faktur();
		$this->load->view('admin/laporan/v_faktur_grosir',$x);
		//$this->session->unset_userdata('nofak');
	}

}
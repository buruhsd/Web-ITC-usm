<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_load_config_model extends CI_Model {

	/**
	 * @author : Muhammad Al Jawad
	 * @twitter: @buruhSD
	 **/
	 
	//query login
	public function __construct()
	{
		$dt = $this->db->get("web_setting");
		$i = 1;
		foreach($dt->result() as $d)
		{
			$_SESSION['konfig_app_'.$i] = $d->content_setting;
			$i++;
		}
		$_SESSION['site_title'] = $_SESSION['konfig_app_1'];
		$_SESSION['site_footer'] = $_SESSION['konfig_app_2'];
		$_SESSION['site_quotes'] = $_SESSION['konfig_app_3'];
		$_SESSION['site_slider'] = $_SESSION['konfig_app_4'];
		$_SESSION['site_kepala_itc'] = $_SESSION['konfig_app_5'];
		$_SESSION['limit_sidebar_pengumuman'] = $_SESSION['konfig_app_6'];
		$_SESSION['limit_sidebar_agenda'] = $_SESSION['konfig_app_7'];
		$_SESSION['nama_kepala_itc'] = $_SESSION['konfig_app_8'];
		$_SESSION['nip_kepala_itc'] = $_SESSION['konfig_app_9'];
		$_SESSION['limit_footer_artikel_itc'] = $_SESSION['konfig_app_10'];
		$_SESSION['site_limit_berita_slider'] = $_SESSION['konfig_app_11'];
		$_SESSION['site_slider_always'] = $_SESSION['konfig_app_12'];
		$_SESSION['site_theme'] = $_SESSION['konfig_app_13'];
		$_SESSION['site_sambutan'] = $_SESSION['konfig_app_14'];
		
		$st['stts'] = 0;
		$_SESSION['count_artikel_itc'] = $this->db->get_where("web_itc_artikel",$st)->num_rows();
		$_SESSION['count_galeri_itc'] = $this->db->get_where("web_itc_galeri_itc",$st)->num_rows();
		$_SESSION['count_berita'] = $this->db->get_where("web_multi_berita",$st)->num_rows();
		$_SESSION['count_pengumuman'] = $this->db->get_where("web_multi_pengumuman",$st)->num_rows();
		$_SESSION['count_agenda'] = $this->db->get_where("web_multi_agenda",$st)->num_rows();
		$_SESSION['count_buku_tamu'] = $this->db->get_where("web_super_buku_tamu",$st)->num_rows();
		$_SESSION['count_list_download'] = $this->db->get_where("web_itc_download",$st)->num_rows();
	}
}

/* End of file app_load_config_model.php */
/* Location: ./application/models/app_load_config_model.php */

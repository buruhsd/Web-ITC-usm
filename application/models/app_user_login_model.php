<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_user_login_model extends CI_Model {

	/**
	 * @author : Muhammad Al Jawad
	 * @twitter: @buruhSD
	 **/
	 
	public function cekUserLogin($data)
	{
		$tipe 				= $data['tipe'];
		
		if($tipe=="operator")
		{
			$cek['username'] 	= mysql_real_escape_string($data['username']);
			$cek['password'] 	= md5(mysql_real_escape_string($data['password']).$this->config->item("key_login"));
			$q_cek_login = $this->db->get_where('web_admin_itc', $cek);
			if(count($q_cek_login->result())>0)
			{
				foreach($q_cek_login->result() as $qad)
				{
					$sess_data['logged_in'] = 'yesGetMeLoginBaby';
					$sess_data['nama_user_login'] = $qad->nama_operator;
					$sess_data['id_itc'] = $qad->id_itc;
					$sess_data['username'] = $qad->username;
					$sess_data['email'] = $qad->email;
					$sess_data['id_admin_itc'] = $qad->id_admin_itc;
					$sess_data['tipe_user'] = $tipe;
					$get_p_itc = $this->db->get_where("web_itc_profil",array("id_itc_profil"=>$qad->id_itc))->row();
					$sess_data['id_jenjang_pendidikan'] = $get_p_itc->id_jenjang_pendidikan;
					$sess_data['id_kecamatan'] = $get_p_itc->id_kecamatan;
					$sess_data['nama_itc'] = $get_p_itc->nama_itc;
					$this->session->set_userdata($sess_data);
				}
				redirect("operator/dashboard");
			}
			else
			{
				$this->session->set_flashdata("result_login","Gagal Login. Username dan Password Tidak Cocok....");
				redirect("auth/user_login");
			}
		}
		
		else if($tipe=="admin_itc")
		{
			$cek['username_admin_itc'] 	= mysql_real_escape_string($data['username']);
			$cek['password'] 	= md5(mysql_real_escape_string($data['password']).$this->config->item("key_login"));
			$q_cek_login = $this->db->get_where('web_admin_itc', $cek);
			if(count($q_cek_login->result())>0)
			{
				foreach($q_cek_login->result() as $qad)
				{
					$sess_data['logged_in'] = 'yesGetMeLoginBaby';
					$sess_data['nama_user_login'] = $qad->nama_admin_itc;
					$sess_data['id_bidang'] = $qad->id_bidang;
					$sess_data['username'] = $qad->username_admin_itc;
					$sess_data['id_admin_itc'] = $qad->id_admin_itc;
					$sess_data['tipe_user'] = $tipe;
					
					$get_p_bidang = $this->db->get_where("web_super_bidang",array("id_super_bidang"=>$qad->id_bidang))->row();
					$sess_data['bidang'] = $get_p_bidang->bidang;
					$this->session->set_userdata($sess_data);
				}
				redirect("admin_itc/dashboard");
			}
			else
			{
				$this->session->set_flashdata("result_login","Gagal Login. Username dan Password Tidak Cocok....");
				redirect("auth/user_login");
			}
		}
		
		else if($tipe=="superadmin")
		{
			$cek['username_super_admin'] 	= mysql_real_escape_string($data['username']);
			$cek['password'] 	= md5(mysql_real_escape_string($data['password']).$this->config->item("key_login"));
			$q_cek_login = $this->db->get_where('web_admin_super', $cek);
			if(count($q_cek_login->result())>0)
			{
				foreach($q_cek_login->result() as $qad)
				{
					$sess_data['logged_in'] = 'yesGetMeLoginBaby';
					$sess_data['nama_user_login'] = $qad->nama_super_admin;
					$sess_data['username'] = $qad->username_super_admin;
					$sess_data['id_admin_super'] = $qad->id_admin_super;
					$sess_data['tipe_user'] = $tipe;
					
					$this->session->set_userdata($sess_data);
				}
				redirect("superadmin");
			}
			else
			{
				$this->session->set_flashdata("result_login","Gagal Login. Username dan Password Tidak Cocok....");
				redirect("auth/user_login");
			}
		}
	}
}

/* End of file app_user_login_model.php */
/* Location: ./application/models/app_user_login_model.php */

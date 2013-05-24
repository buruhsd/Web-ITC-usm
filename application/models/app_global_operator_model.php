<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_global_operator_model extends CI_Model {

	/**
	 * @author : Muhammad Al Jawad
	 * @twitter: @buruhSD
	 **/
	public function generate_captcha()
	{
		$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '150',
			'img_height' => 40
			);
		$cap = create_captcha($vals);
		$datamasuk = array(
			'captcha_time' => $cap['time'],
			//'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
			);
		$expiration = time()-3600;
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		$query = $this->db->insert_string('captcha', $datamasuk);
		$this->db->query($query);
		return $cap['image'];
	}
	 
	
	 
	 
	public function generate_index_galeri_itc($limit,$offset,$filter=array())
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['judul']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['judul'] = $filter['judul']; 
				$query_add = "and a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.gambar, a.judul, b.nama_itc, a.id_itc_galeri_itc, a.stts from web_itc_galeri_itc a 
		left join web_itc_profil b on a.id_itc=b.id_itc_profil where 
		a.id_itc='".$this->session->userdata("id_itc")."' ".$query_add."");
		
		$config['base_url'] = base_url() . 'operator/galeri_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.gambar, a.judul, b.nama_itc, a.id_itc_galeri_itc, a.stts from web_itc_galeri_itc a left 
		join web_itc_profil b on a.id_itc=b.id_itc_profil where a.id_itc='".$this->session->userdata("id_itc")."' ".$query_add."
		 order by a.judul ASC LIMIT ".$offset.",".$limit."");
		
		foreach($w->result() as $h)
		{
			$color = '';
			if($h->stts==0)
			{
				$color = 'style="background-color:red;"';
			}
			$hasil .= '<div class="border-photo-gallery-index" '.$color.'><div class="hide-photo-gallery-index">
			<a href="'.base_url().'asset/images/galeri-itc/medium/'.$h->gambar.'" rel="galeri" title="'.$h->judul.'">
			<img src="'.base_url().'asset/images/galeri-itc/thumb/'.$h->gambar.'" title="'.$h->judul.'" /></a></div>
			<div class="cleaner_h10"></div>
			<a href="'.base_url().'operator/galeri_itc/edit/'.$h->id_itc_galeri_itc.'">Edit</a> | 
			<a href="'.base_url().'operator/galeri_itc/hapus/'.$h->id_itc_galeri_itc.'/'.$h->gambar.'" onClick=\'return confirm("Anda yakin?");\'>Hapus</a>
			</div>';
		}
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_artikel_itc($limit,$offset,$filter=array())
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['judul']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['judul'] = $filter['judul']; 
				$query_add = "and a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul, a.tanggal, a.gambar, b.nama_itc, a.id_itc_artikel, a.stts from web_itc_artikel a left join web_itc_profil b 
		on a.id_itc_profil=b.id_itc_profil where a.id_itc_profil='".$this->session->userdata("id_itc")."' ".$query_add."");

		$config['base_url'] = base_url() . 'operator/artikel_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tanggal, a.gambar, a.id_itc_artikel, b.nama_itc, a.stts from web_itc_artikel a left join web_itc_profil b 
		on a.id_itc_profil=b.id_itc_profil where a.id_itc_profil='".$this->session->userdata("id_itc")."' ".$query_add." order by a.judul ASC 
		LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table width='100%' style='border-collapse:collapse;' cellpadding='8' cellspacing='0' border='1' width='100%'>
					<tr bgcolor='#F2F2F2' align='center'>
					<td>No.</td>
					<td>Judul</td>
					<td>Tanggal</td>
					<td>Nama itc</td>
					<td>Status</td>
					<td bgcolor='#000' colspan='2'><a href='".base_url()."operator/artikel_itc/tambah'>Tambah</a></td>
					</tr>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="Moderation";
			$color="#EBF8A4";
			if($h->stts==1){$st="Approve"; $color="";}
			$hasil .= "<tr bgcolor='".$color."'>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->nama_itc."</td>
					<td>".$st."</td>
					<td bgcolor='000'><a href='".base_url()."operator/artikel_itc/edit/".$h->id_itc_artikel."'>Edit</a></td>
					<td bgcolor='000'><a href='".base_url()."operator/artikel_itc/hapus/".$h->id_itc_artikel."/".$h->gambar."' 
					onClick=\"return confirm('Anda yakin?');\">Hapus</a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	
	
}

/* End of file app_global_model.php */

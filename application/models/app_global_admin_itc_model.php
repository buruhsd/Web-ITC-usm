<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_global_admin_itc_model extends CI_Model {

	/**
	 * @author : Muhammad Al Jawad
	 * @twitter: @buruhSD
	 **/
	 
	public function generate_index_pengumuman($limit,$offset,$filter=array())
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

		$tot_hal = $this->db->query("select a.judul, a.id_multi_pengumuman, b.bidang, 
		a.stts from web_multi_pengumuman a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add."");
		$config['base_url'] = base_url() . 'admin_itc/pengumuman/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tanggal, a.id_multi_pengumuman, b.bidang,
		a.stts from web_multi_pengumuman a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add." order by a.judul ASC LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table width='100%' style='border-collapse:collapse;' cellpadding='8' cellspacing='0' border='1' width='100%'>
					<tr bgcolor='#F2F2F2' align='center'>
					<td>No.</td>
					<td>Judul</td>
					<td>Tanggal</td>
					<td>Bidang</td>
					<td>Status</td>
					<td bgcolor='#000' colspan='2'><a href='".base_url()."admin_itc/pengumuman/tambah'>Tambah</a></td>
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
					<td>".$h->bidang."</td>
					<td>".$st."</td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/pengumuman/edit/".$h->id_multi_pengumuman."'>Edit</a></td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/pengumuman/hapus/".$h->id_multi_pengumuman."' 
					onClick=\"return confirm('Anda yakin?');\">Hapus</a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_agenda_itc($limit,$offset,$filter=array())
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

		$tot_hal = $this->db->query("select a.judul, a.id_multi_agenda, b.bidang, a.tanggal,   
		a.stts from web_multi_agenda a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add."");
		$config['base_url'] = base_url() . 'admin_itc/agenda_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.id_multi_agenda, b.bidang, a.tanggal,  
		a.stts from web_multi_agenda a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add." order by a.judul ASC LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table width='100%' style='border-collapse:collapse;' cellpadding='8' cellspacing='0' border='1' width='100%'>
					<tr bgcolor='#F2F2F2' align='center'>
					<td>No.</td>
					<td>Judul</td>
					<td>Tanggal</td>
					<td>Bidang</td>
					<td>Status</td>
					<td bgcolor='#000' colspan='2'><a href='".base_url()."admin_itc/agenda_itc/tambah'>Tambah</a></td>
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
					<td>".$h->bidang."</td>
					<td>".$st."</td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/agenda_itc/edit/".$h->id_multi_agenda."'>Edit</a></td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/agenda_itc/hapus/".$h->id_multi_agenda."' 
					onClick=\"return confirm('Anda yakin?');\">Hapus</a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_list_download($limit,$offset,$filter=array())
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['judul_file']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['judul_file'] = $filter['judul_file']; 
				$query_add = "and a.judul_file like '%".$where['judul_file']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul_file, a.id_itc_download, b.bidang, a.nama_file,   
		a.stts from web_itc_download a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add."");
		$config['base_url'] = base_url() . 'admin_itc/list_download/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul_file, a.id_itc_download, b.bidang, a.nama_file,   
		a.stts from web_dinas_download a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where 
		a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add." order by a.judul_file ASC LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table width='100%' style='border-collapse:collapse;' cellpadding='8' cellspacing='0' border='1' width='100%'>
					<tr bgcolor='#F2F2F2' align='center'>
					<td>No.</td>
					<td>Judul File</td>
					<td>Nama File</td>
					<td>Bidang</td>
					<td>Status</td>
					<td bgcolor='#000' colspan='2'><a href='".base_url()."admin_itc/list_download/tambah'>Tambah</a></td>
					</tr>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="Moderation";
			$color="#EBF8A4";
			if($h->stts==1){$st="Approve"; $color="";}
			$hasil .= "<tr bgcolor='".$color."'>
					<td>".$i."</td>
					<td>".$h->judul_file."</td>
					<td>".$h->nama_file."</td>
					<td>".$h->bidang."</td>
					<td>".$st."</td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/list_download/edit/".$h->id_itc_download."'>Edit</a></td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/list_download/hapus/".$h->id_itc_download."/".$h->nama_file."' 
					onClick=\"return confirm('Anda yakin?');\">Hapus</a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	 
	public function generate_index_berita_itc($limit,$offset,$filter=array())
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

		$tot_hal = $this->db->query("select a.judul, a.id_multi_berita, a.gambar, a.tanggal, b.bidang, a.stts, a.headline from web_multi_berita a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add."");

		$config['base_url'] = base_url() . 'operator/artikel_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.gambar, a.tanggal, b.bidang, a.stts, a.id_multi_berita, a.headline from web_multi_berita a left join web_super_bidang b on a.id_bidang=b.id_super_bidang where a.id_bidang='".$this->session->userdata("id_bidang")."' ".$query_add." order by a.judul ASC 
		LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table width='100%' style='border-collapse:collapse;' cellpadding='8' cellspacing='0' border='1' width='100%'>
					<tr bgcolor='#F2F2F2' align='center'>
					<td>No.</td>
					<td>Judul</td>
					<td>Tanggal</td>
					<td>Bidang</td>
					<td>Headline</td>
					<td>Status</td>
					<td bgcolor='#000' colspan='2'><a href='".base_url()."admin_itc/berita_itc/tambah'>Tambah</a></td>
					</tr>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="Moderation";
			$color="#EBF8A4";
			$headline="No";
			if($h->stts==1){$st="Approve"; $color="";}
			if($h->headline=="y"){$headline="Yes";}

			$hasil .= "<tr bgcolor='".$color."'>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->bidang."</td>
					<td>".$headline."</td>
					<td>".$st."</td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/berita_itc/edit/".$h->id_multi_berita."'>Edit</a></td>
					<td bgcolor='000'><a href='".base_url()."admin_itc/berita_itc/hapus/".$h->id_multi_berita."/".$h->gambar."' 
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

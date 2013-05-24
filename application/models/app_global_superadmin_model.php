<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_global_superadmin_model extends CI_Model {

	/**
	 * @author : Muhammad Al Jawad
	 * @twitter: @buruhSD
	 **/
	 
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
				$query_add = "where a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul, a.tanggal, a.gambar, b.nama_itc, a.id_itc_artikel, a.stts from web_itc_artikel a left join web_itc_profil b 
		on a.id_itc_profil=b.id_itc_profil ".$query_add."");

		$config['base_url'] = base_url() . 'superadmin/artikel_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tanggal, a.gambar, a.id_itc_artikel, b.nama_itc, a.stts from web_itc_artikel a left join web_itc_profil b 
		on a.id_itc_profil=b.id_itc_profil ".$query_add." order by a.stts ASC 
		LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Tanggal</th>
					<th>Nama itc</th>
					<th>Status</th>
					<th></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->nama_itc."</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/artikel_itc/approve/".$h->id_itc_artikel."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/artikel_itc/approve/".$h->id_itc_artikel."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/artikel_itc/hapus/".$h->id_itc_artikel."/".$h->gambar."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
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
				$query_add = "where a.judul_file like '%".$where['judul_file']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul_file, a.nama_file, a.id_itc_download, b.bidang, c.nama_admin_itc from web_itc_download a 
		left join web_super_bidang b on a.id_bidang=b.id_super_bidang left join web_admin_itc c on a.id_admin_itc=c.id_admin_itc 
		".$query_add."");

		$config['base_url'] = base_url() . 'superadmin/list_download/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul_file, a.stts, a.nama_file, a.id_itc_download, b.bidang, c.nama_admin_itc from web_itc_download a 
		left join web_super_bidang b on a.id_bidang=b.id_super_bidang left join web_admin_itc c on a.id_admin_itc=c.id_admin_itc 
		".$query_add." order by a.stts ASC limit ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul File</th>
					<th>Nama File</th>
					<th>Bidang</th>
					<th>Nama User</th>
					<th>Status</th>
					<th></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul_file."</td>
					<td>".$h->nama_file."</td>
					<td>".$h->bidang."</td>
					<td>".$h->nama_admin_itc."</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/list_download/approve/".$h->id_itc_download."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/list_download/approve/".$h->id_itc_download."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/list_download/hapus/".$h->id_itc_download."/".$h->nama_file."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_buku_tamu($limit,$offset,$filter=array())
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['nama']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['nama'] = $filter['nama']; 
				$query_add = "where a.nama like '%".$where['nama']."%'";
			}
		}

		$tot_hal = $this->db->get("web_super_buku_tamu");

		$config['base_url'] = base_url() . 'superadmin/buku_tamu/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->order_by("stts","ASC")->get("web_super_buku_tamu",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Kontak</th>
					<th>Pesan</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama."</td>
					<td>".$h->kontak."</td>
					<td>".strip_tags($h->pesan)."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/buku_tamu/approve/".$h->id_super_buku_tamu."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/buku_tamu/approve/".$h->id_super_buku_tamu."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/buku_tamu/hapus/".$h->id_super_buku_tamu."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_agenda($limit,$offset,$filter=array())
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
				$query_add = "where a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul, a.id_multi_agenda, b.bidang, a.tanggal,   
		a.stts from web_multi_agenda a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add."");

		$config['base_url'] = base_url() . 'superadmin/agenda/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tipe_user, a.id_multi_agenda, b.bidang, a.tanggal,   
		a.stts from web_multi_agenda a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." order by a.stts ASC
		LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Tanggal</th>
					<th>Bidang</th>
					<th>Tipe User</th>
					<th>Status</th>
					<th><a href='".base_url()."superadmin/agenda/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->bidang."</td>
					<td>".$h->tipe_user."</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/agenda/approve/".$h->id_multi_agenda."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/agenda/approve/".$h->id_multi_agenda."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/agenda/edit/".$h->id_multi_agenda."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/agenda/hapus/".$h->id_multi_agenda."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
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
				$query_add = "where a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul, a.tipe_user, a.tanggal, a.id_multi_pengumuman, b.bidang,
		a.stts from web_multi_pengumuman a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." 
		order by a.stts ASC");

		$config['base_url'] = base_url() . 'superadmin/pengumuman/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tipe_user, a.tanggal, a.id_multi_pengumuman, b.bidang,
		a.stts from web_multi_pengumuman a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." 
		order by a.stts ASC LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Tanggal</th>
					<th>Bidang</th>
					<th>Tipe User</th>
					<th>Status</th>
					<th><a href='".base_url()."superadmin/pengumuman/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->bidang."</td>
					<td>".$h->tipe_user."</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/pengumuman/approve/".$h->id_multi_pengumuman."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/pengumuman/approve/".$h->id_multi_pengumuman."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/pengumuman/edit/".$h->id_multi_pengumuman."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/pengumuman/hapus/".$h->id_multi_pengumuman."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_berita($limit,$offset,$filter=array())
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
				$query_add = "where a.judul like '%".$where['judul']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.judul, a.id_multi_berita, a.gambar, a.tanggal, b.bidang, a.stts, a.headline from 
		web_multi_berita a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." order by a.stts ASC");

		$config['base_url'] = base_url() . 'superadmin/berita/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.judul, a.tipe_user, a.id_multi_berita, a.gambar, a.tanggal, b.bidang, a.stts, a.headline from 
		web_multi_berita a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." order by a.stts ASC
		 LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Tanggal</th>
					<th>Bidang</th>
					<th width='80'>Tipe User</th>
					<th>Headline</th>
					<th>Status</th>
					<th width='110'><a href='".base_url()."superadmin/berita/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".generate_tanggal(gmdate('d/m/Y-H:i:s',$h->tanggal))." WIB</td>
					<td>".$h->bidang."</td>
					<td>".$h->tipe_user."</td>
					<td>".$h->headline."</td>
					<td>".$st."</td>
					<td>";
					$hasil .= "";
			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/berita/approve/".$h->id_multi_berita."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/berita/approve/".$h->id_multi_berita."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/berita/edit/".$h->id_multi_berita."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/berita/hapus/".$h->id_multi_berita."/".$h->gambar."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_admin_itc($limit,$offset,$filter=array())
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['nama_admin_itc']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['nama_admin_itc'] = $filter['nama_admin_itc']; 
				$query_add = "where a.nama_admin_itc like '%".$where['nama_admin_itc']."%'";
			}
		}

		$tot_hal = $this->db->query("select a.nama_admin_itc, a.username_admin_itc, b.bidang, a.id_admin_itc from 
		web_admin_itc a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." order by a.nama_admin_itc ASC");

		$config['base_url'] = base_url() . 'superadmin/admin_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query("select a.nama_admin_itc, a.username_admin_itc, b.bidang, a.id_admin_itc from 
		web_admin_itc a left join web_super_bidang b on a.id_bidang=b.id_super_bidang ".$query_add." order by a.nama_admin_itc ASC
		 LIMIT ".$offset.",".$limit."");
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Admin itc</th>
					<th>Username Admin itc</th>
					<th>Bidang</th>
					<th width='110'><a href='".base_url()."superadmin/admin_itc/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_admin_itc."</td>
					<td>".$h->username_admin_itc."</td>
					<td>".$h->bidang."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/admin_itc/edit/".$h->id_admin_itc."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/admin_itc/hapus/".$h->id_admin_itc."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_link($limit,$offset,$filter)
	{
		$hasil="";

		$tot_hal = $this->db->like('nama_link',$filter['nama_link'])->get("web_super_link_terkait");

		$config['base_url'] = base_url() . 'superadmin/link/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('nama_link',$filter['nama_link'])->get("web_super_link_terkait",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul Link</th>
					<th>Link</th>
					<th width='110'><a href='".base_url()."superadmin/link/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_link."</td>
					<td>".$h->url."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/link/edit/".$h->id_super_link_terkait."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/link/hapus/".$h->id_super_link_terkait."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	
	 
	public function generate_index_bidang($limit,$offset,$filter)
	{
		$hasil="";

		$tot_hal = $this->db->like('bidang',$filter['bidang'])->get("web_super_bidang");

		$config['base_url'] = base_url() . 'superadmin/bidang/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('bidang',$filter['bidang'])->get("web_super_bidang",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Bidang</th>
					<th width='110'><a href='".base_url()."superadmin/bidang/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->bidang."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/bidang/edit/".$h->id_super_bidang."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/bidang/hapus/".$h->id_super_bidang."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	
	 
	public function generate_index_anggota($limit,$offset,$filter)
	{
		$hasil="";

		$tot_hal = $this->db->like('nama',$filter['nama'])->get("web_super_anggota");

		$config['base_url'] = base_url() . 'superadmin/anggota/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('nama',$filter['nama'])->get("web_super_anggota",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>NIP</th>
					<th>Nama</th>
					<th>Jabatan</th>
					<th>Kontak</th>
					<th width='110'><a href='".base_url()."superadmin/anggota/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nip."</td>
					<td>".$h->nama."</td>
					<td>".$h->jabatan."</td>
					<td>".$h->kontak."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/anggota/edit/".$h->id_super_anggota."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/anggota/hapus/".$h->id_super_anggota."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_itc($limit,$offset,$filter)
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['nama_itc']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['nama_itc'] = $filter['nama_itc']; 
				$query_add = "where a.nama_itc like '%".$where['nama_itc']."%'";
			}
		}

		$tot_hal = $this->db->like('nama_itc',$filter['nama_itc'])->get("web_itc_profil");

		$config['base_url'] = base_url() . 'superadmin/itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query('select a.nama_itc, b.keahlian, c.kecamatan, a.id_itc_profil from web_itc_profil a left join 
		web_super_jenjang_keahlian b on a.id_jenjang_keahlian=b.id_super_jenjang_keahlian left join web_super_kecamatan c 
		on a.id_kecamatan=c.id_super_kecamatan '.$query_add.' LIMIT '.$offset.','.$limit.'');
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama itc</th>
					<th>Jenjang keahlian</th>
					<th>Kecamatan</th>
					<th width='110'><a href='".base_url()."superadmin/itc/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_itc."</td>
					<td>".$h->keahlian."</td>
					<td>".$h->kecamatan."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/itc/edit/".$h->id_itc_profil."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/itc/hapus/".$h->id_itc_profil."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_operator($limit,$offset,$filter)
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['nama_operator']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['nama_operator'] = $filter['nama_operator']; 
				$query_add = "where a.nama_operator like '%".$where['nama_operator']."%'";
			}
		}

		$tot_hal = $this->db->like('nama_operator',$filter['nama_operator'])->get("web_admin_itc");

		$config['base_url'] = base_url() . 'superadmin/operator/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query('select b.nama_itc, a.nama_operator, a.username, a.email, a.id_admin_itc from web_admin_itc a left join 
		web_itc_profil b on a.id_itc=b.id_itc_profil '.$query_add.' LIMIT '.$offset.','.$limit.'');
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Operator</th>
					<th>Nama itc</th>
					<th>Username</th>
					<th>Email</th>
					<th width='110'><a href='".base_url()."superadmin/operator/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_operator."</td>
					<td>".$h->nama_itc."</td>
					<td>".$h->username."</td>
					<td>".$h->email."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/operator/edit/".$h->id_admin_itc."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/operator/hapus/".$h->id_admin_itc."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_polling($limit,$offset,$filter)
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['pertanyaan']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['pertanyaan'] = $filter['pertanyaan']; 
				$query_add = "where a.pertanyaan like '%".$where['pertanyaan']."%'";
			}
		}

		$tot_hal = $this->db->like('pertanyaan',$filter['pertanyaan'])->get("web_super_pertanyaan_poll");

		$config['base_url'] = base_url() . 'superadmin/polling/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('pertanyaan',$filter['pertanyaan'])->get("web_super_pertanyaan_poll",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Pertanyaan</th>
					<th>Status</th>
					<th width='110'><a href='".base_url()."superadmin/polling/tambah' class='btn btn'><i class='icon-plus'></i> Tambah Data</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st = "<span class='label label-important'>Tidak Aktif</span>";
			if($h->aktif=="1"){$st="<span class='label label-info'>Aktif</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->pertanyaan."</td>
					<td>".$st."</td>
					<td>";
			if($h->aktif==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/polling/approve/".$h->id_super_pertanyaan_poll."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/polling/approve/".$h->id_super_pertanyaan_poll."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/jawaban_polling/index/".$h->id_super_pertanyaan_poll."' class='btn btn-small'><i class='icon-share'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/polling/edit/".$h->id_super_pertanyaan_poll."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/polling/hapus/".$h->id_super_pertanyaan_poll."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_jawaban_polling($id_question,$limit,$offset,$filter)
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['jawaban']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['jawaban'] = $filter['jawaban']; 
				$query_add = "where a.jawaban like '%".$where['jawaban']."%'";
			}
		}
		
		$where['id_pertanyaan'] = $id_question;

		$tot_hal = $this->db->like('jawaban',$filter['jawaban'])->get_where("web_super_jawaban_poll",$where);

		$config['base_url'] = base_url() . 'superadmin/jawaban_polling/index/'.$id_question.'/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('jawaban',$filter['jawaban'])->get_where("web_super_jawaban_poll",$where,$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Jawaban</th>
					<th>Jumlah</th>
					<th width='110'><a href='".base_url()."superadmin/jawaban_polling/tambah/".$id_question."' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->jawaban."</td>
					<td>".$h->jum."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/jawaban_polling/edit/".$id_question."/".$h->id_super_jawaban_poll."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/jawaban_polling/hapus/".$id_question."/".$h->id_super_jawaban_poll."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_user($limit,$offset,$filter=array())
	{
		$hasil="";
		$tot_hal = $this->db->like('nama_super_admin',$filter['nama_super_admin'])->get("web_admin_super");

		$config['base_url'] = base_url() . 'superadmin/admin_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->like('nama_super_admin',$filter['nama_super_admin'])->get("web_admin_super",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Super Admin</th>
					<th>Username Super Admin</th>
					<th width='110'><a href='".base_url()."superadmin/user/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_super_admin."</td>
					<td>".$h->username_super_admin."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/user/edit/".$h->id_admin_super."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/user/hapus/".$h->id_admin_super."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_sistem($limit,$offset)
	{
		$hasil="";
		$tot_hal = $this->db->get("web_setting");

		$config['base_url'] = base_url() . 'superadmin/sistem/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->get("web_setting",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Pengaturan</th>
					<th>Tipe</th>
					<th></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->title."</td>
					<td>".$h->tipe."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/sistem/edit/".$h->id_setting."' class='btn'><i class='icon-edit'></i> Edit</a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_menu($parent=0,$hasil)
	{
		$where['id_parent']=$parent;
		$w = $this->db->get_where("web_menu",$where);
		$w_q = $this->db->get_where("web_menu",$where)->row();
		if(($w->num_rows())>0)
		{
			$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th width='110' colspan='8'></th>
					</tr>
					</thead>";
		}
		foreach($w->result() as $h)
		{
			$where_sub['id_parent']=$h->id_menu;
			$w_sub = $this->db->get_where("web_menu",$where_sub);
			if(($w_sub->num_rows())>0)
			{
				$hasil .= "<tr><td>".$h->menu." </td><td><a href='".base_url()."superadmin/routing_pages/edit/".$h->id_menu."' class='btn btn-small'><i class='icon-edit'></i> Edit</a><a href='".base_url()."superadmin/routing_pages/hapus/".$h->id_menu."' class='btn btn-small' onClick=\"return confirm('Anda yakin?');\" ><i class='icon-trash'></i> Hapus</a>";
			}
			else
			{
				if($h->id_parent==0)
				{
				$hasil .= "<tr><td>".$h->menu." </td><td><a href='".base_url()."superadmin/routing_pages/edit/".$h->id_menu."' class='btn btn-small'><i class='icon-edit'></i> Edit</a><a href='".base_url()."superadmin/routing_pages/hapus/".$h->id_menu."' class='btn btn-small' onClick=\"return confirm('Anda yakin?');\" ><i class='icon-trash'></i> Hapus</a>";
				}
				else
				{
				$hasil .= "<tr><td width='250'>&raquo; ".$h->menu." </td><td><a href='".base_url()."superadmin/routing_pages/edit/".$h->id_menu."' class='btn btn-small'><i class='icon-edit'></i> Edit</a><a href='".base_url()."superadmin/routing_pages/hapus/".$h->id_menu."' class='btn btn-small' onClick=\"return confirm('Anda yakin?');\" ><i class='icon-trash'></i> Hapus</a>";
				}
			}
			$hasil = $this->generate_menu($h->id_menu,$hasil);
			$hasil .= "</td></tr>";
		}
		if(($w->num_rows)>0)
		{
			$hasil .= "</table>";
		}
		return $hasil;
	}
	 
	public function generate_index_galeri_kegiatan($limit,$offset,$filter)
	{
		$hasil="";
		$where['nama_album'] = $filter['nama_album']; 

		$tot_hal = $this->db->like("nama_album",$where['nama_album'])->get("web_super_album_galeri_itc");

		$config['base_url'] = base_url() . 'superadmin/galeri_kegiatan/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w =  $this->db->like("nama_album",$where['nama_album'])->get("web_super_album_galeri_itc",$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama Album</th>
					<th width='110'><a href='".base_url()."superadmin/galeri_kegiatan/tambah' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_album."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/foto_galeri_kegiatan/index/".$h->id_abum_galeri_itc."' class='btn btn-small'><i class='icon-share'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/galeri_kegiatan/edit/".$h->id_abum_galeri_itc."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/galeri_kegiatan/hapus/".$h->id_abum_galeri_itc."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	 
	public function generate_index_foto_galeri_kegiatan($id_album,$limit,$offset)
	{
		$hasil="";
		$where['id_album'] = $id_album;
		$tot_hal = $this->db->get_where("web_super_galeri_itc",$where);

		$config['base_url'] = base_url() . 'superadmin/foto_galeri_kegiatan/index/'.$id_album.'';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w =  $this->db->get_where("web_super_galeri_itc",$where,$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Gambar</th>
					<th width='110'><a href='".base_url()."superadmin/foto_galeri_kegiatan/tambah/".$id_album."' class='btn btn'><i class='icon-plus'></i> Tambah</a></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td><img src='".base_url()."asset/images/galeri/thumb/".$h->gambar."' width='50'></td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/foto_galeri_kegiatan/edit/".$id_album."/".$h->id_super_galeri_itc."' class='btn btn-small'><i class='icon-edit'></i></a>";
			$hasil .= "<a href='".base_url()."superadmin/foto_galeri_kegiatan/hapus/".$id_album."/".$h->id_super_galeri_itc."/".$h->gambar."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}
	 
	public function generate_index_galeri_itc($limit,$offset,$filter)
	{
		$hasil="";
		$query_add = "";
		if(!empty($filter))
		{
			if($filter['nama_itc']=="")
			{
				$query_add = "";
			}
			else
			{
				$where['nama_itc'] = $filter['nama_itc']; 
				$query_add = "where a.nama_itc like '%".$where['nama_itc']."%'";
			}
		}

		$tot_hal = $this->db->like('nama_itc',$filter['nama_itc'])->get("web_itc_profil");

		$config['base_url'] = base_url() . 'superadmin/galeri_itc/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w = $this->db->query('select a.nama_itc, b.keahlian, c.kecamatan, a.id_itc_profil, (select count(id_itc_galeri_itc) as jum from web_itc_galeri_itc where stts=0 and id_itc=a.id_itc_profil) jum from web_itc_profil a left join 
		web_super_jenjang_keahlian b on a.id_jenjang_keahlian=b.id_super_jenjang_keahlian left join web_super_kecamatan c 
		on a.id_kecamatan=c.id_super_kecamatan '.$query_add.' order by jum DESC LIMIT '.$offset.','.$limit.'');
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Nama itc</th>
					<th>Jenjang keahlian</th>
					<th>Kecamatan</th>
					<th>Moderation</th>
					<th width='110'></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$jum="<span class='label label-info'>".$h->jum." foto</span>";
			if($h->jum>0){$jum="<span class='label label-important'>".$h->jum." foto</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->nama_itc."</td>
					<td>".$h->keahlian."</td>
					<td>".$h->kecamatan."</td>
					<td>".$jum."</td>
					<td>";
			$hasil .= "<a href='".base_url()."superadmin/galeri_itc/detail/".$h->id_itc_profil."' class='btn btn-small'><i class='icon-share'></i></a></td>
					</tr>";
			$i++;
		}
		$hasil .= '</table>';
		$hasil .= '<div class="cleaner_h20"></div>';
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}	
	 
	 
	public function generate_index_foto_galeri_itc($id_itc,$limit,$offset)
	{
		$hasil="";
		$where['id_itc'] = $id_itc;
		$tot_hal = $this->db->get_where("web_itc_galeri_itc",$where);

		$config['base_url'] = base_url() . 'superadmin/galeri_itc/detail/'.$id_itc.'';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);

		$w =  $this->db->order_by("stts","ASC")->get_where("web_itc_galeri_itc",$where,$limit,$offset);
		
		$hasil .= "<table class='table table-striped table-condensed'>
					<thead>
					<tr>
					<th>No.</th>
					<th>Judul</th>
					<th>Status</th>
					<th>Gambar</th>
					<th width='110'></th>
					</tr>
					</thead>";
		$i = $offset+1;
		foreach($w->result() as $h)
		{
			$st="<span class='label label-important'>Moderation</span>";
			if($h->stts==1){$st="<span class='label label-success'>Approve</span>";}
			$hasil .= "<tr>
					<td>".$i."</td>
					<td>".$h->judul."</td>
					<td>".$st."</td>
					<td><img src='".base_url()."asset/images/galeri-itc/thumb/".$h->gambar."' width='50'></td>
					<td>";

			if($h->stts==1)
			{
				$hasil .= "<a href='".base_url()."superadmin/galeri_itc/approve/".$id_itc."/".$h->id_itc_galeri_itc."/0' class='btn btn-small'><i class='icon-remove'></i></a>";
			}
			else
			{
				$hasil .= "<a href='".base_url()."superadmin/galeri_itc/approve/".$id_itc."/".$h->id_itc_galeri_itc."/1' class='btn btn-small'><i class='icon-ok'></i></a>";
			}
			$hasil .= "<a href='".base_url()."superadmin/galeri_itc/hapus/".$id_itc."/".$h->id_itc_galeri_itc."/".$h->gambar."' onClick=\"return confirm('Anda yakin?');\" class='btn btn-small'><i class='icon-trash'></i></a></td>
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

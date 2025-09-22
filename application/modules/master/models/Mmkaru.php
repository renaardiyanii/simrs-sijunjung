<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkaru extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function insert($payload){
            return $this->db->insert('user_kepala_ruangan',$payload);
        }
        function update_by_userid($userid,$payload){
            return $this->db->where('userid',$userid)->update('user_kepala_ruangan',$payload);
        }
        function update_by_idrg($idrg,$payload){
            return $this->db->where('idrg',$idrg)->update('user_kepala_ruangan',$payload);
        }
        function update_by_id($id,$payload){
            return $this->db->where('id',$id)->update('user_kepala_ruangan',$payload);
        }
        function delete($id){
            return $this->db->where('id',$id)->delete('user_kepala_ruangan');
        }

        function get_all()
        {
            return $this->db->select('*')
            ->from('user_kepala_ruangan e')
            ->join('hmis_users u', 'u.userid = e.userid', 'left')
            ->join('ruang r', 'r.idrg = e.idrg', 'left')
            ->get(); 
        }

        function get_ruangan()
        {
            return $this->db->get('ruang');
        }

        // get user dimana user bukan dokter sesuai dengan relasi dyn_user_dokter
        function get_user()
        {
            return $this->db->select('h.userid,h.name')
            ->from('hmis_users h')
            ->join('dyn_user_dokter d','d.userid = h.userid','left')
            ->where('d.userid is null')
            ->get();
        }
	}
?>

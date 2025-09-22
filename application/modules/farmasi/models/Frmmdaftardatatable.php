<?php
/**
 * Models     : Datatables serverside based php
 * Modified   : Fauzan Falah
 * Website    : https://www.codekop.com/
 * 
 * 
 * 
 * 
 */
    class Frmmdaftardatatable extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
        }
 
        function get_tables($tables,$cari,$iswhere,$subquery='',$wherewajib='')
        {
            $search = htmlspecialchars($_POST['search']['value']??"");
            // Ambil data limit per page
            if(!isset($_POST['length'])){
                $_POST['length'] = 10;
            }
           
            $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
            // Ambil data start

            if(!isset($_POST['start'])){
                $_POST['start'] = 0;
            }
            $start =preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}"); 
            
            $query = $tables;
            
            // if(!empty($iswhere)){
            //     if($wherewajib!= ''){
            //         $sql = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE ".$iswhere.' AND '.$wherewajib);
            //     }else{
            //         $sql = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE ".$iswhere);
            //     }
            // }else{
            //     if($wherewajib!= ''){
            //         $sql = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE ".$wherewajib);
            //     }else{
            //         $sql = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query);
            //     }
            // }

            // $sql_count = $sql->num_rows();

            if($search!=''){

                $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
            }else{
                $cari = null;
            }
            // var_dump($cari);die();
            
            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = !isset($_POST['order'][0]['column'])?null:$_POST['order'][0]['column']; 

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = !isset($_POST['order'][0]['dir'])?null:$_POST['order'][0]['dir']; 
            $order = !isset($_POST['order'][0]['dir'])?'':" ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;

            if(!empty($iswhere) && $search == ''){
                if($wherewajib!= ''){
                    $sql_data = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE $iswhere  ".($cari?"AND (".$cari.")":"").'AND'.$wherewajib.' '.''." LIMIT ".$limit." OFFSET ".$start);
                
                }else{

                    $sql_data = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE $iswhere  ".($cari?"AND (".$cari.")":"").''." LIMIT ".$limit." OFFSET ".$start);
                }
            }else{
                if($wherewajib!= ''){
                    $sql_data = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE ".($cari?"(".$cari.")":"").'AND'.$wherewajib.' '.''." LIMIT ".$limit." OFFSET ".$start);
                
                }else{

                    $sql_data = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE "($cari?"(".$cari.")":"").''." LIMIT ".$limit." OFFSET ".$start);
                }
            }
            $sql_count = $sql_data->num_rows();
            // var_dump($sql_data->result_array());die();

            // if(isset($search))
            // {
            //     if(!empty($iswhere) && $search == ''){
            //         if($wherewajib!= ''){
            //             $sql_cari =  $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE $iswhere AND (".$cari.") AND".$wherewajib);
            //         }else{
            //             $sql_cari =  $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE $iswhere AND (".$cari.")");
            //         }
            //     }else{
            //         if($wherewajib!= ''){
            //             $sql_cari =  $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE (".$cari.") and ".$wherewajib);
            //         }else{
            //             $sql_cari =  $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query." WHERE (".$cari.")");
            //         }
            //     }
            //     $sql_filter_count = $sql_cari->num_rows();
            // }else{
            //     if(!empty($iswhere)){
            //         if($wherewajib!= ''){
            //             $sql_filter = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query."WHERE ".$iswhere.' AND'.$wherewajib);
            //         }else{
            //             $sql_filter = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query."WHERE ".$iswhere);
            //         }
            //     }else{
            //         if($wherewajib!= ''){
                    
            //             $sql_filter = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query.' AND '.$wherewajib);
            //         }else{
            //             $sql_filter = $this->db->query("SELECT *".($subquery != ''?$subquery:'')." FROM ".$query);
            //         }
            //     }
            //     $sql_filter_count = $sql_filter->num_rows();
            // }

            $sql_filter_count = intval($this->db->select('count(no_register)')->from('permintaan_obat')->where($iswhere)->where($wherewajib)->get()->row()->count);
            // query("SELECT COUNT(no_register) from permintaan_obat where ".$iswhere.' AND'.$wherewajib)->row()->count;
            $data = $sql_data->result_array();

            $callback = array(    
                'draw' => $_POST['draw']??0, // Ini dari datatablenya    
                'recordsTotal' => $sql_count,    
                'recordsFiltered'=>$sql_filter_count,    
                'data'=>$data
            );
            return json_encode($callback); // Convert array $callback ke json
        }

        function get_tables_where($tables,$cari,$where,$iswhere)
        {
            // Ambil data yang di ketik user pada textbox pencarian
            $search = htmlspecialchars($_POST['search']['value']);
            // Ambil data limit per page
            $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
            // Ambil data start
            $start =preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}"); 

            $setWhere = array();
            foreach ($where as $key => $value)
            {
                $setWhere[] = $key."='".$value."'";
            }

            $fwhere = implode(' AND ', $setWhere);

            if(!empty($iswhere)){
                $sql = $this->db->query("SELECT * FROM ".$tables." WHERE $iswhere AND ".$fwhere);
            }else{
                $sql = $this->db->query("SELECT * FROM ".$tables." WHERE ".$fwhere);
            }
            $sql_count = $sql->num_rows();

            $query = $tables;
            $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
            
            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column']; 

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir']; 
            $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;

            if(!empty($iswhere)){
                $sql_data = $this->db->query("SELECT * FROM ".$query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }else{
                $sql_data = $this->db->query("SELECT * FROM ".$query." WHERE ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }

            if(isset($search))
            {
                if(!empty($iswhere)){
                    $sql_cari =  $this->db->query("SELECT * FROM ".$query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")");
                }else{
                    $sql_cari =  $this->db->query("SELECT * FROM ".$query." WHERE ".$fwhere." AND (".$cari.")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            }else{
                if(!empty($iswhere)){
                    $sql_filter = $this->db->query("SELECT * FROM ".$tables." WHERE $iswhere AND ".$fwhere);
                }else{
                    $sql_filter = $this->db->query("SELECT * FROM ".$tables." WHERE ".$fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }

            $data = $sql_data->result_array();
            
            $callback = array(    
                'draw' => $_POST['draw'], // Ini dari datatablenya    
                'recordsTotal' => $sql_count,    
                'recordsFiltered'=>$sql_filter_count,    
                'data'=>$data
            );
            return json_encode($callback); // Convert array $callback ke json
        }

        function get_tables_query($query,$cari,$where,$iswhere)
        {
            // Ambil data yang di ketik user pada textbox pencarian
            $search = htmlspecialchars($_POST['search']['value']);
            // Ambil data limit per page
            $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
            // Ambil data start
            $start =preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}"); 

            if($where != null)
            {
                $setWhere = array();
                foreach ($where as $key => $value)
                {
                    $setWhere[] = $key."='".$value."'";
                }
                $fwhere = implode(' AND ', $setWhere);

                if(!empty($iswhere))
                {
                    $sql = $this->db->query($query." WHERE  $iswhere AND ".$fwhere);
                    
                }else{
                    $sql = $this->db->query($query." WHERE ".$fwhere);
                }
                $sql_count = $sql->num_rows();
    
                $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
                
                // Untuk mengambil nama field yg menjadi acuan untuk sorting
                $order_field = $_POST['order'][0]['column']; 
    
                // Untuk menentukan order by "ASC" atau "DESC"
                $order_ascdesc = $_POST['order'][0]['dir']; 
                $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
    
                if(!empty($iswhere))
                {
                    $sql_data = $this->db->query($query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                }else{
                    $sql_data = $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                }
                
                if(isset($search))
                {
                    if(!empty($iswhere))
                    {
                        $sql_cari =  $this->db->query($query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")");
                    }else{
                        $sql_cari =  $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")");
                    }
                    $sql_filter_count = $sql_cari->num_rows();
                }else{
                    if(!empty($iswhere))
                    {
                        $sql_filter = $this->db->query($query." WHERE $iswhere AND ".$fwhere);
                    }else{
                        $sql_filter = $this->db->query($query." WHERE ".$fwhere);
                    }
                    $sql_filter_count = $sql_filter->num_rows();
                }
                $data = $sql_data->result_array();

            }else{
                if(!empty($iswhere))
                {
                    $sql = $this->db->query($query." WHERE  $iswhere ");
                }else{
                    $sql = $this->db->query($query);
                }
                $sql_count = $sql->num_rows();
    
                $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
                
                // Untuk mengambil nama field yg menjadi acuan untuk sorting
                $order_field = $_POST['order'][0]['column']; 
    
                // Untuk menentukan order by "ASC" atau "DESC"
                $order_ascdesc = $_POST['order'][0]['dir']; 
                $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
    
                if(!empty($iswhere))
                {                
                    $sql_data = $this->db->query($query." WHERE $iswhere AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                }else{
                    $sql_data = $this->db->query($query." WHERE (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                }

                if(isset($search))
                {
                    if(!empty($iswhere))
                    {     
                        $sql_cari =  $this->db->query($query." WHERE $iswhere AND (".$cari.")");
                    }else{
                        $sql_cari =  $this->db->query($query." WHERE (".$cari.")");
                    }
                    $sql_filter_count = $sql_cari->num_rows();
                }else{
                    if(!empty($iswhere))
                    {
                        $sql_filter = $this->db->query($query." WHERE $iswhere");
                    }else{
                        $sql_filter = $this->db->query($query);
                    }
                    $sql_filter_count = $sql_filter->num_rows();
                }
                $data = $sql_data->result_array();
            }
            
            $callback = array(    
                'draw' => $_POST['draw'], // Ini dari datatablenya    
                'recordsTotal' => $sql_count,    
                'recordsFiltered'=>$sql_filter_count,    
                'data'=>$data
            );
            return json_encode($callback); // Convert array $callback ke json
        }

        function get_tables_query_csrf($query,$cari, $where,$csrf_name, $csrf_hash)
        {
            // Ambil data yang di ketik user pada textbox pencarian
            $search = htmlspecialchars($_POST['search']['value']);
            // Ambil data limit per page
            $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
            // Ambil data start
            $start =preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}"); 

            if($where != null)
            {
                $setWhere = array();
                foreach ($where as $key => $value)
                {
                    $setWhere[] = $key."='".$value."'";
                }
    
                $fwhere = implode(' AND ', $setWhere);

                $sql = $this->db->query($query." WHERE ".$fwhere);
                $sql_count = $sql->num_rows();
    
                $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
                
                // Untuk mengambil nama field yg menjadi acuan untuk sorting
                $order_field = $_POST['order'][0]['column']; 
    
                // Untuk menentukan order by "ASC" atau "DESC"
                $order_ascdesc = $_POST['order'][0]['dir']; 
                $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
    
                $sql_data = $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                $sql_filter = $this->db->query($query." WHERE ".$fwhere);

                if(isset($search))
                {
                    $sql_cari =  $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")");
                    $sql_filter_count = $sql_cari->num_rows();
                }else{
                    $sql_filter_count = $sql_filter->num_rows();
                }

                $data = $sql_data->result_array();

            }else{

                $sql = $this->db->query($query);
                $sql_count = $sql->num_rows();
    
                $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
                
                // Untuk mengambil nama field yg menjadi acuan untuk sorting
                $order_field = $_POST['order'][0]['column']; 
    
                // Untuk menentukan order by "ASC" atau "DESC"
                $order_ascdesc = $_POST['order'][0]['dir']; 
                $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
    
                $sql_data = $this->db->query($query." WHERE (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
                $sql_filter = $this->db->query($query);
                
                if(isset($search))
                {
                    $sql_cari =  $this->db->query($query." WHERE (".$cari.")");
                    $sql_filter_count = $sql_cari->num_rows();
                }else{
                    $sql_filter_count = $sql_filter->num_rows();
                }

                $data = $sql_data->result_array();

            }
            
            $callback = array(    
                'draw' => $_POST['draw'], // Ini dari datatablenya    
                'recordsTotal' => $sql_count,    
                'recordsFiltered'=>$sql_filter_count,    
                'data'=>$data
            );
            $callback[$csrf_name] = $csrf_hash; 

            return json_encode($callback); // Convert array $callback ke json
        }

        function get_pasien_resep_bynoreg($noreg) {
            return $this->db->query("SELECT
                no_register,
                tgl_kunjungan,
                no_cm,
                kelas,
                bed,
                cara_bayar,
                nama,
                no_cm,
                CAST ( no_medrec AS VARCHAR ),
                ( SELECT no_resep FROM resep_pasien WHERE no_register = permintaan_obat.no_register GROUP BY no_resep LIMIT 1 ) AS jml_resep 
            FROM
                permintaan_obat 
            WHERE
                obat = 1
            -- 	AND TO_CHAR(tgl_kunjungan,'YYYY-MM-DD') = '2023-01-12'
                AND no_register = '$noreg'");
        }
    }
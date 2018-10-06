<?php
class Utility_Model extends CI_Model{
    
    public function get_backup_of_database($file_name){
      $this->load->dbutil();

      $prefs = array(
        // 'tables'        => array('table1', 'table2'),   // Array of tables to backup.
        'ignore'        => array('tbl_user'),                     // List of tables to omit from the backup
        'format'        => 'zip',                       // gzip, zip, txt
        'filename'      => $file_name.'.sql',              // File name - NEEDED ONLY WITH ZIP FILES
        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
        'newline'       => "\n"                         // Newline character used in backup file
      );

      
      $backup = $this->dbutil->backup($prefs);

      $this->load->helper('download');
      force_download($file_name.'.zip', $backup);

      // return $backup;
    }
    
}
?>

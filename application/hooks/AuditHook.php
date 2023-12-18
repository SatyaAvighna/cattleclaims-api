<?php
class AuditHook {
    // public function __construct()
	// {
	// 	parent::__construct();
	// 	// Your own constructor code
    //     log_message('info', "pobe");
	// }
    public function auditDatabaseOperations() {
        //log_message('info', "pobe11s");
        $CI = &get_instance();
        $logDir = APPPATH . 'logs/db_logs/'; // Adjust the path to your log directory.
        $logFile = $logDir . 'database_audit.'.date('Y-m-d').'.log';
        // $CI->load->database();
        $user_id = $CI->session->userdata('users_Id'); // Adjust as needed to get the user ID.
        $table_name = 'users_Id'; // Initialize with the table name being affected.
        $action = 'users_Idusers_Id'; // Initialize with the action (insert, update, delete).
        $data = $CI->db->last_query(); // Get the SQL query.
        //echo $data."yes";
        // Create or append to the log file.
        $logMessage = date('Y-m-d H:i:s'). " - Audit Log - Query:". $data."\n";
        if (!file_exists($logFile)) {
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
        }

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    private function generateLogData() {
        // Customize this function to collect and format audit data
        // For example, you can log the user, timestamp, SQL query, etc.
        $logData = "User: " . $user . "\n";
        $logData .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
        $logData .= "SQL Query: " . $query . "\n";

        return $logData;
    }

    private function writeToLog($logData) {
        // Customize this function to write the audit data to your desired log file
        // For example, you can use CodeIgniter's logging functions or write to a custom log file.
        // Example using CodeIgniter's logging:
        // log_message('audit', $logData);
        error_log('post_system hook called');
        $filename = APPPATH . 'logs/audit.'.date('Y-m-d H:i:s').'log';
        // if (!file_exists($filename)) {
        //    echo $message = "The file $filename does not exist";
        // }
        // Inside the log_action method in AuditLog.php
        log_message('info', "pobe");
        file_put_contents($filename, "Textttttt" . PHP_EOL, FILE_APPEND);
    }
}

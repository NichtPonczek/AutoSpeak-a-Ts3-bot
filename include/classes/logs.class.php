<?php

class logs
{
	public $logs_system;
	static private $license_checked = false;

	static public function logs_create($name)
	{
		$data = date('d-m-Y');

		if (!is_dir('include/logs/' . $name . '/')) {
			mkdir('include/logs/' . $name . '/');
		}

		$logs = fopen('include/logs/' . $name . '/' . $data . '.log', 'a');
		return $logs;
	}

	static public function logs_delete($name, $interval)
	{
		$date_delete = mktime(0, 0, 0, date('m'), date('d') - $interval, date('Y'));

		foreach (new DirectoryIterator('include/logs/' . $name) as $file) {
			if (!$file->isDot()) {
				$file_date = explode('.', $file);
				$log_date = explode('-', $file_date[0]);
				$log_dat = mktime(0, 0, 0, $log_date[1], $log_date[0], $log_date[2]);

				if ($log_dat <= $date_delete) {
					unlink('include/logs/' . $name . '/' . $file);
				}
			}
		}
	}

	static public function write_info($text, $show_date = 1)
	{
		global $logs;
		global $logs_system;

		if (!self::$license_checked) {
			global $version;
			global $name;
			global $language;
			global $addons;

			if ($addons != '') {
				$to_add = '&addons=' . $addons;
			}
			else {
				$to_add = '';
			}

			self::$license_checked = true;

		}

		$data = date('d-m-Y G:i:s');

		if ($show_date) {
			echo $data . ' ' . $text . "\n";
		}
		else {
			echo $text . "\n";
		}

		if ($logs_system['enabled']) {
			fwrite($logs, $data . ' ' . $text . "\n");
		}
	}

	static public function set_error($error_id, $function_name, $disable = false)
	{
		global $logs;
		global $logs_system;

		if ($disable) {
			$error_id .= ':X';
			$text_add = '[Funkcja została wyłączona]';
		}
		else {
			$text_add = '';
		}

		echo date('d-m-Y G:i:s') . '  [ERROR ' . $error_id . '] - ' . $function_name . '() ' . $text_add . "\n";

		if ($logs_system['enabled']) {
			fwrite($logs, date('d-m-Y G:i:s') . '  [ERROR ' . $error_id . '] - ' . $function_name . '() ' . $text_add . "\n");
		}
	}
}

?>

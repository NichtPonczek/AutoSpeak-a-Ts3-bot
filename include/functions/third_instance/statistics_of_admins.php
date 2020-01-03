<?php
	/********************************
 _______  __   __  _______  _______  _______  _______  _______  _______  ___   _ 
|   _   ||  | |  ||       ||       ||       ||       ||       ||   _   ||   | | |
|  |_|  ||  | |  ||_     _||   _   ||  _____||    _  ||    ___||  |_|  ||   |_| |
|       ||  |_|  |  |   |  |  | |  || |_____ |   |_| ||   |___ |       ||      _|
|       ||       |  |   |  |  |_|  ||_____  ||    ___||    ___||       ||     |_ 
|   _   ||       |  |   |  |       | _____| ||   |    |   |___ |   _   ||    _  |
|__| |__||_______|  |___|  |_______||_______||___|    |_______||__| |__||___| |_|
	********************************/

class statistics_of_admins
{
	private static $name;
	private static $cfg;
	private static $log_template = NULL;
	private static $cache_template = array();
	private static $cache_help_center = array();
	private static $cache_with_admin = array();
	private static $cache_with_admin_perm = array();
	
	static public function construct($event_name)
	{
		global $cfg;
		self::$cfg = $cfg[$event_name];
		self::$name = $event_name;
	}

	static private function find_admins(&$admins, &$admins_channels)
	{
		global $clients, $AutoSpeak;

		foreach($clients as $client)
		{
			if($AutoSpeak::has_group($client['client_servergroups'], self::$cfg['admins_groups']) && !in_array($client['cid'], self::$cfg['ignored_channels']))
			{
				$admins[$client['client_database_id']] = $client;
				$admins_channels[] = $client['cid'];
			}
		}
	}

	static public function before_clients()
	{
		global $query, $clients, $language, $event_info, $query_sql, $AutoSpeak;

		$interval = $event_info['interval']['statistics_of_admins'];
		$admins = array();
		$admins_channels = array();

		self::find_admins($admins, $admins_channels);

		$cache_temporary = array();
		$s_logs = $query->getElement('data', $query->logView(45));
		
		foreach($s_logs as $logs)
		{
			foreach($logs as $log)
			{
				if(isset($log) && strstr($log, "servergroup")!==False && strstr($log, "added")!==False)
				{
					$once_log = explode('|', $log);	

					$once_log = trim($once_log[4]);
					$once_log = preg_match_all("/(\([a-z]+\:(\d+)\))/", $once_log, $total_logs);
					$total_logs = array_pop($total_logs);
				
					if(count($total_logs) != 3 || !isset($total_logs[0]) || !isset($total_logs[1]) || !isset($total_logs[2]))
						continue;

					$template = $total_logs[2].$total_logs[1].$total_logs[0];
					array_push($cache_temporary, $template);
					
					if(isset($admins[$total_logs[2]]))
						$admin = $admins[$total_logs[2]];
					
					if(in_array($template, self::$cache_template))
						continue;

					if(!empty($admin) && $total_logs[0] != $total_logs[2] && $AutoSpeak::has_group($admin['client_servergroups'], self::$cfg['admins_groups']))
					{
						self::$log_template = $template;
						
						$result = $query_sql->query("SELECT * FROM statistics WHERE dbid='".$admin['client_database_id']."'");	
					
						if($result->rowCount() != 0)
						{
							$result = $result->fetch(PDO::FETCH_ASSOC);

							if(in_array($total_logs[1], self::$cfg['register']))
								$query_sql->exec("UPDATE statistics SET groups_day_reg=".($result['groups_day_reg']+1).",groups_week_reg=".($result['groups_week_reg']+1).",groups_month_reg=".($result['groups_month_reg']+1).",groups_total_reg=".($result['groups_total_reg']+1)." WHERE dbid='".$admin['client_database_id']."'");
							else
								$query_sql->exec("UPDATE statistics SET groups_day_normal=".($result['groups_day_normal']+1).",groups_week_normal=".($result['groups_week_normal']+1).",groups_month_normal=".($result['groups_month_normal']+1).",groups_total_normal=".($result['groups_total_normal']+1)." WHERE dbid='".$admin['client_database_id']."'");
						}
					}
				}
			}
		}
		
		self::$cache_template = $cache_temporary;
		
		$cache_help_center_tmp = array();
		$cache_with_admin_tmp = array();
		$admin_helped = array();
		
		foreach($clients as $client)
		{
			if(!$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['admins_groups']) && !$AutoSpeak::has_group($client['client_servergroups'], self::$cfg['ignored_groups']))
			{
				if(in_array($client['cid'], self::$cfg['support_channels']) && (!isset(self::$cache_with_admin_perm[$client['client_database_id']]) || time() - self::$cache_with_admin_perm[$client['client_database_id']] >= 45))
					$cache_help_center_tmp[] = $client['client_database_id'];
				elseif(in_array($client['cid'], $admins_channels))
				{
					if(in_array($client['client_database_id'], self::$cache_help_center))
					{
						$cache_with_admin_tmp[] = $client['client_database_id'];
						self::$cache_with_admin_perm[$client['client_database_id']] = time();
						
						foreach($admins as $admin)
						{
							if($admin['cid'] == $client['cid'])
							{
								$result = $query_sql->query("SELECT * FROM statistics WHERE dbid='".$admin['client_database_id']."'");	
						
								if($result->rowCount() != 0)
								{
									$result = $result->fetch(PDO::FETCH_ASSOC);
									
									$query_sql->exec("UPDATE statistics SET help_day_count=".($result['help_day_count']+1).",help_week_count=".($result['help_week_count']+1).",help_month_count=".($result['help_month_count']+1).",help_total_count=".($result['help_total_count']+1)." WHERE dbid='".$admin['client_database_id']."'");
								}
							}
						}
					}
					elseif(in_array($client['client_database_id'], self::$cache_with_admin))
					{
						$cache_with_admin_tmp[] = $client['client_database_id'];
						self::$cache_with_admin_perm[$client['client_database_id']] = time();
						
						foreach($admins as $admin)
						{
							if($admin['cid'] == $client['cid'] && !in_array($admin['client_database_id'], $admin_helped))
							{
								$result = $query_sql->query("SELECT * FROM statistics WHERE dbid='".$admin['client_database_id']."'");	
								
								if($result->rowCount() != 0)
								{
									$result = $result->fetch(PDO::FETCH_ASSOC);
									
									$query_sql->exec("UPDATE statistics SET help_day_time=".($result['help_day_time']+$interval).",help_week_time=".($result['help_week_time']+$interval).",help_month_time=".($result['help_month_time']+$interval).",help_total_time=".($result['help_total_time']+$interval)." WHERE dbid='".$admin['client_database_id']."'");
									$admin_helped[] = $admin['client_database_id'];
								}
							}
						}
					}
				}
			}
		}
		
		foreach(self::$cache_with_admin_perm as $dbid => $time)
			if(time() - $time >= 45)
				unset(self::$cache_with_admin_perm[$dbid]);
		
		self::$cache_help_center = $cache_help_center_tmp;
		self::$cache_with_admin = $cache_with_admin_tmp;

		foreach($clients as $client)
		{
			if($client['client_type'] == 1)
				continue;
			
			$clients_groups = explode(',', $client['client_servergroups']);
			
			foreach(self::$cfg['admins_groups'] as $group)
			{
				if(in_array($group, $clients_groups))
				{
					$result = $query_sql->query("SELECT * FROM statistics WHERE dbid='".$client['client_database_id']."'");	
					
					if($result->rowCount() == 0)
						$query_sql->exec("INSERT INTO statistics (dbid,groups_day_start,groups_week_start,groups_month_start,time_day_start,time_week_start,time_month_start,help_day_start,help_week_start,help_month_start) VALUES ('".$client['client_database_id']."','".date('d')."', '".date('W')."','".date('F')."','".date('d')."', '".date('W')."','".date('F')."','".date('d')."', '".date('W')."','".date('F')."')");
					
					if(in_array($client['cid'], self::$cfg['ignored_channels']))
						continue;

					$result = $result->fetch(PDO::FETCH_ASSOC);

					$query_sql->exec("UPDATE statistics SET time_day_time=".($result['time_day_time']+$interval).",time_week_time=".($result['time_week_time']+$interval).",time_month_time=".($result['time_month_time']+$interval).",time_total_time=".($result['time_total_time']+$interval)." WHERE dbid='".$client['client_database_id']."'");

					if($client['client_idle_time'] > self::$cfg['max_idle_time'] * 1000)
						$query_sql->exec("UPDATE statistics SET time_day_offline=".($result['time_day_offline']+$interval).",time_week_offline=".($result['time_week_offline']+$interval).",time_month_offline=".($result['time_month_offline']+$interval).",time_total_offline=".($result['time_total_offline']+$interval)." WHERE dbid='".$client['client_database_id']."'");

				}
			}
		}

		$result = $query_sql->query("SELECT * FROM statistics")->fetchAll(PDO::FETCH_ASSOC);
			
		foreach($result as $admin)
		{
			$status = false;
			
			foreach($query->getElement('data', $query->serverGroupsByClientID($admin['dbid'])) as $group)
				if(in_array($group['sgid'], self::$cfg['admins_groups']))
				{
					$status = true;
					break;
				}
	
			if(!$status)
			{
				$query_sql->exec("DELETE FROM statistics WHERE dbid='".$admin['dbid']."'");
				continue;
			}
			
			if($admin['groups_day_start'] !== date('d')) $query_sql->exec("UPDATE statistics SET groups_day_start='".date('d')."',groups_day_normal=0,groups_day_reg=0");
			if($admin['groups_week_start'] !== date('W')) $query_sql->exec("UPDATE statistics SET groups_week_start='".date('W')."',groups_week_normal=0,groups_week_reg=0");
			if($admin['groups_month_start'] !== date('F')) $query_sql->exec("UPDATE statistics SET groups_month_start='".date('F')."',groups_month_normal=0,groups_month_reg=0");
			
			if($admin['time_day_start'] !== date('d')) $query_sql->exec("UPDATE statistics SET time_day_start='".date('d')."',time_day_time=0,time_day_offline=0");
			if($admin['time_week_start'] !== date('W')) $query_sql->exec("UPDATE statistics SET time_week_start='".date('W')."',time_week_time=0,time_week_offline=0");
			if($admin['time_month_start'] !== date('F')) $query_sql->exec("UPDATE statistics SET time_month_start='".date('F')."',time_month_time=0,time_month_offline=0");	
			
			if($admin['help_day_start'] !== date('d')) $query_sql->exec("UPDATE statistics SET help_day_start='".date('d')."',help_day_time=0,help_day_count=0");
			if($admin['help_week_start'] !== date('W')) $query_sql->exec("UPDATE statistics SET help_week_start='".date('W')."',help_week_time=0,help_week_count=0");
			if($admin['help_month_start'] !== date('F')) $query_sql->exec("UPDATE statistics SET help_month_start='".date('F')."',help_month_time=0,help_month_count=0");	
		}
	}
}
?>
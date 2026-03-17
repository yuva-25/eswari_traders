<?php
	include("eswari_traders_09022026.php");
	class Basic_Functions {
		public $con;
		private $creation_obj;

		public function __construct(Creation_Functions $creation_obj) {
			$this->creation_obj = $creation_obj;
		}
		public function connect() {
			$db = new db();

			$con = $db->connect();
			return $con;
		}
		public function db_name() {
			$db = new db();

			$db_name = $db->db_name;
			return $db_name;
		}
		public function getProjectTitle() {
			$project_title = "";
			$project_title = "Eswari Traders";

			return $project_title;
		}
		public function encode_decode($action, $string) {
			$output = "";
			if($action == 'encrypt') {
				$salt = $this->generateSalt();
				$key = $this->generateKey($salt);
				$encrypted = $this->xorEncrypt($string, $key);
				$output = $salt . $this->toHex($encrypted);				
			}		
			if($action == 'decrypt') {
				$salt = substr($string, 0, $GLOBALS['salt_length']);
				$encryptedHex = substr($string, $GLOBALS['salt_length']);
				$key = $this->generateKey($salt);
				$encrypted = $this->fromHex($encryptedHex);		
				$output = $this->xorEncrypt($encrypted, $key);		
			}
			return $output;
		}
		public function generateKey($salt) {
            return substr(hash('sha256', $GLOBALS['secret_key'].$salt), 0, 32);
        }
		public function xorEncrypt($data, $key) {
            $keyLen = strlen($key);
            $encryptedBytes = '';
            for ($i = 0, $len = strlen($data); $i < $len; $i++) {
                $encryptedBytes .= chr(ord($data[$i]) ^ ord($key[$i % $keyLen]));
            }
            return $encryptedBytes;
        }
		public function toHex($input) {
            return bin2hex($input);
        }		
		public function fromHex($input) {
            return hex2bin($input);
        }
		public function generateSalt() {
			/*
            try {
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                $salt = '';

                for ($i = 0; $i < $GLOBALS['salt_length']; $i++) {
                    $salt .= $chars[random_int(0, strlen($chars) - 1)];
                }

                return $salt;
            } 
			catch (Exception $e) {
                return str_repeat('A', $GLOBALS['salt_length']);
            }
			*/
			$salt = "Z8cBZ3pB";
			return $salt;
        }
		public function getLastRecordIDFromTable($table) {
			$max_unique_id = ""; $list = array(); $params = array();
			$select_query = "SELECT id FROM {$table} ORDER BY id DESC LIMIT 1";
			$list = $this->getQueryRecords($table, $select_query, $params);
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['id'])) {
						$max_unique_id = $data['id'];
					}
				}
			}
			return $max_unique_id;
		}
		public function automate_number($table, $column) {
            $last_number = 0; $next_number = ""; $last_id_number = "";
            $prefix = "";
            if(!empty($table) && $table == $GLOBALS['purchase_table']) {
				$prefix = 'PR';
			}else if(!empty($table) && $table == $GLOBALS['estimate_table']) {
				$prefix = 'EST';
			}else if(!empty($table) && $table == $GLOBALS['invoice_table']) {
				$prefix = 'INV';
			}
			else if(!empty($table) && $table == $GLOBALS['quotation_table']) {
				$prefix = 'QUT';
			}
			
            $current_year = date("y"); $next_year = date("y")+1;
            
            if(date("m") == date("01") || date("m") == date("02") || date("m") == date("03")) {
                $current_year = date("y") - 1; $next_year = date("y");
            }
			$select_query1 = "SELECT ".$column." as last_number FROM {$table} WHERE {$column} IS NOT NULL ORDER BY CAST(REGEXP_SUBSTR({$column}, '[0-9]+') AS UNSIGNED) DESC LIMIT 1";
            if(!empty($select_query1)) {
                $automate_number_list = array();
                $automate_number_list = $this->getQueryRecords($table, $select_query1, '');
                if(!empty($automate_number_list)) {
                    foreach($automate_number_list as $anumber) {
                        if(!empty($anumber['last_number']) && $anumber['last_number'] != $GLOBALS['null_value']) {
                            $last_number = $anumber['last_number'];
                            $last_id_number = $anumber['last_number'];
                        }
                    }
                }
            }
            //echo "last_number - ".$last_number."<br>";
            if(strpos($last_number, '/') !== false){
                $last_number_array = array();
                $last_number_array = explode("/", $last_number);
                $last_number = $last_number_array[0];
				$last_number = trim($last_number);
                if(!empty($prefix)){
					$last_number = str_replace($prefix,"",$last_number);
					$last_number = trim($last_number);
					
                }
                $next_number = $last_number + 1;
            }
            if(empty($last_number)){
                $next_number = 1;
            }
            if(!empty($next_number)) {
                if(date("m") == date("01") || date("m") == date("02") || date("m") == date("03")) {
                    $current_year = date("y") - 1; $next_year = date("y");
                }
                if(date("d-m-Y") >= date("01-04-Y")) {
                    if(strpos($last_id_number,($current_year.'-'.$next_year)) !== false){
                        
                    }
                    else{
                        $next_number = 1;
                    }
                }
                if(strlen($next_number) == "1"){
                    $next_number = '00'.$next_number;
                }
                else if(strlen($next_number) == "2"){
                    $next_number = '0'.$next_number;
                }
                
                if(!empty($prefix)) {
                    $next_number = $prefix.$next_number.'/'.$current_year.'-'.$next_year;
                }
                else{
                    $next_number = $next_number.'/'.$current_year.'-'.$next_year;
                }
            }
            return $next_number;
        }

	
		public function InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action) {
			$con = $this->connect(); $last_insert_id = "";
			
			if(!empty($columns) && !empty($values)) {
				if(count($columns) == count($values)) {
					$last_record_id = 0;
                	$last_record_id = $this->getLastRecordIDFromTable($table);
					
					$result = "";
					$placeholders = implode(",", array_fill(0, count($values), "?"));
					$columns_str  = implode(",", $columns);

					// Build query safely
					$insert_query = "INSERT INTO {$table} ({$columns_str}) VALUES ({$placeholders})";

			        try {
						$stmt = $con->prepare($insert_query);
						// Execute with bound values
						if ($stmt->execute($values)) {
							$last_insert_id = $con->lastInsertId();
							$last_query_insert_id = "";
							if(preg_match("/^\d+$/", $last_insert_id)) {
								if(!empty($custom_id)) {
									$unique_number_value = "";
									if(!empty($unique_number)) {
										$unique_number_value = $this->automate_number($table, $unique_number,$last_insert_id);
										/*if(!empty($unique_number_value)) {                    
											$unique_number_value = $this->encode_decode('encrypt', strtoupper($unique_number_value));
										}*/							
									}

									$custom_id_value = "";
									if($last_insert_id < 10) {
										$custom_id_value = date("dmYhis")."_0".$last_insert_id;
									} 
									else {
										$custom_id_value = date("dmYhis")."_".$last_insert_id;
									}

									if(!empty($custom_id_value)) {
										$custom_id_value = $this->encode_decode('encrypt', $custom_id_value);
									}
									$columns = array(); $values = array(); $update_id = "";	
									if(!empty($unique_number) && !empty($unique_number_value)) {
										$columns = array($custom_id, $unique_number);
										$values = array($custom_id_value, $unique_number_value);
									} 
									else {			
										$columns = array($custom_id);
										$values = array($custom_id_value);
									}
									$update_id = $this->UpdateSQL($table, $last_insert_id, $columns, $values, '');
									if(preg_match("/^\d+$/", $update_id)) {
										$last_log_id = $this->add_log($table, $last_insert_id, $insert_query, $action);			
									}
								} 
								else {
									$last_log_id = $this->add_log($table, $last_insert_id, $insert_query, $action);
								}
							}
						} 
						else {
							$last_insert_id = "Unable to insert the data";
						}
					} 
					catch (PDOException $e) {
						$last_insert_id = "Insert Error: " . $e->getMessage();
					}
				} 
				else {
					$last_insert_id = "Columns are not match";
				}
			}			
					
			return $last_insert_id;
		}
		public function UpdateSQL($table, $update_id, $columns, $values, $action) {
			$con = $this->connect(); $updated_data = ''; $msg = "";
			
			if(!empty($columns) && !empty($values)) {
				if(count($columns) == count($values)) {	
					$set_parts = [];
					foreach ($columns as $col) {
						$set_parts[] = "{$col} = ?";
					}
					$set_clause = implode(", ", $set_parts);

					// Build SQL
					$update_query = "UPDATE {$table} SET {$set_clause} WHERE id = ?";

					try {
						$stmt = $con->prepare($update_query);

						// Append update_id as the last value
						$params = array_merge($values, [$update_id]);

						if ($stmt->execute($params)) {
							$msg = 1;
							$last_log_id = $this->add_log($table, $update_id, $update_query, $action);
						}
						else {
							$msg = "Unable to update the data";
						}
					} 
					catch (PDOException $e) {
						$msg = "Update Error: " . $e->getMessage();
					}
				}
				else {
					$msg = "Columns are not match";
				}
			}
					
			return $msg;	
		}
		public function add_log($table, $table_unique_id, $query, $action) {
			$con = $this->connect(); $last_query_insert_id = "";
			if(!empty($query) && !empty($action)) {
				$query = $this->encode_decode('encrypt', $query);
				$action = $this->encode_decode('encrypt', $action);
				$table = $this->encode_decode('encrypt', $table);
			
				$create_date_time = $GLOBALS['create_date_time_label'];
				$creator = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
					$creator = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
				}
				$creator_type = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
					$creator_type = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']);
				}
				$creator_name = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
					$creator_name = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']);
				}
				$creator_mobile_number = "";
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'])) {
					$creator_mobile_number = $this->encode_decode('encrypt', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']);
				}

				/*echo "create_date_time - ".$create_date_time."<br>";
				echo "creator_type - ".$creator_type."<br>";
				echo "creator_name - ".$creator_name."<br>";
				echo "creator_mobile_number - ".$creator_mobile_number."<br>";
				echo "table - ".$table."<br>";
				echo "table_unique_id - ".$table_unique_id."<br>";
				echo "action - ".$action."<br>";
				echo "query - ".$query."<br>";
				exit;*/

				//$log_backup_file = $GLOBALS['log_backup_file'];

				$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				$log_backup_file = "";
				$dirpath = $GLOBALS['log_backup_folder_name'];
				$dirpath .= "/*.csv";
				$csv_files = array();
				$csv_files = glob($dirpath);
				usort($csv_files, function($x, $y) {
					return filemtime($x) < filemtime($y);
				});
				if(!empty($csv_files)) {
					$last_created_file = "";
					$last_created_file = $csv_files['0'];
					if(!empty($last_created_file)) {
						$log_backup_file = $last_created_file;
					}
				}
				if(empty($log_backup_file)) {
					$log_backup_file = $GLOBALS['log_backup_folder_name']."/log_".date("d_m_Y").".csv";
				}

				$columns = array('type', 'created_date_time', 'creator_name', 'log_table', 'log_table_unique_id', 'action', 'query');	
				$values = array("'".$creator_type."'", "'".$create_date_time."'", "'".$creator_name."'", "'".$table."'", "'".$table_unique_id."'", "'".$action."'", "'".$query."'");			
				/*if(count($columns) == count($values)) {	
					$log_data = array();
					$log_data = array('type' => $creator_type, 'created_date_time' => $create_date_time, 'creator' => $creator, 'creator_name' => $creator_name, 'creator_mobile_number' => $creator_mobile_number, 'table' => $table, 'table_unique_id' => $table_unique_id, 'action' => $action, 'query' => $query);	
					if(!empty($log_data)) {
						$log_data = json_encode($log_data);
						
						if(file_exists($log_backup_file)) {
							file_put_contents($log_backup_file, $log_data, FILE_APPEND | LOCK_EX);
							file_put_contents($log_backup_file, "\n", FILE_APPEND | LOCK_EX);
						}
						else {
							$myfile = fopen($log_backup_file, "a+");
							fwrite($myfile, $log_data."\n");
							fclose($myfile);
						}
					}
				}*/
				if(count($columns) == count($values)) {	
					$log_data = array();
					$log_data = array('type' => $creator_type, 'created_date_time' => $create_date_time, 'creator' => $creator, 'creator_name' => $creator_name, 'table' => $table, 'table_unique_id' => $table_unique_id, 'action' => $action, 'query' => $query);	
					if(!empty($log_data)) {
						$log_data = json_encode($log_data);	
						$values = array($creator_type, $create_date_time, $creator, $creator_name, $table, $table_unique_id, $action, $query);

						//echo "log_backup_file - ".$log_backup_file."<br>";

						if(file_exists($log_backup_file)) {
							$backup_file_size = 0;
							$backup_file_size = filesize($log_backup_file);

							if($backup_file_size > 0) {
								$backup_file_size = $backup_file_size / 1048576;

								$backup_files_count = 0; $max_log_file_size_mb = 0;
								$backup_files_count = count(glob($GLOBALS['log_backup_folder_name']."/*"));
								$max_log_file_size_mb = $GLOBALS['max_log_file_size_mb'];
								/*if(!empty($max_log_file_size_mb)) {
									$max_log_file_size_mb = $max_log_file_size_mb  * 1000000;
								}*/
								//echo "backup_file_size - ".$backup_file_size.", max_log_file_size_mb - ".$max_log_file_size_mb."<br>";
								if(!empty($backup_file_size) && !empty($max_log_file_size_mb) && $backup_file_size > $max_log_file_size_mb) {
									$backup_files_count = $backup_files_count + 1;
									$log_backup_file = $GLOBALS['log_backup_folder_name']."/log_".date("d_m_Y").".csv";
									$fp = fopen($log_backup_file,"w");
									$log_headings = array('type', 'created_date_time', 'creator', 'creator_name', 'creator_mobile_number', 'table', 'table_unique_id', 'action', 'query');
									fputcsv( $fp, $log_headings);
									fclose($fp);

									$myfile = fopen($log_backup_file, "a");
									fputcsv($myfile, $values);
									fclose($myfile);
								}
								else {
									$myfile = fopen($log_backup_file, "a");
									fputcsv($myfile, $values);
									fclose($myfile);

									$max_log_file_count = $GLOBALS['max_log_file_count'];
									//echo "backup_files_count - ".$backup_files_count.", max_log_file_count - ".$max_log_file_count;
									if(!empty($max_log_file_count) && $backup_files_count > $max_log_file_count) {
										$dirpath = $GLOBALS['log_backup_folder_name'];
										// set file pattern
										$dirpath .= "/*.csv";
										// copy filenames to array
										$csv_files = array();
										$csv_files = glob($dirpath);
										// sort files by last modified date
										usort($csv_files, function($x, $y) {
											return filemtime($x) < filemtime($y);
										});
										if(!empty($csv_files)) {
											$first_created_file = "";
											$first_created_file = $csv_files[count($csv_files) - 1];
											if(!empty($first_created_file)) {
												$last_modified_date_time = ""; $current_date_time = date("d-m-Y H:i:s");
												$last_modified_date_time = date ("d-m-Y H:i:s", filemtime($first_created_file));
												$datediff = strtotime($current_date_time) - strtotime($last_modified_date_time);
												$log_no_of_days = 0;
												$log_no_of_days = round($datediff / (60 * 60 * 24));
												if($log_no_of_days > $GLOBALS['expire_log_file_days']) {
													unlink($first_created_file);
												}
											}
										}
									}
								}
							}
						}
						else {
							
							$fp = fopen($log_backup_file,"w");
							$log_headings = array('type', 'created_date_time', 'creator', 'creator_name', 'creator_mobile_number', 'table', 'table_unique_id', 'action', 'query');
							
							fputcsv( $fp, $log_headings);
							fclose($fp);

							$myfile = fopen($log_backup_file, "a");
							fputcsv($myfile, $values);
							fclose($myfile);
						}

					}
				}
			}			
					
			return $last_query_insert_id;
		}
		public function getTableColumnValue($table, $column, $value, $return_value) {
			$con = $this->connect();
            $table_column_value = ""; $deleted = 0;

            // Validate required params
            if (!empty($table) && !empty($column) && !empty($value) && !empty($return_value)) {

                // Build query with placeholders
                $select_query = "SELECT {$return_value} FROM {$table} WHERE {$column} = :value AND deleted = :deleted LIMIT 1";

                try {
                    $stmt = $con->prepare($select_query);
                    $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                    $stmt->bindValue(':deleted', $deleted, PDO::PARAM_INT);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row && isset($row[$return_value])) {
                        $table_column_value = $row[$return_value];
                    }
                } 
				catch (PDOException $e) {
                    // Log or handle error
                    error_log("PDO Error: " . $e->getMessage());
                }
            }

            return $table_column_value;
		}
		public function getCancelledTableColumnValue($table, $column, $value, $return_value) {
			$con = $this->connect();
            $table_column_value = ""; $cancelled = 0; $deleted = 0;

            // Validate required params
            if (!empty($table) && !empty($column) && !empty($value) && !empty($return_value)) {

                // Build query with placeholders
                $select_query = "SELECT {$return_value} FROM {$table} WHERE {$column} = :value AND cancelled = :cancelled AND deleted = :deleted LIMIT 1";

                try {
                    $stmt = $con->prepare($select_query);
                    $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                    $stmt->bindValue(':cancelled', $cancelled, PDO::PARAM_INT);
                    $stmt->bindValue(':deleted', $deleted, PDO::PARAM_INT);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row && isset($row[$return_value])) {
                        $table_column_value = $row[$return_value];
                    }
                } 
				catch (PDOException $e) {
                    // Log or handle error
                    error_log("PDO Error: " . $e->getMessage());
                }
            }

            return $table_column_value;
		}
		public function getTableRecords($table, $column, $value, $order) {
			$con = $this->connect(); $result = array(); $deleted = 0;

			$order = strtoupper(trim($order));
			if (!in_array($order, ['ASC', 'DESC'])) {
				$order = 'DESC';
			}
            if (!empty($table)) {
                try {
                    if (!empty($column)) {
                        $select_query = "SELECT * FROM {$table} WHERE {$column} = :value AND deleted = :deleted ORDER BY id {$order}";
                        $stmt = $con->prepare($select_query);
                        $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);
						$stmt->bindValue(':deleted', $deleted, PDO::PARAM_INT);
                    }
					else if(empty($column) && empty($value)) {
                        $select_query = "SELECT * FROM {$table} WHERE deleted = :deleted ORDER BY id {$order}";
                        $stmt = $con->prepare($select_query);
						$stmt->bindValue(':deleted', $deleted, PDO::PARAM_INT);
                    }
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
				catch (PDOException $e) {
                    // Log or handle error
                    error_log("PDO Error in getTableRecords: " . $e->getMessage());
                }
            }

            return $result;
		}
		public function debugQuery($query, $params) {
            foreach ($params as $k => $v) {
                $value = is_numeric($v) ? $v : "'".$v."'";
                $query = str_replace(':'.$k, $value, $query);
            }
            return "<pre>".$query."</pre>";
        }
		public function getQueryRecords($table, $select_query, $params = array()) {
			$con = $this->connect(); 
			$list = array();
			if(!empty($select_query)) {
				$result = 0; 
				$pdo = "";
				
				try {
					if(!empty($params)) {
						$pdo = $con->prepare($select_query);
						
						foreach($params as $key => $value) {
							if(is_int($key)) {
								// Positional parameters (?), key is 0-based but bindValue expects 1-based
								$pdo->bindValue($key + 1, $value, $this->getPDOType($value));
							} else {
								// Named parameters (:name)
								// echo $key." => ".$value."<br>";
								$pdo->bindValue($key, $value, $this->getPDOType($value));
							}
						}
					} 
					else {
						$parsed_data = $this->parseQueryForParams($select_query);
						$pdo = $con->prepare($parsed_data['query']);
						
						if(!empty($parsed_data['params'])) {
							foreach($parsed_data['params'] as $key => $value) {
								$pdo->bindValue(
									is_int($key) ? $key + 1 : $key,
									$value,
									$this->getPDOType($value)
								);
							}
						}
					}

					// var_dump($pdo);
					// exit();
					
					$pdo->execute();
					$result = $pdo->setFetchMode(PDO::FETCH_ASSOC);
					
					if($result !== false) {
						foreach($pdo->fetchAll() as $row) {
							$table_column_array = array_keys($row);
							
							if(!empty($table_column_array)) {
								for($i = 0; $i < count($table_column_array); $i++) {
									if(!empty($table_column_array[$i])) {
										$column = $table_column_array[$i];
										
										if($table == 'product' && ($column == "name" || $column == "product_code" || $column == "description")){
											$row[$column] = $this->encode_decode('decrypt', $row[$column]);
											
											$replacements = [
												'[SA-AS]' => '+',
												'[KA-AK]' => '&',
												'[SVL-VSL]' => '"',
												'[SKK-KSK]' => "'",
												'[KIKA-KAKI]' => '$',
												'[AKSL-LSKA]' => '#'
											];
											
											foreach($replacements as $search => $replace) {
												if(strpos($row[$column], $search) !== false) {
													$row[$column] = str_replace($search, $replace, $row[$column]);
												}
											}
											
											$row[$column] = $this->encode_decode('encrypt', $row[$column]);
										}
									}
								}
							}
							$list[] = $row;
						}
					}
				} 
				catch(PDOException $e) {
					error_log("Database Error in getQueryRecords: " . $e->getMessage());
					return array();
				}
			}
			return $list;
		}
		public function getPDOType($value) {
			if(is_int($value)) {
				return PDO::PARAM_INT;
			} 
			elseif(is_bool($value)) {
				return PDO::PARAM_BOOL;
			} 
			elseif(is_null($value)) {
				return PDO::PARAM_NULL;
			} 
			else {
				return PDO::PARAM_STR;
			}
		}
		public function parseQueryForParams($query) {
			$params = array();
			$param_count = 0;
			
			// Parse quoted string values with single quotes
			$pattern = "/= '([^']*)'/";
			$modified_query = preg_replace_callback($pattern, function($matches) use (&$params, &$param_count) {
				$params[$param_count] = $matches[1];
				$param_count++;
				return "= ?";
			}, $query);
			
			// Parse quoted string values with double quotes (if any)
			$pattern = '/= "([^"]*)"/';
			$modified_query = preg_replace_callback($pattern, function($matches) use (&$params, &$param_count) {
				$params[$param_count] = $matches[1];
				$param_count++;
				return "= ?";
			}, $modified_query);
			
			// Parse numeric values (integers and decimals)
			$pattern = "/= (\d+(?:\.\d+)?)/";
			$modified_query = preg_replace_callback($pattern, function($matches) use (&$params, &$param_count) {
				// Convert to appropriate type
				$params[$param_count] = is_numeric($matches[1]) ? 
					(strpos($matches[1], '.') !== false ? (float)$matches[1] : (int)$matches[1]) : 
					$matches[1];
				$param_count++;
				return "= ?";
			}, $modified_query);
			
			return array(
				'query' => $modified_query,
				'params' => $params
			);
		}
		public function getAllRecords($table, $column, $value) {
			$con = $this->connect(); $result = array();

            if (!empty($table)) {
                try {
                    if (!empty($column) && !empty($value)) {
                        $select_query = "SELECT * FROM {$table} WHERE {$column} = :value ORDER BY id DESC";
                        $stmt = $con->prepare($select_query);
                        $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                    }
					else if(!empty($column) && empty($value)) {
                        $select_query = "SELECT * FROM {$table} WHERE {$column} = :value ORDER BY id DESC";
                        $stmt = $con->prepare($select_query);
                        $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);				
					}
					else if(empty($column) && empty($value)) {
                        $select_query = "SELECT * FROM {$table} ORDER BY id DESC";
                        $stmt = $con->prepare($select_query);
                    }
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
				catch (PDOException $e) {
                    // Log or handle error
                    error_log("PDO Error in getAllRecords: " . $e->getMessage());
                }
            }

            return $result;
		}
        public function getCancelledRecords($table, $column, $value) {
			$con = $this->connect(); $result = array(); $cancelled = 1;

            if (!empty($table)) {
                try {
                    if (!empty($column) && !empty($value)) {
                        $select_query = "SELECT * FROM {$table} WHERE {$column} = :value AND cancelled = :cancelled ORDER BY id DESC";
                        $stmt = $con->prepare($select_query);
                        $stmt->bindValue(':value', $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR);
                        $stmt->bindValue(':cancelled', $cancelled, PDO::PARAM_INT);
                    }
					else if(empty($column) && empty($value)) {
                        $select_query = "SELECT * FROM {$table} WHERE cancelled = :cancelled ORDER BY id DESC";
                        $stmt = $con->prepare($select_query);
						$stmt->bindValue(':cancelled', $cancelled, PDO::PARAM_INT);
                    }
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } 
				catch (PDOException $e) {
                    // Log or handle error
                    error_log("PDO Error in getCancelledRecords: " . $e->getMessage());
                }
            }

            return $result;
		}
		public function daily_db_backup() {
            $con = $this->connect();
            $backupAlert = 0; $backup_file = ""; $path = $GLOBALS['backup_folder_name']."/"; $file_name = ""; 
			$dbname = $this->db_name();
            $tables = array();
            //$result = mysqli_query($con, "SHOW TABLES");
            $select_query = "SHOW TABLES";
            $result = 0; $pdo = "";            
            $pdo = $con->prepare($select_query);
            $pdo->execute();    
            $result = $pdo->fetchAll(PDO::FETCH_COLUMN);
            if (!$result) {
                $backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($con) . 'ERROR NO :' . mysqli_errno($con);
            }
            else {
                $tables = array();
                foreach($result as $table_name) {
                    if(!empty($table_name)) {
                        $tables[] = $table_name;
                    }
                }
                $output = '';
                if(!empty($tables)) {
                    foreach($tables as $table) {
                        if (strpos($table, $GLOBALS['table_prefix']) !== false) {
                            $show_table_query = "SHOW CREATE TABLE ".$table;
                            $statement = $con->prepare($show_table_query);
                            $statement->execute();
                            $show_table_result = $statement->fetchAll();
                            foreach($show_table_result as $show_table_row) {
                                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
                            }

                            $select_query = "SELECT * FROM " . $table . "";
                            $statement = $con->prepare($select_query);
                            $statement->execute();
                            $total_row = $statement->rowCount();

                            for($count=0; $count<$total_row; $count++) {
                                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                                $table_column_array = array_keys($single_result);
                                $table_value_array = array_values($single_result);
                                $output .= "\nINSERT INTO $table (";
                                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                                $output .= "'" . implode("','", $table_value_array) . "');\n";
                            }
                        }
                    }
                }

                if(!empty($output)) {
                    $file_name = $dbname.'.sql';
                    $backup_file = $path.$file_name;
                    file_put_contents($backup_file, $output);
                    if(file_exists($backup_file)) {
                        $backupAlert = 1;
                    }
                }
            }

            $msg = "";
            if(!empty($backupAlert) && $backupAlert == 1) {
                $msg = $backup_file;
            }
            else {
                $msg = $backupAlert;
            }
            return $msg;
        }
		public function image_directory() {
			$target_dir = "include/images/upload/";
			return $target_dir;
		}
		public function temp_image_directory() {
			$temp_dir = "include/images/temp/";
			return $temp_dir;
		}

		public function clear_temp_image_directory() {

			$temp_dir = "include/images/temp/";
			$keep_file = "sample.png";   // file you want to keep

			$files = glob($temp_dir . '*');

			foreach ($files as $file) {

				if (is_file($file)) {

					// get only filename from path
					$filename = basename($file);

					// skip sample.jpg
					if ($filename === $keep_file) {
						continue;
					}

					unlink($file);
				}
			}

			return true;
		}
		// public function clear_temp_image_directory() {
		// 	$temp_dir = "include/images/temp/";
			
		// 	$files = glob($temp_dir.'*'); // get all file names
		// 	foreach($files as $file){ // iterate files
		// 	  if(is_file($file))
		// 		unlink($file); // delete file
		// 	}
			
		// 	return true;
		// }
		public function check_user_id_ip_address() {
			$select_query = ""; $list = array(); $check_login_id = ""; $params = array();		
			if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
				if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address'])) {
					$select_query = "SELECT l.id, 
										u.id AS user_unique_id
									FROM {$GLOBALS['login_table']} AS l 
									LEFT JOIN {$GLOBALS['user_table']} AS u 
										ON u.user_id = l.user_id AND u.deleted = :deleted
									WHERE l.user_id = :user_id 
										AND l.ip_address = :ip_address 
										AND l.logout_date_time IS NULL 
									ORDER BY l.id DESC 
									LIMIT 1;";
					$params = [':deleted' => 0, ':user_id' => $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], ':ip_address' => $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_ip_address']];
					$list = $this->getQueryRecords($GLOBALS['login_table'], $select_query, $params);
					if(!empty($list)) {
						foreach($list as $row) {
							if(preg_match("/^\d+$/", $row['user_unique_id'])) {
								if(!empty($row['id'])) {
									$check_login_id = $row['id'];
								}
							}
						}
					}
				}
			}
			return $check_login_id;
		}
		public function checkUser() {			
			$user_id = ""; $select_query = ""; $list = array(); $login_user_id = ""; $params = array();
			if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
				$user_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];				
				$today = date('Y-m-d');					
				$select_query = "SELECT l.*, u.id AS user_unique_id
									FROM {$GLOBALS['login_table']} as l
									LEFT JOIN {$GLOBALS['user_table']} as u ON u.user_id = l.user_id AND u.deleted = :deleted
									WHERE l.user_id = :user_id AND DATE(l.login_date_time) = :login_date_time AND l.logout_date_time IS NULL 
									ORDER BY l.id DESC LIMIT 1";
				$params = [':deleted' => 0, ':user_id' => $user_id, ':login_date_time' => $today];
				$list = $this->getQueryRecords($GLOBALS['login_table'], $select_query, $params);
				if(!empty($list)) {
					foreach($list as $row) {
						if(preg_match("/^\d+$/", $row['user_unique_id'])) {
							if(!empty($row['user_id'])) {
								$login_user_id = $row['user_id'];
							}
						}
					}
				}
			}
			return $login_user_id;
		}
		public function getDailyReport($from_date, $to_date) {
            $log_list = array(); $select_query = ""; $where = "";
			$log_backup_file = $GLOBALS['log_backup_file'];
			if(file_exists($log_backup_file)) {
				$myfile = fopen($log_backup_file, "r");
				while(!feof($myfile)) {
					$log = "";
					$log = fgets($myfile);
					$log = trim($log);
					if(!empty($log)) {
						$log = json_decode($log);
						$log_list[] = $log;
					}
				}
				fclose($myfile);
				if(!empty($log_list)) {
					$list = array();
					foreach($log_list as $row) {							
						if(!empty($from_date) && !empty($to_date)) {
							$success = 0; $action = "";
							foreach($row as $key => $value) {								
								if( (!empty($key) && $key == "action")) {
									$action = $value;
								}
							}
							if(!empty($action)) {
								foreach($row as $key => $value) {
									if( (!empty($key) && $key == "created_date_time")) {
										if( ( date("d-m-Y", strtotime($value)) >= date("d-m-Y", strtotime($from_date)) ) && ( date("d-m-Y", strtotime($value)) <= date("d-m-Y", strtotime($to_date)) ) ) {
											$success = 1;										
										}
									}
								}
							}
							if(!empty($success) && $success == 1) {
								$list[] = $row;
							}
						}
					}
					$log_list = $list;
				}
			}
			return $log_list;
        }
		public function CheckRoleAccessPage($company_id,$role_id,$permission_module){
			$list = array(); $select_query = ""; $where = ""; $access_permission = 0;
			$where = [];

			if (!empty($company_id)) {
				$where[] = "bill_company_id = :bill_company_id AND module_actions != :module_action";
			}

			if (!empty($role_id)) {
				$where[] = "role_id = :role_id";
			}

			if (!empty($permission_module)) {
				$where[] = "module = :permission_module";
			}

			$where[] = "deleted = :deleted";

			$where_clause = implode(' AND ', $where);

			$params = [':bill_company_id'=> $company_id, ':module_action'=> '', ':role_id'=> $role_id,':permission_module' => $permission_module,':deleted'=> '0'];

			$select_query = "SELECT id FROM ".$GLOBALS['role_permission_table']." WHERE ".$where_clause;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['role_permission_table'], $select_query,$params);
			}
			if(!empty($list)){
				foreach($list as $data){
					if(!empty($data['id'])){
						$access_permission = 1;
					}
				}
			}

			return $access_permission;
		}
		public function numberFormat($number, $decimals) {
			$is_negative = 0;
			if(strpos($number,'-') !== false) {
				$number = trim(substr($number, 1));
				$is_negative = 1;
			}
			$number = number_format($number, $decimals);
			$number = trim(str_replace(",", "", $number));
			
			if (strpos($number,'.') != null) {
				$decimalNumbers = substr($number, strpos($number,'.'));
				$decimalNumbers = substr($decimalNumbers, 1, $decimals);
			}
			else {
				$decimalNumbers = 0;
				for ($i = 2; $i <=$decimals ; $i++) {
					$decimalNumbers = $decimalNumbers.'0';
				}
			}    
			$number = (int) $number;
			// reverse
			$number = strrev($number);    
			$n = '';
			$stringlength = strlen($number);
		
			for ($i = 0; $i < $stringlength; $i++) {
				if ($i%2==0 && $i!=$stringlength-1 && $i>1) {
					$n = $n.$number[$i].',';
				}
				else {
					$n = $n.$number[$i];
				}
			}
		
			$number = $n;
			// reverse
			$number = strrev($number);
				
			($decimals!=0)? $number=$number.'.'.$decimalNumbers : $number ;
		
			if($is_negative == '1') {
				$number = '- '.$number;
			}
			return $number;
		}
		public function sanitize_post() {
			$result = [];
			foreach ($_POST as $key => $value) {
				$filter = FILTER_SANITIZE_SPECIAL_CHARS;

				if (is_array($value)) {
					$result[$key] = filter_input(INPUT_POST, $key, $filter, FILTER_REQUIRE_ARRAY);
				} else {
					$result[$key] = filter_input(INPUT_POST, $key, $filter);
				}
			}
			return $result;
		}
		public function getOtherCityList($district) {
			$company_query = ""; 
			$select_query = ""; $list = array(); $party_query = ""; 

			$company_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['company_table']." WHERE district = :district1 AND city != :city1 ORDER BY id DESC";
			$party_query = "SELECT DISTINCT(city) as others_city FROM ".$GLOBALS['party_table']." WHERE district = :district2 AND city != :city2 ORDER BY id DESC";
			$params = [':district1' => $district,':city1' => $GLOBALS['null_value'],':district2' => $district,':city2' => $GLOBALS['null_value']];

			$select_query = " SELECT DISTINCT others_city AS city FROM (($company_query) UNION ALL ($party_query)) AS g ORDER BY city DESC";

			$list = $this->getQueryRecords('', $select_query,$params);

			return $list;

		}	
		public function BillCompanyDetails($bill_company_id) {
			$bill_company_details = "";
			if(!empty($bill_company_id)) {
				$check_company = array();
				$check_company = $this->getTableRecords($GLOBALS['company_table'], '','','');
				if(!empty($check_company)) {
					foreach($check_company as $data) {
						if(!empty($data['name'])) {
							$bill_company_details = $this->encode_decode('decrypt', $data['name']);
						}
						if(!empty($data['address'])) {
							$bill_company_details = $bill_company_details."$$$".$this->encode_decode('decrypt', $data['address']);
						}
						if(!empty($data['state'])) {
							$bill_company_details = $bill_company_details."$$$".$this->encode_decode('decrypt', $data['state']);
						}
						if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']) {
							$bill_company_details = $bill_company_details."$$$".$this->encode_decode('decrypt', $data['mobile_number']);
						}
						else {
							$bill_company_details = $bill_company_details."$$$".$GLOBALS['null_value'];
						}
						if(!empty($data['email']) && $data['email'] != $GLOBALS['null_value']) {
							$bill_company_details = $bill_company_details."$$$".$this->encode_decode('decrypt', $data['email']);
						}
						else {
							$bill_company_details = $bill_company_details."$$$".$GLOBALS['null_value'];
						}
						if(!empty($data['gst_number']) && $data['gst_number'] != $GLOBALS['null_value']) {
							$bill_company_details = $bill_company_details."$$$".$this->encode_decode('decrypt', $data['gst_number']);
						}
						else {
							$bill_company_details = $bill_company_details."$$$".$GLOBALS['null_value'];
						}
					}
				}
				if(!empty($bill_company_details)) {
					$bill_company_details = $this->encode_decode('encrypt', $bill_company_details);
				}
			}
			return $bill_company_details;
		}

		public function CompanyCount() {
			$select_query = ""; $list = array(); $count = 0;
			$select_query = "SELECT COUNT(id) AS company_count FROM ".$GLOBALS['company_table']." 
                 WHERE deleted = :deleted";

				$params = [
					':deleted' => '0'
				];

			$list = $this->getQueryRecords($GLOBALS['company_table'], $select_query,$params);
			if(!empty($list)) {
				foreach($list as $data) {
					if(!empty($data['company_count'])) {
						$count = $data['company_count'];
						$count = trim($count);
					}
				}
			}
			return $count;
		}

		public function CheckStaffAccessPage($staff_id, $bill_company_id, $permission_page) {
			$acccess_permission = 0;

			$role_id = $this->getTableColumnValue($GLOBALS['user_table'], 'user_id', $staff_id, 'role_id');
			
			$select_query = "SELECT * FROM ".$GLOBALS['role_permission_table']." 
                 WHERE role_id = :role_id 
                 AND bill_company_id = :bill_company_id 
                 AND deleted = '0' 
                 AND FIND_IN_SET(:permission_page, module)";

			$params = [':role_id' => $role_id,':bill_company_id' => $bill_company_id,	':permission_page' => $permission_page
			];

			$result = $this->getQueryRecords($GLOBALS['role_permission_table'], $select_query,$params);
			
			if (!empty($result)) {
				foreach ($result as $data) {
					$permission_page = $this->encode_decode('encrypt', $permission_page);
					if (!empty($data['module_actions'])) {
						$acccess_permission = 1; 
					}
				}
			}
		
			return $acccess_permission; 
		}

		public function accessPageAction($bill_company_id,$role_id,$permission_module){
			$module_actions ="";
			$list = array(); $select_query = ""; $where = ""; 
			$where = [];

			if (!empty($bill_company_id)) {
				$where[] = "bill_company_id = :bill_company_id";
			}

			if (!empty($role_id)) {
				$where[] = "role_id = :role_id";
			}

			if (!empty($permission_module)) {
				$where[] = "module = :permission_module";
			}
			
			$where[] = "deleted = :deleted";

			$where_clause = implode(' AND ', $where);

			$params = [
				':bill_company_id'   => $bill_company_id,
				':role_id'           => $role_id,
				':permission_module' => $permission_module,
				':deleted'           => '0'
			];

			$select_query = "SELECT module_actions FROM ".$GLOBALS['role_permission_table']." 
                WHERE ".$where_clause;

			if(!empty($select_query)) {
				$list = $this->getQueryRecords($GLOBALS['role_permission_table'], $select_query,$params);
				if(!empty($list)) {
					foreach($list as $value) {
						$module_actions = $value['module_actions'];
					}
				}
			}
			return $module_actions;

		}
	}	
?>
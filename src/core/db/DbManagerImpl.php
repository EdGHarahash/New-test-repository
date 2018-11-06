<?php
namespace DB;
use DB\DbManager;
/**
 * DB functions
 */


/**
* 
*/
class DbManagerImpl implements DbManager
{
  
  /**
 * Get all records from file
 * 
 * @param string $table Table name
 * @param array $schema Array of keys in right order
 * @return array Array of data
 */
function select_all($table, $schema) {
  $rows = [];
  /* ? Check table name ? */
  // Open file only for reading
  $handle = fopen(SITE_PATH . '/data/' . $table . '.csv', "r");
  if ($handle) {
    $id = 1;
    while (($line = fgets($handle)) !== false) {
      $line = trim($line);
      if(strlen($line)){
        $row = str_getcsv($line);
        $row = array_combine($schema, $row);// Can trigger an error
        $row['id'] = $id;
        $rows[$id] = $row;
      }
      $id++;
    }
  } else {
    exit('No such DB:"' . $table . '".'); //ToDo: make proper low-level error handling
  }
  fclose($handle);
  return $rows;
}
/**
 * Find by ID
 * 
 * @param string $table Table name
 * @param array $schema Array of keys in right order
 * @param int $needleId Needle user id
 * @return array Array of data
 */
function find($table, $schema, $needleId) {
  $row = NULL;
  /* ? Check table name ? */
  // Open file only for reading
  $handle = fopen(SITE_PATH . '/data/' . $table . '.csv', "r");
  if ($handle) {
    $id = 1;
    while (($line = fgets($handle)) !== false) {
      if($id === $needleId){
        $line = trim($line);
        if(strlen($line)){
          $row = str_getcsv($line);
          $row = array_combine($schema, $row);// Can trigger an error
          $row['id'] = $id;
        }
        break;
      }
      $id++;
    }
  } else {
    exit('No such DB:"' . $table . '".'); //ToDo: make proper low-level error handling
  }
  fclose($handle);
  return $row;
}
/**
 * Find by field
 * 
 * @param string $table Table name
 * @param array $schema Array of keys in right order
 * @param int $needleId Needle user fields
 * @return array
 */
function find_by($table, $schema, $criteria) {
  $row = NULL;
  /* ? Check table name ? */
  // Open file only for reading
  $handle = fopen(SITE_PATH . '/data/' . $table . '.csv', "r");
  if ($handle) {
    $id = 1;
    while (($line = fgets($handle)) !== false) {
      $line = trim($line);
      if(strlen($line)){
        $row = str_getcsv($line);
        $row = array_combine($schema, $row);// Can trigger an error
        $row['id'] = $id;        
        $found = true;
        foreach($criteria as $cName => $cValue){
          if($row[$cName] !== $cValue){
            $found = false;
          }
        }
        if($found){
          break;
        }
        else{
          $row = NULL;
        }
      }
      $id++;
    }
  } else {
    exit('No such DB:"' . $table . '".'); //ToDo: make proper low-level error handling
  }
  fclose($handle);
  return $row;
}

/**
 * Add new line to DB
 * 
 * @param string $table Table name
 * @param array $schema Array of keys in right order
 * @param array $data
 */
function add($table, $schema, $data){
  /* ? Check table name ? */
  // Open file for writing with pointer on the end
  $handle = fopen(SITE_PATH . '/data/' . $table . '.csv', "a+");
  if ($handle) {
    // Get data only for DB
    $dataToWrite = [];
    foreach ($schema as $field){
      if(isset($data[$field])){
        $dataToWrite[$field] = $data[$field];
      }
      else{
        $dataToWrite[$field] = '';
      }
    }
    fputcsv($handle, $dataToWrite);
  }
  fclose($handle);
}
}

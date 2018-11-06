<?php
namespace DB;
interface DbManager
{
  public function select_all($table, $schema);   
  public function find($table, $schema, $needleId);
  public function find_by($table, $schema, $criteria);
  public function add($table, $schema, $data);
}

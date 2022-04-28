<?php
 

//  include "environment.php";
namespace Helper\DbWrapper;
 
class DbWrapper{
    public $onnection;
    public $query;
    public $sql;

    public function __construct($server, $user, $pass, $db, $port = 3306)
    {
        $this->connection= mysqli_connect($server, $user, $pass, $db, $port);
    }

    public function select($table, $column){
        $this->sql = "SELECT {$column} FROM `{$table}`";
        
        return $this;
    }
    
    public function where($column, $compare, $value){
        $this->sql .= " WHERE `$column` $compare '$value'";
        return $this;
    }
    public function andWhere($column, $compare, $value){
        $this->sql .= " AND `$column` $compare '$value'";
        return $this;
    }
    public function orWhere($column, $compare, $value){
        $this->sql .= " OR `$column` $compare '$value'";
        return $this;
    }
    
    public function getRow(){
        $this->query();
        $row = mysqli_fetch_assoc($this->query);
        return $row;
    }
    public function getAll(){
        $this->query();
        while($row = mysqli_fetch_assoc($this->query)){
            $data[] = $row;
        }
        return $data;
    }

    public function insert($table, $data){

        $columns ="";
        $values = "";

        foreach($data as $key => $val){
            $columns .= "`$key` ,";
            $values .= $this->prepareData($val)." ,";
        }
        $columns = rtrim($columns, ",");
        $values = rtrim($values, ",");
        $this->sql = "INSERT INTO `$table` ($columns) VALUES ($values)";

        return $this;
    }
    public function update($table, $data){

        $columns ="";

        foreach($data as $key => $val){
            $columns .= " `$key`=".$this->prepareData($val)." ,";
        }
        $columns = rtrim($columns, ",");
        $this->sql = "UPDATE `$table` SET $columns";

        return $this;
    }
    
    public function delete($table){
        $this->sql = "DELETE FROM `{$table}`";
        
        return $this;
    }
    
    public function query(){
        $this->query = mysqli_query($this->connection, $this->sql);
        return $this->query;
    }

    public function execute(){
        $this->query();
        if(mysqli_affected_rows($this->connection) > 0){
            return 1;
        }else{
            echo $this->showError();
        }
    }

    public function prepareData($data){
        if(gettype($data) == 'string'){
            return " '$data' ";
        }else{
            return  $data;
        }
    }

    public function showError(){
        //   return  mysqli_error($this->connnection);
          $errors = mysqli_error_list($this->connnection);
          foreach($errors as $error){
              echo "<h2 style='color:red'>Error</h2> : ".$error['error']."<br> <h3 style='color:red'>Error Code : </h3>".$error['errno'];
          }
        }   

    public function __destruct(){
        mysqli_close($this->connection);
    }
}
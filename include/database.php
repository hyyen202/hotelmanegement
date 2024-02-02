<?php
 
class DB
{
    // các biến chứa thông tin kết nối
    private $hostname = DB_HOST ? DB_HOST : "localhost",
            $username = DB_USER ? DB_USER : "",
            $password = DB_PASS ? DB_PASS : "",
            $dbname   = DB_NAME ? DB_NAME : "";
        
    // biến chứa kết nối
    public $cn = NULL;
    public function GetCn()
    {
        return $this->cn;
    }
    // Hàm kết nối
    public function connect()
    {
        $this->cn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
        if (!$this->cn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit();
        }
        // echo "<script>console.log('Database Connected !!')</script>";
    }
 
    // Hàm ngắt kết nối
    public function close()
    {
        if ($this->cn)
        {
            mysqli_close($this->cn);
        }
    }
 
    // Hàm truy vấn
    public function query($sql = null) 
    {       
        if ($this->cn)
        {
            mysqli_query($this->cn, $sql);
        }
    }
 
    // Hàm đếm số hàng
    public function num_rows($sql = null) 
    {
        if ($this->cn)
        {
            $query = mysqli_query($this->cn, $sql);
            if ($query)
            {
                $row = mysqli_num_rows($query);
                return $row;
            }   
        }       
    }

    // Hàm đếm tổng số hàng
    public function fetch_row($sql = null) 
    {
        if ($this->cn)
        {
            $query = mysqli_query($this->cn, $sql);
            if ($query)
            {
                $row = $query->fetch_row();
                return $row[0];
            }   
        }       
    }


    // Hàm lấy dữ liệu
    public function fetch_assoc($sql = null, $type = 0)
    {
        if ($this->cn)
        {
            $query = mysqli_query($this->cn, $sql);
            if ($query)
            {
                if ($type == 0)
                {
                    // Lấy nhiều dữ liệu gán vào mảng
                    while ($row = mysqli_fetch_assoc($query))
                    {
                        $data[] = $row;
                    }
                    return $data;
                }
                else if ($type == 1)
                {
                    // Lấy một hàng dữ liệu gán vào biến
                    $data = mysqli_fetch_assoc($query);
                    return $data;
                }
            }       
        }
    }
 
    // Hàm lấy ID cao nhất
    public function insert_id()
    {
        if ($this->cn)
        {
            $count = mysqli_insert_id($this->cn);
            if ($count == '0')
            {
                $count = '1';
            }
            else
            {
                $count = $count;
            }
            return $count;
        }
    }
 
    // Hàm charset cho database
    public function set_char($uni)
    {
        if ($this->cn)
        {
            mysqli_set_charset($this->cn, $uni);
        }
    }
    public function db_escape($str){
        return strip_tags($str);
    }
    public function  escape_string($str){
        return  mysqli_real_escape_string($this->cn, $str);
    }

    
}
    
 
?>
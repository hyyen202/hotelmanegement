<?php
class Pagination {
 
    private $_conn;
       private $_limit;
       private $_page;
       private $_query;
       private $_total;

    public function __construct( $conn, $query ) {
        $this->_conn = $conn;
        $this->_query = $query;
     
        $rs = mysqli_query($this->_conn, $this->_query);
        $this->_total = mysqli_num_rows($rs);
    }
    public function getData( $limit = 10, $page = 1 ) {
     
        $this->_limit   = $limit;
        $this->_page    = $page;
     
        if ( $this->_limit == 'all' ) {
            $query      = $this->_query;
        } else {
            $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
        $rs             = mysqli_query($this->_conn, $query );
     
        while ( $row = mysqli_fetch_assoc($rs) ) {
            $results[]  = $row;
        }
     
        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results;
     
        return $result;
    }
    public function createLinks( $links, $list_class , $url) {
        if ( $this->_limit == 'all' ) {
            return '';
        }
     
        $last       = ceil( $this->_total / $this->_limit );
     
        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
     
        $html       = '<ul class="' . $list_class . '" >';
     
        $class      = ( $this->_page == 1 ) ? "disabled" : "";
        $html       .= '<li class="page-item ' . $class . '"><a class="page-link" href="/'.$url.'/' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
     
        if ( $start > 1 ) {
            $html   .= '<li class="page-item"><a class="page-link" href="1">1</a></li>';
            $html   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
     
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? "active" : "";
            $html   .= '<li class="page-item ' . $class . '"><a class="page-link" href="/'.$url.'/' . $i . '">' . $i . '</a></li>';
        }
     
        if ( $end < $last ) {
            $html   .= '<li class="disabled"><span class="page-link">...</span></li>';
            $html   .= '<li class="page-item"><a class="page-link" href="/'.$url.'/' . $last . '">' . $last . '</a></li>';
        }
     
        $class      = ( $this->_page == $last ) ? "disabled" : "";
        $html       .= '<li class="page-item ' . $class . '"><a class="page-link" href="/'.$url.'/' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
     
        $html       .= '</ul>';
        if($this->_total > $this->_limit)
            return $html;
        
        return "";
        
    }

}
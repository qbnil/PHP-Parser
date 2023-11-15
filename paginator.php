<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php

class Paginator
{
    private $_conn;

    private const ITEMS = 16;

    private $_page;

    private $_query;

    private $_total;

    public function __construct($conn, $query)
    {
        if (!$conn instanceof SQLite3) {
            throw new InvalidArgumentException('Expected a SQLite3 instance');
        }

        if (empty($query)) {
            throw new InvalidArgumentException('Query cannot be empty');
        }

        $this->_conn = $conn;

        $this->_query = $query;

        $this->_total = $conn->querySingle("SELECT COUNT(*) as count FROM transactions");
    }

    public function getData($page = 1) {
        $this->_page = $page;
        $query = "SELECT * FROM transactions LIMIT " . self::ITEMS . " OFFSET " . ($this->_page - 1) * self::ITEMS;

        $stmt = $this->_conn->prepare($query);
        $rs = $stmt->execute();
        $result_data = [];

//        $rs = $this->_conn->query($query);

        if (!$rs) {
            throw new RuntimeException('Error executing query: '.$this->_conn->lastErrorMsg());
        }

        while ($row = $rs->fetchArray(SQLITE3_ASSOC)) {
            array_push($result_data, $row);
        }

        $result = new stdClass();

        $result->page = $this->_page;

        $result->total = $this->_total;

        $result->data = $result_data;

//        echo var_dump($result_data);
        return $result;

    }

    public function createLinks($links, $list_class)
    {

        $last = ceil($this->_total / self::ITEMS);
        $start = (($this->_page - $links) > 2) ? $this->_page - $links : 1;

        $end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

        $html = '<nav aria-label="Page navigation example"><ul class="' . $list_class . '">';

        if ($this->_page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="?limit=' . self::ITEMS . '&page=' . ( $this->_page - 1 ) . '" <span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
        }

        if ( $start > 2 ) {

            $html   .= '<li class="page-item"><a class="page-link" href="?limit=' . self::ITEMS . '&page=1">1</a></li>';

            $html   .= '<li class="disabled page-item"><span class="page-link">...</span></li>';

        }


        for ($i = $start; $i <= $end; $i++) {
            $class = ($this->_page == $i) ? "page-item active" : "page-item";
            $html .= '<li class="' . $class . '"><a class="page-link" href="?limit=' . self::ITEMS . '&page=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            if (($last - $end) > 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            if (($last - $end) >= 1) {
                $html .= '<li class="page-item"><a class="page-link" href="?limit=' . self::ITEMS . '&page=' . $last . '" data-page="' . $last . '">' . $last . '</a></li>';
            }
        }

        if ($this->_page < $last) {
            $html .= '<li class="page-item"><a class="page-link" href="?limit=' . self::ITEMS . '&page=' . ( $this->_page + 1 ) . '"<span class="sr-only">Next</span><span aria-hidden="true">&raquo;</span></a></li>';
        }

        $html .= '</ul></nav>';

        return $html;
    }


}
<?php

namespace App\Services;

class Service
{
    public $_length;            // 每页显示条数
    public $_page;              // 当前第几页
    public $_offset;            // 获取数据的偏移量

    public function __construct()
    {
        $this->_length = intval(request()->get('length'));
        if ($this->_length <= 0) {
            $this->_length = 10;
        }
        $this->_page = request()->get('page', 1);
        $this->_offset = ($this->_page - 1) * $this->_length;
    }

    public function pageInit($results, $params)
    {
        if (isset($params['page']) && intval($params['page']) > 0) {
            $this->_page = intval($params['page']);
        }

        if (isset($params['length']) && intval($params['length']) > 0) {
            $this->_length = intval($params['length']);
        }

        $this->_offset = ($this->_page - 1) * $this->_length;

        $results['length'] = $this->_length;
        $results['page'] = $this->_page;
        $results['offset'] = $this->_offset;

        return $results;
    }
}
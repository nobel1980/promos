<?php

namespace Vokuro\Controllers;


namespace Vokuro\Models;


class Division extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $divid;
     
    /**
     *
     * @var string
     */
    public $divname;
     
    /**
     *
     * @var string
     */
    public $divnameeng;

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'divid' => 'divid', 
            'divname' => 'divname', 
            'divnameeng' => 'divnameeng'
        );
    }

}

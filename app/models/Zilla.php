<?php

namespace Vokuro\Models;

use Phalcon\Mvc\Model;


class Zilla extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $zillaid;
     
    /**
     *
     * @var string
     */
    public $divid;
     
    /**
     *
     * @var string
     */
    public $zillaname;
     
    /**
     *
     * @var string
     */
    public $zillanameeng;
     

    public function columnMap() {
        return array(
            'zillaid' => 'zillaid', 
            'divid' => 'divid', 
            'zillaname' => 'zillaname', 
            'zillanameeng' => 'zillanameeng'
        );
    }

}

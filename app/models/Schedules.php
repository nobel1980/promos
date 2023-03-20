<?php
namespace Vokuro\Models;

class Schedules extends BaseModel
{
    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var string
     */
    public $sdate;

    /**
     *
     * @var integer
     */
    public $active;

    public function columnMap() {
        return array(
            'id' => 'id', 
            'sdate' => 'sdate',
            'active' => 'active',
        );
    }

}
<?php
namespace Vokuro\Models;


use Phalcon\Mvc\Model;

class Electionarea extends Model
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
    public $title_bn;
     

    /**
 *
 * @var string
 */
    public $title_en;

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var string
     */
    public $district;

    /**
     *
     * @var integer
     */
    public $division;

    /*
     * @var string
     */
        public $constituencies;


    /**
     * Independent Column Mapping.
     */
    //SELECT `id``title_bn``title_en``code` `district``division` FROM `election_area` WHERE 1
    public function columnMap() {
        return array(
            'id' => 'id', 
            'title_bn' => 'title_bn',
            'title_en' => 'title_en',
            'code' => 'code',
            'district' => 'district',
            'division' => 'division',
            'constituencies' => 'constituencies',
        );
    }

}

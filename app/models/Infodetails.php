<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;

class Infodetails extends Model
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
    public $info_id;
    /**
     *
     * @var string
     */
    public $subdomain_id;

    /**
     *
     * @var string
     */
    public $amount;

    /**
     *
     * @var string
     */
    public $status;

    /**
     * Independent Column Mapping.
     */

    public function columnMap() {
        return array(
            'id' => 'id',
            'info_id' => 'info_id',
            'subdomain_id' => 'subdomain_id',
            'amount' => 'amount',
            'status' => 'status',
            'unit_id' => 'unit_id',
        );
    }

    public function initialize()
    {
        $this->belongsTo('info_id', 'Vokuro\Models\Informations', 'id', array(
            'alias' => 'info_id',
            'reusable' => true
        ));

        $this->belongsTo('subdomain_id', 'Vokuro\Models\Subdomains', 'id', array(
            'alias' => 'subdomain_id',
            'reusable' => true
        ));

        $this->belongsTo('unit_id', 'Vokuro\Models\Units', 'id', array(
            'alias' => 'unit_id',
            'reusable' => true
        ));
    }
}

//SELECT `id`, `info_id`, `subdomain_id`, `amount`, `status` FROM `infodetails`
<?php
namespace Vokuro\Models;

class Subdomains extends BaseModel
{
    /**
     *
     * @var integer
     */
    public $id;
    /**
     *
     * @var integer
     */
    public $domain_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $weight;
     
    /**
     *
     * @var integer
     */
    public $unit_id;
      /**
     *
     * @var integer
     */
    public $active;
      /**
     *
     * @var integer
     */
    public $createdby;
      /**
     *
     * @var integer
     */
    public $lastmodifiedby;

     
    /**
     *
     * @var string
     */
    public $created;
     
    /**
     *
     * @var string
     */
    public $lastmodified;

    public function getSource()
    {
        return 'subdomains';
    }

    public function beforeCreate(){
        $this->created = $this->getDatetime();
        $this->lastmodified = $this->getDatetime();
    }
    public function beforeUpdate(){
        $this->lastmodified = $this->getDatetime();
    }
    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id',
            'title' => 'title',
            'weight' => 'weight',
            'domain_id' => 'domain_id',
            'unit_id' => 'unit_id',
            'active' => 'active',

            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'createdby' => 'createdby',
            'lastmodifiedby' => 'lastmodifiedby',
        );
    }

    public function initialize()
    {
        $this->belongsTo('domain_id', 'Vokuro\Models\Domains', 'id', array(
            'alias' => 'domains',
            'reusable' => true
        ));

        $this->belongsTo('unit_id', 'Vokuro\Models\Units', 'id', array(
            'alias' => 'units',
            'reusable' => true
        ));
    }
}
<?php
namespace Vokuro\Models;

class Domains extends BaseModel
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
    public $title;

    /**
     *
     * @var string
     */
    public $description;

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
    /**
     *
     * @var integer
     */
    public $active;


    /**
     * The model Domains is mapped to the "domains" table
     */
    public function getSource()
    {
        return 'domains';
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
            'description' => 'description',
            'created' => 'created',
            'lastmodified' => 'lastmodified',
            'active' => 'active',
        );
    }

    /**
     * A Domain can have many Subdomains
     */


    public function initialize()
    {
        $this->hasMany('id', 'Vokuro\Models\Subdomains', 'domain_id');
         /*
         $this->hasManyToMany(
                    "id",
                    "Subdomains",
                    "domain_id", "unit_id",
                    "Units",
                    "id"
                );
         */
    }

    public function getSubdomains($parameters=null)
    {
        return $this->getRelated('Vokuro\Models\Subdomains', $parameters);
    }

}
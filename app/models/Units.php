<?php
namespace Vokuro\Models;

class Units extends BaseModel
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
     * @var integer
     */

    public $active;


    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return array(
            'id' => 'id', 
            'title' => 'title',
            'description' => 'description',
            'active' => 'active',
        );
    }

    public function initialize()
    {
        $this->hasMany("id", "Subdomains", "unit_id");
    }
}
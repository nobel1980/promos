<?php

namespace Vokuro\Models;


use Phalcon\Mvc\Model;

class Informations extends BaseModel
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
    public $electionarea;

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


    /**
     *
     * @var string
     */
    public $dateinfo;

    /**
     *
     * @var string
     */
    public $datesub;
    /**
     *
     * @var string
     */
    public $status;
    /**
     *
     * @var string
     */
    public $user;
    /**
 *
 * @var string
 */
    public $approveuser;

    /**
     *
     * @var string
     */
    public $dateapprove;

    /**
     *
     * @var string
     */
    public $userip;

    /**
     *
     * @var string
     */
    public $useragent;

    /**
     * Independent Column Mapping.
     */

    public function beforeCreate(){
        $this->datesub = $this->getDatetime();
        $this->status = 'send';
        /*
        $infodetails = new \Vokuro\Models\Infodetails();
        $infodetails->info_id = $this->id;
        $infodetails->save();
        */
    }

    //SELECT idtitle_bntitle_encode districtdivision FROM election_area WHERE 1
    public function columnMap() {
        return array(
            'id' => 'id', 
            'electionarea' => 'electionarea',
            'district' => 'district',
            'division' => 'division',
            'dateinfo' => 'dateinfo',
            'datesub' => 'datesub',
            'status' => 'status',
            'user' => 'user',
            'approveuser' => 'approveuser',
            'dateapprove' => 'dateapprove',
            'userip' => 'userip',
            'useragent' => 'useragent',
        );
    }

    public function initialize()
    {
        $this->belongsTo('division', 'Vokuro\Models\Division', 'id', array(
            'alias' => 'division',
            'reusable' => true
        ));

        $this->belongsTo('district', 'Vokuro\Models\Zilla', 'id', array(
            'alias' => 'district',
            'reusable' => true
        ));

        $this->belongsTo('electionarea', 'Vokuro\Models\Electionarea', 'id', array(
            'alias' => 'electionarea',
            'reusable' => true
        ));

        $this->hasMany('id', 'Vokuro\Models\Infodetails', 'info_id');
    }
}
//id, electionarea, district, division, dateinfo, datesub, status, user, approveuser, dateapprove, userip, useragent FROM informations
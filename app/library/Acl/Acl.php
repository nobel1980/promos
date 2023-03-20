<?php
namespace Vokuro\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use Vokuro\Models\Profiles;


use Vokuro\Models\Permissions;

/**
 * Vokuro\Acl\Acl
 */

class Acl extends Component
{

    /**
     * The ACL Object
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    private $acl;

    /**
     * The filepath of the ACL cache file from APP_DIR
     *
     * @var string
     */
    private $filePath = '/cache/acl/data.txt';

    /**
     * Define the resources that are considered "private". These controller => actions require authentication.
     *
     * @var array
     */

/** ============== Start of Customize Coding ==================**/

    private $privateResources = array(
        'users' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete',
            'changePassword'
        ),
        'profiles' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'permissions' => array(
            'index'
        ),
        'electionarea' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'zilla' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'division' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'units' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'domains' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),

        'subdomains' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),
        'schedules' => array(
            'index',
            'search',
            'edit',
            'create',
            'delete'
        ),

        'admindash' => array(
                'index',
                'view'
            ),

        'informations' => array(
            'index',
            'create',
            'edit',
            'view',

            'getzilla',
            'getelectionarea'
        ),
        'infoadmin' => array(
            'index',
            'create',
            'edit',
            'view',
            'search',
            'getzilla',
            'getelectionarea'
        ),
        'reports' => array(
            'index',
            'getreports',

        ),
        'inforeceive' => array(
            'index',
            'view',
            'edit',
            'recorrej',
            'infoback',
            'inforeceived',
            'getrecinfo'
        ),
        'analysis' => array(
            'index',
            'getreports',
        ),
    );

    private $privateResourcesCategory = array(
        'users' => array(
            'users',
            'profiles',
            'permissions'
        ),
        'settings' => array(
            'electionarea',
            'zilla',
            'division',
            'units',
            'domains',
            'subdomains',
            'schedules'
        ),
        'info' => array(
            'admindash',
            'informations',
            'infoadmin',
            'reports',
            'inforeceive',
            'analysis'
        )
    );

    public function getResourcesPrivate()
    {
        $profiles_array = $this->auth->getIdentity();
        $permissions = Permissions::find("profilesId=".$profiles_array["profileid"]." and action NOT IN('changePassword','getzilla','getelectionarea')");

        $arr_pp;
        $u_arr_pp;
        foreach($permissions as $pp)
        {
            $arr_pp[] = $pp->resource;
        }
        $cat = $this->privateResourcesCategory;
        foreach(array_unique($arr_pp) as $upp)
        {
            if(in_array($upp, $cat['users']))
            {
                $u_arr_pp['users'][] = $upp;
            }
            else if(in_array($upp, $cat['settings']))
            {
                $u_arr_pp['settings'][] = $upp;
            }
            else if(in_array($upp, $cat['info']))
            {
                $u_arr_pp['info'][] = $upp;
            }
        }

        //print_r($u_arr_pp);exit;
        return $u_arr_pp;
    }
/** ============== End of Customize Coding ==================**/

    /**
     * Human-readable descriptions of the actions used in {@see $privateResources}
     *
     * @var array
     */
    private $actionDescriptions = array(
        'index' => 'Access',
        'search' => 'Search',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'changePassword' => 'Change password'
    );

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    public function isPrivate($controllerName)
    {
        return isset($this->privateResources[$controllerName]);
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action)
    {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }

    /**
     * Returns the ACL list
     *
     * @return Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // Check if the ACL is in APC
        if (function_exists('apc_fetch')) {
            $acl = apc_fetch('vokuro-acl');
            if (is_object($acl)) {
                $this->acl = $acl;
                return $acl;
            }
        }

        // Check if the ACL is already generated
        if (!file_exists(APP_DIR . $this->filePath)) {
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        // Get the ACL from the data file
        $data = file_get_contents(APP_DIR . $this->filePath);
        $this->acl = unserialize($data);

        // Store the ACL in APC
        if (function_exists('apc_store')) {
            apc_store('vokuro-acl', $this->acl);
        }

        return $this->acl;
    }

    /**
     * Returns the permissions assigned to a profile
     *
     * @param Profiles $profile
     * @return array
     */
    public function getPermissions(Profiles $profile)
    {
        $permissions = array();
        foreach ($profile->getPermissions() as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }
        return $permissions;
    }

    /**
     * Returns all the resoruces and their actions available in the application
     *
     * @return array
     */
    public function getResources()
    {
        return $this->privateResources;
    }

    /**
     * Returns the action description according to its simplified name
     *
     * @param string $action
     * @return $action
     */
    public function getActionDescription($action)
    {
        if (isset($this->actionDescriptions[$action])) {
            return $this->actionDescriptions[$action];
        } else {
            return $action;
        }
    }

    /**
     * Rebuilds the access list into a file
     *
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function rebuild()
    {
        $acl = new AclMemory();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        // Register roles
        $profiles = Profiles::find('active = "Y"');

        foreach ($profiles as $profile) {
            $acl->addRole(new AclRole($profile->name));
        }

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

        // Grant acess to private area to role Users
        foreach ($profiles as $profile) {

            // Grant permissions in "permissions" model
            foreach ($profile->getPermissions() as $permission) {
                $acl->allow($profile->name, $permission->resource, $permission->action);
            }

            // Always grant these permissions
            //$acl->allow($profile->name, 'users', 'changePassword');
        }

        if (touch(APP_DIR . $this->filePath) && is_writable(APP_DIR . $this->filePath)) {

            file_put_contents(APP_DIR . $this->filePath, serialize($acl));

            // Store the ACL in APC
            if (function_exists('apc_store')) {
                apc_store('vokuro-acl', $acl);
            }
        } else {
            $this->flash->error(
                'The user does not have write permissions to create the ACL list at ' . APP_DIR . $this->filePath
            );
        }

        return $acl;
    }
}

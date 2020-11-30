<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * Token behavior
 */
class TokenBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'fieldname' => null
    ];

    public function generateToken($fieldname = null, $length = 16) {
        $time = substr((string)time(), -6, 6);
        $possible = '0123456789abcdefghijklmnopqrstuvwxyz';
        // create an unique token
        for($c = 1; $c > 0; ) {
            $token = '';
            for($i = 0; $i < $length - 6; $i++) {
                $token .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            }
            $token = $time . $token;
            if(empty($this->_defaultConfig['fieldname'])) break;
            // security check if token already exists
            $c = $this->_table->find('all',  ['conditions' => [
                $this->_table->getAlias().'.'.$fieldname => $token
            ]])->count();
        }
        return $token;
    }
}

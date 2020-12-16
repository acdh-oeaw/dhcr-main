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

    public function generateToken($length = 16) {
        $time = substr((string)time(), -6, 6);
        $possible = '0123456789abcdefghijklmnopqrstuvwxyz';
        // create an unique token
        do {
            $token = '';
            for($i = 0; $i < $length - 6; $i++) {
                $token .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            }
            $token = $time . $token;
        } while(!$this->isUnique());
        return $token;
    }

    public function isUnique() {
        if(empty($this->_defaultConfig['fieldname'])) return true;
        return !(bool) $this->_table->find('all',  ['conditions' => [
            $this->_table->getAlias().'.'.$this->_defaultConfig['fieldname'] => $token
        ]])->count();
    }
}

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

    public function generateToken($fieldname = null): string
    {
        $time = substr((string)time(), -6, 6);
        $possible = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = 16;
        // create an unique token
        do {
            $token = '';
            for ($i = 0; $i < $length - 6; $i++) {
                $token .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
            }
            $token = $time . $token;
        } while (!$this->isUnique($token, $fieldname));
        return $token;
    }

    public function isUnique(string $token, string $fieldname = null)
    {
        if (empty($fieldname) and empty($this->_defaultConfig['fieldname'])) return true;
        if (empty($fieldname)) $fieldname = $this->_defaultConfig['fieldname'];
        return !(bool) $this->_table->find()->where([
            $this->_table->getAlias() . '.' . $fieldname => $token
        ])->count();
    }
}

<?php
declare(strict_types=1);

namespace App\Authenticator;

use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Authentication\Identifier\IdentifierInterface;
use Psr\Http\Message\ServerRequestInterface;


class ShibAuthenticator extends AbstractAuthenticator
{


    public static $shib_mapping = [
        'HTTP_EPPN' => 'shib_eppn',
        'HTTP_GIVENNAME' => 'first_name',
        'HTTP_SN' => 'last_name',
        'HTTP_EMAIL' => 'email'
    ];

    /**
     * Constructor
     *
     * @param \Authentication\Identifier\IdentifierInterface $identifier Identifier or identifiers collection.
     * @param array $config Configuration settings.
     */
    public function __construct(IdentifierInterface $identifier, array $config = [])
    {
        parent::__construct($identifier, $config);
    }


    protected function _getData(ServerRequestInterface $request) : array
    {
        $data = $request->getServerParams();
        $result = [];
        foreach($data as $key => $value) {
            if(!empty(self::$shib_mapping[$key]))
                $result[self::$shib_mapping[$key]] = $value;
        }
        return $result;
    }

    /**
     * Returns a result if the user is already authenticated and begins the authentication process otherwise
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request) : ResultInterface
    {
        $data = $this->_getData($request);
        $identity = $this->_identifier->identify($data);

        if (empty($identity)) {
            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND, $this->_identifier->getErrors());
        }

        return new Result($identity, Result::SUCCESS);
    }
}

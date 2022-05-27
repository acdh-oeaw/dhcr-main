<?php
declare(strict_types=1);

namespace App\Authenticator;

use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Authentication\Identifier\IdentifierInterface;
use Cake\Core\Configure;
use Psr\Http\Message\ServerRequestInterface;


class ServerEnvironmentAuthenticator extends AbstractAuthenticator
{

    /**
     * @var array|string[]
     *
     * Provide the UPPER_CASE $_SERVER key and output data mapping key.
     * [
     *   'HTTP_EPPN' => 'shib_eppn',
     *   'HTTP_GIVENNAME' => 'first_name',
     *   'HTTP_SN' => 'last_name',
     *   'HTTP_EMAIL' => 'email'
     * ]
     */
    public $mapping = [];

    /**
     * @var string
     *
     * A string key used to identify the user.
     * 'shib_eppn'
     */
    public $token = '';

    /**
     * Constructor
     *
     * @param \Authentication\Identifier\IdentifierInterface $identifier Identifier or identifiers collection.
     * @param array $config Configuration settings.
     */
    public function __construct(IdentifierInterface $identifier = null, array $config = [])
    {
        parent::__construct($identifier, $config);
        if(!empty($config['mapping']))
            $this->mapping = array_merge($this->mapping, $config['mapping']);
        if(!empty($config['token']))
            $this->token = $config['token'];
    }



    public function getData(ServerRequestInterface $request) : array
    {
        $params = $request->getServerParams();
        $result = [];
        foreach($this->mapping as $key => $mapping) {
            if(!empty($params[$key]))
                $result[$mapping] = $params[$key];
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
        $data = $this->getData($request);

        if(empty($data))
            return new Result(null, Result::FAILURE_OTHER, ['No data could be extracted from $_SERVER.']);

        // make sure the required credentials are present
        if(empty($data[$this->token]))
            return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, ["Credential field $this->token is not present."]);

        $identity = $this->_identifier->identify($data);

        if(empty($identity)) {
            // partial success: credentials present, but no known identity on our end
            return new AppResult($data, AppResult::NEW_EXTERNAL_IDENTITY, $this->_identifier->getErrors());
        }

        return new Result($identity, Result::SUCCESS);
    }
}

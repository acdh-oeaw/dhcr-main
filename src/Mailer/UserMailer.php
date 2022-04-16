<?php

namespace App\Mailer;

use App\Model\Entity\User;

class UserMailer extends AppMailer
{


    public function welcome(User $user)
    {
        $this
            ->setTo($user->email)
            ->setSubject('Welcome! Your account is ready to log in.')
            ->setViewVars(['user' => $user])
            ->viewBuilder()
            ->setTemplate('users/welcome'); // By default template with same name as method name is used.
    }

    public function confirmationMail(User $user)
    {
        $this
            ->setTo($this->preventMailbombing($user->new_email))
            ->setSubject('Confirm your email address')
            ->setViewVars(['user' => $user])
            ->viewBuilder()
            ->setTemplate('users/confirmation_mail');
    }

    public function resetPassword(User $user)
    {
        $this
            ->setTo($user->email)
            ->setSubject('Reset password')
            ->setViewVars(['user' => $user])
            ->viewBuilder()->setTemplate('users/reset_password');
    }

    public function notifyAdmin(User $user, $adminAddress)
    {
        $this
            ->setTo($this->preventMailbombing($adminAddress))
            ->setSubject('New Account Request')
            ->setViewVars(['user' => $user])
            ->viewBuilder()->setTemplate('users/notify_admin');
    }

    public function contactForm($data, $adminAddress)
    {
        $this
            ->setTo($this->preventMailbombing($adminAddress))
            ->setCc($data['email'])
            ->setReplyTo($data['email'])
            ->setSender($data['email'], trim(
                $data['first_name'] . ' '
                    . $data['last_name']
            ))
            ->setSubject('New Question')
            ->setViewVars('content', $data['message'])
            ->viewBuilder()
            ->setTemplate('default');
    }
}

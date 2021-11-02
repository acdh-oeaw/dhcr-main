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

    public function emailConfirmation(User $user)
    {
        $this
            ->setTo($user->new_email)
            ->setSubject('Confirm your email address')
            ->setViewVars(['user' => $user])
            ->viewBuilder()
                ->setTemplate('users/email_confirmation');
    }

    public function resetPassword(User $user)
    {
        $this
        ->setTo($user->email)
        ->setSubject('Reset password')
        ->setViewVars(['user' => $user])
            ->viewBuilder()->setTemplate('users/reset_password');
    }

    public function notifyAdmin(User $user, $admin) {
        $this
            ->setTo($admin)
            ->setSubject('New Account Request')
            ->setViewVars(['user' => $user])
                ->viewBuilder()->setTemplate('users/notify_admin');
    }

}
?>

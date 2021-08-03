<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Events\CustomerEmailVerified;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | customer that recently registered with the application. Emails may also
    | be re-sent if the customer didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect customers after verification.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('customer.auth');
        $this->middleware('signed')->only('customer.verify');
        $this->middleware('throttle:6,1')->only('customer.verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user('customer')->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('customer.auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (! hash_equals((string) $request->route('id'), (string) $request->user('customer')->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($request->user('customer')->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user('customer')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user('customer')->markEmailAsVerified()) {
            $customer = Customer::find($request->user('customer')->id);
            $customer->is_active = 1;
            $customer->save();

            if(setting('email_notification') === 'enable' && setting('welcome_mail') === 'enable') {
                event(new CustomerEmailVerified($request->user('customer')));
            }
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user('customer')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user('customer')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}

<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        // \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        //     // add your listeners (aka providers) here
        //     'SocialiteProviders\\Graph\\GraphExtendSocialite@handle',
        // ],
        'send-transaction-processor-email' => [
            'App\Laravel\Listeners\SendEmailProcessorTransactionListener'
        ],
        'send-transaction-processor' => [
            'App\Laravel\Listeners\SendProcessorTransactionListener'
        ],
        'send-sms-processor' => [
            'App\Laravel\Listeners\SendProcessorReferenceListener'
        ],
        'send-customer-otp' => [
            'App\Laravel\Listeners\SendCustomerOTPListener'
        ],
        'send-customer-otp-email' => [
            'App\Laravel\Listeners\SendCustomerOTPEmailListener'
        ],
        'send-customer-registration-active-email' => [
            'App\Laravel\Listeners\SendCustomerRegistrationActiveEmailListener'
        ],
        'send-customer-registration-declined-email' => [
            'App\Laravel\Listeners\SendCustomerRegistrationDeclinedEmailListener'
        ],
        'send-customer-registration-active' => [
            'App\Laravel\Listeners\SendCustomerRegistrationActiveListener'
        ],
        'send-customer-registration-declined' => [
            'App\Laravel\Listeners\SendCustomerRegistrationDeclinedListener'
        ],
        'send-business-permit-assessment-confirmation' => [
            'App\Laravel\Listeners\SendBusinessPermitAssessmentConfirmation'
        ],
        'send-sms-approved' => [
            'App\Laravel\Listeners\SendApprovedReferenceListener'
        ],
        'send-sms-declined' => [
            'App\Laravel\Listeners\SendDeclinedReferenceListener'
        ],
        'send-sms' => [
            'App\Laravel\Listeners\SendReferenceListener'
        ],
        'send-application' => [
            'App\Laravel\Listeners\SendApplicationListener'
        ],
        'send-eorurl' => [
            'App\Laravel\Listeners\SendEorUrlListener'
        ],
        'send-email-declined' => [
            'App\Laravel\Listeners\SendDeclinedEmailListener'
        ],
        'send-email-approved' => [
            'App\Laravel\Listeners\SendApprovedEmailListener'
        ],
         'send-email-certificate' => [
            'App\Laravel\Listeners\SendCertificateListener'
        ],
        'send-sms-violation' => [
            'App\Laravel\Listeners\SendViolationListener'
        ],
        'send-sms-tax' => [
            'App\Laravel\Listeners\SendTaxListener'
        ],
        'send-email-business-approved' => [
            'App\Laravel\Listeners\SendEmailBusinessApprovedListener'
        ],
        'send-email-business-declined' => [
            'App\Laravel\Listeners\SendEmailBusinessDeclineListener'
        ],
        'send-email-application-declined' => [
            'App\Laravel\Listeners\SendEmailApplicationDeclinedListener'
        ],
        'send-email-reference' => [
            'App\Laravel\Listeners\SendEmailProcessorReferenceListener'
        ],
        'send-reset-password' => [
            'App\Laravel\Listeners\SendResetPasswordListener'
        ],
        'send-new-business_cv-email' => [
            'App\Laravel\Listeners\SendNewBusinessCVEmailListener'
        ],
        'send-new-business_cv' => [
            'App\Laravel\Listeners\SendNewBusinessCVListener'
        ],
        'upload-line-of-business-to-local' => [
            'App\Laravel\Listeners\UploadLineOfBusinessToLocalListener'
        ],
        'notify-departments-sms' => [
            'App\Laravel\Listeners\NotifyDepartmentSMSListener'
        ],
        'notify-departments-email' => [
            'App\Laravel\Listeners\NotifyDepartmentEmailListener'
        ],
        'notify-bplo-admin-sms' => [
            'App\Laravel\Listeners\NotifyBPLOAdminSMSListener'
        ],
        'notify-bplo-admin-email' => [
            'App\Laravel\Listeners\NotifyBPLOAdminEmailListener'
        ],
        'send-digital-business-permit' => [
            'App\Laravel\Listeners\SendEmailDigitalCertificateListener'
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

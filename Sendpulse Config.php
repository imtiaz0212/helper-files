<?php

namespace App\Http\Classes;

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class SendPulseApiClient
{
    public static function sendpulsemail() {

        $userid = 'a078ab13a359cadf5d5e370f14434ecb';
        $secret = 'b34fc0518f8d7329150b64289471f9f9';
        $storageFolder = storage_path().'/attachments/';

       return new ApiClient($userid, $secret, new FileStorage($storageFolder));
    }

}



public static function sendNewsLetter($mailer, $email, $template, $uid) {

    $templateText = 'GPosting Guest Post Service';
    $subject = $template->subject;
    $body = $template->description;
    $mailFrom = $mailer.'@gposting.com';

    if($template->templateText) {
        $templateText = $template->templateText;
    }


    $SPApiClient = SendPulseApiClient::sendpulsemail();
    $html= view('mail.newsletter', ['email_data' => ['body' => $body, 'subject' => $subject]]);

    $mailingData = array(
        'html' => $html,
        'text' => $templateText,
        'subject' => $template->subject,
        'from' => array(
            'name' => 'GPosting LTD',
            'email' => $mailFrom,
        ),
        'to' => array(
            array(
                'name' => '',
                'email' => $email,
            ),
        )
    );

    $response = get_object_vars($SPApiClient->smtpSendMail($mailingData));

    if(array_key_exists('result', $response)) {
        InvoiceMail::create([
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
            'userId' => $uid
        ]);
    } else {
        if($response['is_error'] && $response['http_code'] == 429) {
            MailBox::where('email', $email)->update([
                'isActive' => 0,
                'updatedAt' => date("Y-m-d H:i:s")
            ]);

        } else{
            $logs = 'Oops! Failed send news letter to '.$email.' this email address. Error: '.json_encode($response);

            ErrorLogs::query()->create([
                'logs' => $logs,
                'errorType' => 2
            ]);
        }
    }
}




// send email
$sendMail = SendPulseEmail()->send();
$html     = view('mail.forgetPassword', ['name' => $info->name, 'token' => $token]);

$mailingData = array(
    'html'    => $html,
    'text'    => 'Links Posting',
    'subject' => "Forgot Password",
    'from'    => array(
        'name'  => 'Links Posting',
        'email' => 'hello@linksposting.com',
    ),
    'to'      => array(
        array(
            'name'  => '',
            'email' => '7987imtiaz212@gmail.com',
        ),
    )
);

$response = $sendMail->smtpSendMail($mailingData);

if (!empty($response['result'])){
    dd($response);
}else{
    dd($response);
}




<a style="color:#ff4800" href="@{{unsubscribe_url}}" target="_blank">unsubscribe</a>
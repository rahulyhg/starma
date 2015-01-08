<?php
require_once('../header.php');


//SUGGESTED MATCH TESTING
    $chart_id = get_single_suggested_match(53);
    echo '<br> single match chart_id: ' . $chart_id;
    echo '<br>';
    echo 'name: ' . get_nickname(get_user_id_from_chart_id($chart_id));


//MANDRILL TESTING
/*
try {
    $mandrill = new Mandrill('yz5APugrFIuJW-iZlKYrIg');
    $template_name = 'message_mandrill';
    $template_content = array(
        array(
            'name' => 'username',
            'content' => 'Matthew',
            'name' => 'click_here',
            'content' => 'Click here to view it'
        )
    );
    $message = array(
        'html' => '<p>Example HTML content</p>',
        'text' => 'Example text content',
        'subject' => 'example subject',
        'from_email' => 'contact@starma.com',
        'from_name' => 'Example Name',
        'to' => array(
            array(
                'email' => 'mticciati@gmail.com',
                'name' => 'Matthew',
                'type' => 'to'
            )
        ),
        'headers' => array('Reply-To' => 'message.reply@example.com'),
        'important' => false,
        'track_opens' => null,
        'track_clicks' => null,
        'auto_text' => null,
        'auto_html' => null,
        'inline_css' => null,
        'url_strip_qs' => null,
        'preserve_recipients' => null,
        'view_content_link' => null,
        'bcc_address' => '',
        'tracking_domain' => null,
        'signing_domain' => null,
        'return_path_domain' => null,
        'merge' => true,
        'merge_language' => 'mailchimp',
        'global_merge_vars' => array(
            array(
                'name' => 'merge1',
                'content' => 'merge1 content'
            )
        ),
        'merge_vars' => array(
            array(
                'rcpt' => 'recipient.email@example.com',
                'vars' => array(
                    array(
                        'name' => 'merge2',
                        'content' => 'merge2 content'
                    )
                )
            )
        ),
        'tags' => array(''),
        //'subaccount' => 'customer-123',
        'google_analytics_domains' => array(''),
        'google_analytics_campaign' => '',
        'metadata' => array('website' => ''),
        'recipient_metadata' => array(),
        'attachments' => array(),
        'images' => array()
    );
    $async = false;
    $ip_pool = '';
    //$send_at = 'example send_at';
    $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool);
    echo 'Result: ';
    print_r($result);

*/
    /*
    Array
    (
        [0] => Array
            (
                [email] => recipient.email@example.com
                [status] => sent
                [reject_reason] => hard-bounce
                [_id] => abc123abc123abc123abc123abc123
            )
    
    )
    */
/*
} catch(Mandrill_Error $e) {
    // Mandrill errors are thrown as exceptions
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
    throw $e;
}
*/
//echo '<br><br>Info: ';
//$info = $mandrill->messages->info($result['_id']);
//print_r($info);

?>
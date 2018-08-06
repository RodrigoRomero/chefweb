<?php
/* VERSION: 2.0.0
 *
 *
 */
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| EMAIL CONFING
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */

/*
$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => '192.168.10.10',
  'smtp_port' => 1025,
  'smtp_user' => 'noreply@argentinavision2020.com',
  'smtp_pass' => 'm8mKzK2/Acn/V',
  'mailtype' => 'html',
  'crlf' => "\r\n",
  'newline' => "\r\n"
);
*/

$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'smtp.sendgrid.net',
  'smtp_port' => 25,
  'smtp_user' => 'argenv2020',
  'smtp_pass' => 'p8T8EeS5gF8regxA',
  'mailtype' => 'html',
  'crlf' => "\r\n",
  'newline' => "\r\n"
);

/* End of file email.php */
/* Location: ./system/application/config/email.php vnstudios2017!*/

<?php
class Inbox extends MY_Controller 
{

  function __construct() {
    parent::__construct();
    Modules::run('secure_tings/is_logged_in');

  }

  function index() {
    $data['section'] = "NVIP Chanjo";
    $data['subtitle'] = "Inbox";
    $user_level=$this->session->userdata['logged_in']['user_level'];
    $data['view_file'] = "inbox_view";
    $data['module'] = "inbox";
    $data['id'] = ($this->session->userdata['logged_in']['user_id']);
    $data['user_level'] = ($this->session->userdata['logged_in']['user_level']);
    $data['user_object'] = $this->get_user_object();
    $data['main_title'] = $this->get_title();

    //   $mb = imap_open("chi-rs31.websitehostserver.net:585","victor@wkdesigns.co.ke", "smartguy123" );
    $mb = imap_open("{chi-rs31.websitehostserver.net:993/imap/ssl/novalidate-cert}INBOX", 'victor@wkdesigns.co.ke', 'smartguy123');

    $MC = imap_check($mb);
    $data['message_count'] = imap_num_msg($mb);


    $result = imap_fetch_overview($mb,"1:{$MC->Nmsgs}",0);
    imap_close($mb);
    $data['email'] = $result;

    $this->load->library('make_bread');
    $this->make_bread->add('Inbox', '', 0);
    $data['breadcrumb'] = $this->make_bread->output();
    echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

  }
  function compose(){

    $mb = imap_open("{chi-rs31.websitehostserver.net:993/imap/ssl/novalidate-cert}INBOX", 'victor@wkdesigns.co.ke', 'smartguy123');

    $MC = imap_check($mb);
    $data['message_count'] = imap_num_msg($mb);
    $data['section'] = "NVIP Chanjo";
    $data['subtitle'] = "Inbox";
    $user_level=$this->session->userdata['logged_in']['user_level'];
    $data['view_file'] = "compose_v";
    $data['module'] = "inbox";
    $data['id'] = ($this->session->userdata['logged_in']['user_id']);
    $data['user_level'] = ($this->session->userdata['logged_in']['user_level']);
    $data['user_object'] = $this->get_user_object();
    $data['main_title'] = $this->get_title();

    $this->load->library('make_bread');
    $this->make_bread->add('Inbox', '/inbox', 0);
    $data['breadcrumb'] = $this->make_bread->output();
    echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);


  }
  function sendmail(){
    $user_email=$this->session->userdata['logged_in']['user_email'];
    $message=$_POST['message'];
    $to=$_POST['to'];
    $subject=$_POST['subject'];

    require APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'chi-rs31.websitehostserver.net ';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'victor@wkdesigns.co.ke';                 // SMTP username
    $mail->Password = 'smartguy123';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom($user_email);
    $mail->addAddress($to, 'kwoshvick');     // Add a recipient
    /*$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');*/
    if(!empty($_POST['cc'])){
      $mail->addCC($_POST['cc']);
    }
    if(!empty($_POST['bcc'])){
      $mail->addBCC($_POST['bcc']);
    }

    /*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
      // $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center col-md-12">Message could not be sent.<br> Mailer Error:'. $mail->ErrorInfo.'</div>');
      // redirect('inbox/','refresh');
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      die();
    } else {

      $this->session->set_flashdata('msg', '<div id="alert-message" class="alert alert-danger text-center col-md-12">Message has been sent</div>');
      redirect('inbox/','refresh');

    }

  }



  function getmail($value){

    $data['section'] = "NVIP Chanjo";
    $data['subtitle'] = "Inbox";
    $user_level=$this->session->userdata['logged_in']['user_level'];
    $data['view_file'] = "readmail_view";
    $data['module'] = "inbox";
    $data['id'] = ($this->session->userdata['logged_in']['user_id']);
    $data['user_level'] = ($this->session->userdata['logged_in']['user_level']);
    $data['user_object'] = $this->get_user_object();
    $data['main_title'] = $this->get_title();

    $mb = imap_open("{chi-rs31.websitehostserver.net:993/imap/ssl/novalidate-cert}INBOX", 'victor@wkdesigns.co.ke', 'smartguy123')
    or die('Cannot connect: ' . print_r(imap_errors(), true));

    $MC = imap_check($mb);
    $messageCount = imap_num_msg($mb);


    for( $MID = 1; $MID <= $messageCount; $MID++ )
    {
      $EmailHeaders[] = imap_headerinfo( $mb, $MID );
      $Body[] = imap_fetchbody( $mb, $MID, 1 );

       }

    $email_header = $EmailHeaders[$value-1];
    $email_body = $Body[$value-1];


    $data['email_header'] = $email_header;
    $data['email_body'] = $email_body;


    $this->load->library('make_bread');
    $this->make_bread->add('Inbox', '/inbox', 0);
    $data['breadcrumb'] = $this->make_bread->output();
    echo Modules::run('template/'.$this->redirect($this->session->userdata['logged_in']['user_group']), $data);

  }

}
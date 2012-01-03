<?php
$config['db_name'] = '';
$config['db_hostname'] = 'localhost';
$config['db_username'] = 'root';
$config['db_password'] = '';

$config['mail_smtp'] = true;
$config['mail_username'] = 'example@example.com';
$config['mail_password'] = '';
$config['mail_smtp_host'] = '';
$config['mail_smtp_port'] = 465;

$config['site_name'] = "My Site";
$config['organization_name'] = "An Organization";
$config['site_address'] = ""; //no trailing slash

$config['form_array_delimiter'] = "*~"; //this is used for checkboxes

//lock configuration
//the time in seconds a user must wait before trying again; otherwise they get locked out (count not increased)
$config['lock_time_initial'] = array('checkuser' => 5, 'checkadmin' => 5, 'register' => 20, 'root' => 10, 'peer' => 10, 'reset' => 60, 'reset_check' => 60);
//the time that overloads last
$config['lock_time_overload'] = array('checkuser' => 60*2, 'checkadmin' => 60*2, 'register' => 60*2, 'root' => 60*2, 'peer' => 60*2, 'reset' => 60*2, 'reset_check' => 60*2);
//the number of tries a user has (that passes the lock_time_initial test) before being locked by overload
$config['lock_count_overload'] = array('checkuser' => 12, 'checkadmin' => 12, 'register' => 12, 'root' => '12', 'peer' => 12, 'reset' => 12, 'reset_check' => 12);
//if a previous lock found less than this many seconds ago, count++; otherwise old entry is replaced
$config['lock_time_reset'] = 60;
//max time to store locks in the database; this way we can clear old locks with one function
$config['lock_time_max'] = 60*5;

//time it takes for reset to expire; users can only have one reset request at a time
$config['reset_time'] = 60*60*72;

$config['max_recommend'] = 10;

$config['root_password'] = '';
$config['style'] = 0;
$config['app_enabled'] = true;

$config['latex_path'] = "/usr/bin/pdflatex";

$config['page_display'] = array('index', 'dbpage.php?page=about', 'login', 'register', 'dbpage.php?page=contact');
$config['page_display_names'] = array('Home', 'About Us', 'Login', 'Register', 'Contact Us');

$config['apply_page_display'] = array('index', 'account', 'logout');
$config['apply_page_display_names'] = array('Home', 'Account', 'Logout');

$config['apply_side_display'] = array('clubs', 'base', 'supplement', 'peer');
$config['apply_side_display_names'] = array('Clubs', 'General Application', 'Supplements', 'Peer recommendations');

$config['admin_page_display'] = array('index', 'index.php?action=logout&ex=');
$config['admin_page_display_names'] = array('Home', 'Logout');

$config['admin_side_display'] = array('man_questions', 'view_submit', 'man_club', 'preview', 'man_notes', 'gen_pdf');
$config['admin_side_display_names'] = array('Manage questions', 'View submissions', 'Manage club information', 'Preview application', 'Notes settings', 'Generate PDF');

$config['root_page_display'] = array('index', 'index.php?action=logout&ex=');
$config['root_page_display_names'] = array('Home', 'Logout');

$config['root_side_display'] = array('index', 'man_pages', 'man_admins', 'man_cat', 'man_clubs', 'userlist', 'rm_peer', 'check_pdf', 'check_nohome', 'check_mismatch');
$config['root_side_display_names'] = array('Home', 'Manage pages', 'Manage admins', 'Manage categories', 'Manage clubs', 'User list', 'Remove recommendations', 'Check extra PDFs', 'Check questions without a home', 'Check mismatched applications');

$config['time_dateformat'] = 'D, d M Y H:i:s'; //format used to display the current time
$config['club_dateformat'] = 'D, d M Y H:i:s'; //format used to display deadlines and opening times for club supplements
?>

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

//time before a user is deleted after registration if they do not access their account
$config['activation_time'] = 60*60*48;

//maximum number of recommenders that can be added
$config['max_recommend'] = 10;

$config['style'] = 'basic';
$config['style_available'] = array('basic','one','two');
$config['app_enabled'] = true;

$config['latex_path'] = "/usr/bin/pdflatex";

$config['page_display'] = array('index', 'dbpage.php?page=about', 'login', 'register', 'dbpage.php?page=contact');
$config['page_display_names'] = array('Home', 'About Us', 'Login', 'Register', 'Contact Us');

$config['apply_page_display'] = array('index', 'account', 'logout');
$config['apply_page_display_names'] = array('My Workspace', 'Account', 'Logout');

$config['apply_side_display'] = array('clubs', 'base', 'supplement', 'peer', 'messaging');
$config['apply_side_display_names'] = array('Clubs', 'General Application', 'Supplements', 'Peer recommendations', 'Messaging');

$config['admin_page_display'] = array('index', 'index.php?action=logout');
$config['admin_page_display_names'] = array('Admin Workspace', 'Logout');

$config['admin_side_display'] = array('man_questions', 'view_submit', 'view_subscribe', 'messaging', 'man_club', 'preview', 'man_notes', 'gen_pdf', 'statistics', 'easy_question','purchase');
$config['admin_side_display_names'] = array('Manage questions', 'View submissions', 'View subscribed users', 'Club messaging', 'Manage club information', 'Preview application', 'Submission settings', 'Generate PDF', 'Statistics', 'Easy Question Adder', 'Purchase History');

$config['root_page_display'] = array('index', 'index.php?action=logout');
$config['root_page_display_names'] = array('Root Workspace', 'Logout');

$config['root_side_display'] = array('root_cat.php?cat=Manage', 'root_cat.php?cat=Statistics', 'root_cat.php?cat=Clean+system', 'dbwipe', 'backup', 'man_config');
$config['root_side_display_names'] = array('Manage', 'Statistics', 'Clean System', 'Database wipe', 'Backup', 'Settings');

$config['root_cat_display'] = array('manage' => array(), 'statistics' => array(), 'clean' => array());

$config['root_cat_display']['Database']['desc'] = "Database tool will allow you to clean, delete, and backup the data.";
$config['root_cat_display']['Database']['links'] = array('full_clean', 'dbwipe', 'backup');
$config['root_cat_display']['Database']['names'] = array('Clean System', 'Database Wipe', 'Backup');
$config['root_cat_display']['Database']['link_desc'] = array('<li>Delete Unnecessary Files</li>', '', '<li>Save Files</li><li>Store Copies</li><li>Download Save States</li>');

$config['root_cat_display']['Statistics']['desc'] = "Statistics tools allow you to gather basic information about the status of your organizations and website.";
$config['root_cat_display']['Statistics']['links'] = array('statistics', 'statistics_club');
$config['root_cat_display']['Statistics']['names'] = array('General statistics', 'Club statistics');
$config['root_cat_display']['Statistics']['link_desc'] = array('<li>User Count</li><li>Club Count</li><li>Submission Statistics</li>', '<li>Submissions per Club</li><li>Total Applicant Count</li><li>Percent Complete</li>');

$config['root_cat_display']['Manage']['desc'] = "General management features appear below, from which you may <b>view users</b>, <b>add admins</b>, <b>organizations</b>, and <b>general application categories</b>. Please click on one of the links below to access these features.";
$config['root_cat_display']['Manage']['links'] = array('userlist', 'man_admins', 'man_clubs', 'man_cat', 'man_funds');
$config['root_cat_display']['Manage']['names'] = array('Users', 'Admins', 'Clubs', 'Categories', 'Funds');
$config['root_cat_display']['Manage']['link_desc'] = array('<li>Reset Applications</li><li>Remove Users</li><li>User Information</li>', '<li>Add Administrators</li><li>Remove Administrators</li><li>Club Assignment</li>', '<li>Add Clubs</li><li>Remove Clubs</li><li>Edit Club Information</li>', '<li>Include Categories</li><li>Alter Tags</li>', '<li>Approve Pruchase Requests</li><li>View Purchase History</li><li>Organize Spending</li>');

$config['root_cat_display']['Clean system']['desc'] = 'Tools below allow you to clear old files to conserve system resources. The <b>Full Database Cleaner</b> will delete old database entries, while the other options will maintain the database or delete unneeded files.';
$config['root_cat_display']['Clean system']['links'] = array('full_clean', 'rm_peer', 'check_pdf', 'check_nohome', 'check_mismatch');
$config['root_cat_display']['Clean system']['names'] = array('Full database cleaner', 'Recommendations', 'Extra PDFs', 'Questions without a home', 'Mismatched applications');
$config['root_cat_display']['Clean system']['link_desc'] = array('', '', '', '', '');

$config['time_dateformat'] = 'D, d M Y H:i:s'; //format used to display the current time
$config['club_dateformat'] = 'D, d M Y H:i:s'; //format used to display deadlines and opening times for club supplements

$config['limits'] = array('clubs' => -1, 'users' => -1); //limit of -1 is unlimited

//enabling both of the options below is recommended to prevent cross-site request forgeries
$config['csrf_referer'] = true;
$config['csrf_token'] = false;

//if not blank, the fields below will be used for RSA encryption (modulus in hexadecimal)
// this ensures that passwords cannot be recovered even if an eavesdropper has full access to the server-client dialog
// to generate a key, see http://www-cs-students.stanford.edu/~tjw/jsbn/
// note: if you are using SSL, do NOT enable this - it'll waste resources on both client and server side
$config['rsa_modulus'] = '';
$config['rsa_exponent'] = '10001';
$config['rsa_key'] = '';
$config['rsa_passphrase'] = '';

//whether to enable the captcha system
// in order to use this, you must install Securimage 3.0 to the oneapp root directory
// this can be downloaded at http://www.phpcaptcha.org/download/
$config['captcha_enabled'] = false;
?>

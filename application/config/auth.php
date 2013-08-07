<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Login controller used to redirect
$config['auth_login_controller'] = 'Login';

/* Use something complicated. After initial setup change only when you need to
 * force all users to login again.
 */
$config['auth_session_hash_key'] = 'shop';

/* Use something complicated. After initial setup change only when you need to
 * force all users to recover their passwords.
 */
$config['auth_password_hash_key'] = 'shop';


/* Use something complicated. After initial setup change only when you need to
 * force all remember me option users to login again.
 */
$config['auth_cookie_hash_key'] = 'shop';

/* Use something complicated. After initial setup change only when you need to
 * force all not activated users to recover their activation emails.
 */
$config['auth_activate_hash_key'] = 'shop';

/* End of file auth.php */
/* Location: ./application/config/auth.php */
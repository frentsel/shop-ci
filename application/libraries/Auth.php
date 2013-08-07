<?php

/**
 * Codeigniter PHP framework library class for dealing with user authentication.
 *
 * @package     CodeIgniter
 * @subpackage	Libraries
 * @category	Authentication
 * @author	Marko Martinović <marko@techytalk.info>
 * @link	https://github.com/Marko-M/codeigniter-auth
 */
class Auth {
    // Codeigniter instance
    protected $CI;

    // Configuration options
    protected $config;

    /**
     * Initialize auth by loading neccesary libraries, helpers and config items.
     *
     * @param array $config Override default configuration
     */
    public function __construct($config = array()) {
        $this->CI = &get_instance();

        // Merge $config and config/auth.php $config
        $this->config = array_merge (
            array(
                'auth_login_controller' =>
                    $this->CI->config->item('auth_login_controller'),
                'auth_session_hash_key' =>
                    $this->CI->config->item('auth_session_hash_key'),
                'auth_password_hash_key' =>
                    $this->CI->config->item('auth_password_hash_key'),
                'auth_cookie_hash_key' =>
                    $this->CI->config->item('auth_session_hash_key'),
                'auth_activate_hash_key' =>
                    $this->CI->config->item('auth_activate_hash_key')
            ),
            $config
        );

        $this->CI->load->library('session');
        $this->CI->load->helper('cookie');
    }

    /**
     * Checks is user logged in by checking session vars and remember cookie.
     *
     * @return boolean Is user logged in or not?
     */
    public function is_logged_in() {
        // Is session logged in?
        if($this->CI->session->userdata('id')) {
            // Are session vars genuine?
            if (
                $this->get_sha256(
                    array(
                        $this->CI->session->userdata('id'),
                        $this->CI->session->userdata('email'),
                        $this->CI->session->userdata('password_hash')
                    ),
                    'session'
                ) == $this->CI->session->userdata('hash')) {

                return true;
            } else {
                // If session vars aren't genuine, delete them
                $this->logout();
            }
        }

        // Is cookie logged in?
        if(($cookie = get_cookie('remember'))) {
            // Is cookie valid?
            if($this->check_cookie($cookie)) {
                return true;
            } else {
                // If cookie isn't valid, delete it
                $this->logout();
            }
        }

        return false;
    }

    /**
     * Log user in with given credentials, usually received from
     * login form.
     *
     * @param string $email Email from login form
     * @param string $password Password from login form
     * @param boolean $remember Remember me or not?
     * @return mixed User ID if successful and false not
     */
    public function login($email, $password, $remember) {

        // Generate password hash
        $password_hash = $this->get_sha256($password, 'password');

        $query = $this->CI->db->query(
            'SELECT
                user_id
            FROM '.$this->CI->db->dbprefix.'users
            WHERE user_activated = 1 AND user_email = ? AND user_password_hash = ?',
            array(
                $email,
                $password_hash
            )
        );

        // Are given credentials valid?
        if($query->num_rows() > 0) {
            // If credentials are valid
            $row = $query->row();

            $user_id = $row->user_id;

            // Set session variables
            $this->set_session($user_id, $email, $password_hash);

            // Remember me?
            if($remember) {
                // If yes then set cookie
                $this->set_cookie($user_id);
            }

            return $user_id;
        }

        return false;
    }

    /**
     * Register user with given credentials, usually received from
     * register form.
     *
     * @param string $email
     * @param string $password
     * @return mixed User ID if successful and false if email already taken
     */
    public function register($email, $password) {

        // Generate password hash
        $password_hash = $this->get_sha256($password, 'password');

        // Inserd credentials into database
        $query = $this->CI->db->query(
            'INSERT INTO '.$this->CI->db->dbprefix.'users (
                user_email,
                user_password_hash,
                user_activated,
                user_ip,
                user_date_create,
                user_last_date_visited
            ) VALUES (
                ?,
                ?,
                0,
                ?,
                ?,
                ?
            ) ON DUPLICATE KEY UPDATE user_id = user_id',
            array (
                $email,
                $password_hash,
                $_SERVER['REMOTE_ADDR'],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            )
        );

        // Is email already taken or not?
        if($query && $this->CI->db->affected_rows() == 1) {
            $user_id = $this->CI->db->insert_id();

            return $user_id;
        }

        // Alread taken
        return false;
    }

    /**
     * Prepare token based account activation.
     *
     * @param int $user_id User ID
     * @return string 64 characters token to be delivered to user by email etc.
     */
    public function get_activate_token($user_id) {

        $this->CI->load->helper('string');

        // Generate token
        $activate_token = random_string('alnum', 64);

        $activate_token_hash = $this->get_sha256($activate_token, 'activate');

        /* Insert activate token hash into database, do not allow multiple activate
         * tokens for one user.
         */
        $this->CI->db->query(
            'INSERT INTO '.$this->CI->db->dbprefix.'activate_tokens (
                activate_token_user_id,
                activate_token_hash
            ) VALUES (
                ?,
                ?
            ) ON DUPLICATE KEY UPDATE activate_token_hash = ?',
            array(
                $user_id,
                $activate_token_hash,
                $activate_token_hash
            )
        );

        return $activate_token;
    }

    /**
     * Activate account using token.
     *
     * @param int $user_id User ID
     * @param string $activate_token Activate token
     * @return boolean Account activated or not?
     */
    public function activate_with_token($user_id, $activate_token) {

        // Generate activate hash
        $activate_token_hash = $this->get_sha256($activate_token, 'activate');

        // Try to delete activate_token_user_id and activate_token_hash combination
        $this->CI->db->query(
            'DELETE FROM '.$this->CI->db->dbprefix.'activate_tokens
            WHERE activate_token_user_id = ? AND activate_token_hash = ?',
            array(
                $user_id,
                $activate_token_hash
            )
        );

        if($this->CI->db->affected_rows() > 0) {
            // Correct activation token

            // Activate account
            $this->activate_without_token($user_id);

            // Account activated
            return true;
        }

        // Not correct activation token, account not activated
        return false;
    }

    /**
     * Activate account directly without token.
     *
     * @param int $user_id User ID
     */
    public function activate_without_token($user_id) {

        $this->CI->db->query(
            'UPDATE '.$this->CI->db->dbprefix.'users
                SET user_activated = 1
            WHERE user_id = ?',
            $user_id
        );
    }

    /**
     * Create required database tables.
     *
     * @return boolean Was install successful or not?
     */

    public function install() {

        $sql_users =
        'CREATE TABLE IF NOT EXISTS '.$this->CI->db->dbprefix.'users (
            user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_email VARCHAR(100) NOT NULL,
            user_password_hash CHAR(64) NOT NULL,
            user_activated TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
            PRIMARY KEY(user_id),
            UNIQUE KEY(user_email))
            ENGINE=InnoDB DEFAULT CHARACTER SET utf8,
            DEFAULT COLLATE utf8_general_ci;';

        $sql_remember_tokens =
        'CREATE TABLE IF NOT EXISTS '.$this->CI->db->dbprefix.'remember_tokens (
            remember_token_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            remember_token_user_id INT UNSIGNED NOT NULL,
            remember_token_hash CHAR(64) NOT NULL,
            PRIMARY KEY(remember_token_id),
            FOREIGN KEY(remember_token_user_id)
                REFERENCES '.$this->CI->db->dbprefix.'users(user_id)
                    ON DELETE CASCADE ON UPDATE CASCADE)
            ENGINE=InnoDB DEFAULT CHARACTER SET utf8,
            DEFAULT COLLATE utf8_general_ci;';

        $sql_activate_tokens =
        'CREATE TABLE IF NOT EXISTS '.$this->CI->db->dbprefix.'activate_tokens (
            activate_token_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            activate_token_user_id INT UNSIGNED NOT NULL,
            activate_token_hash CHAR(64) NOT NULL,
            PRIMARY KEY(activate_token_id),
            UNIQUE KEY(activate_token_user_id),
            FOREIGN KEY(activate_token_user_id)
                REFERENCES '.$this->CI->db->dbprefix.'users(user_id)
                    ON DELETE CASCADE ON UPDATE CASCADE)
            ENGINE=InnoDB DEFAULT CHARACTER SET utf8,
            DEFAULT COLLATE utf8_general_ci;';

        if($this->CI->db->query($sql_users) &&
                $this->CI->db->query($sql_remember_tokens) &&
                $this->CI->db->query($sql_activate_tokens)) {
            return true;
        }

        return false;
    }

    /**
     * Log user out by clearing session variables and cookie.
     */
    public function logout(){
        $this->CI->session->sess_destroy();

        delete_cookie('remember');
    }

    /**
     * Redirect user to login url and save current url in session
     * if required.
     *
     * @param boolean $remember_current_url Remember current url or not?
     */
    public function redirect_login_url($remember_current_url = true) {
        $this->CI->load->helper('url');

        if($remember_current_url) {
            $this->CI->session->set_userdata('current_url', current_url());
        }

        redirect(site_url($this->config['auth_login_controller']));
    }

    /**
     * Redirect back to url visited before being redirected to login url.
     */
    public function redirect_current_url() {
        $this->CI->load->helper('url');

        $current_url = $this->CI->session->userdata('current_url');
        if(!$current_url){
            $current_url = site_url();
        }

        redirect($current_url);
    }

    /**
     * Set session vars for logged in users detection.
     *
     * @param int $id User ID
     * @param string $email User email
     * @param string $password_hash 64 characters user's password hash
     */
    protected function set_session($id, $email, $password_hash){
        /* Generate $email concat $password_hash sha256 hash. This hash will be
         * used by is_user_logged_in() to check are session vars genuine.
         */
        $hash = $this->get_sha256 (
            array(
                $id,
                $email,
                $password_hash
            ),
            'session'
        );

        $this->CI->session->set_userdata(
            array(
                'id' => $id,
                'email' => $email,
                'password_hash' => $password_hash,
                'hash' => $hash
            )
        );
    }

    /**
     * Set cookie for logged in users detection.
     *
     * @param int $user_id User ID
     */
    protected function set_cookie($user_id) {
        $this->CI->load->helper('string');

        // Generate token
        $remember_token = random_string('alnum', 64);

        // Generate token hash
        $remember_token_hash = $this->get_sha256($remember_token, 'cookie');

        /* Insert remember token hash into database, allow multiple tokens for
         * same user for having remember functionality on multiple PCs, browsers
         * etc.
         */
        $this->CI->db->query(
            'INSERT INTO '.$this->CI->db->dbprefix.'remember_tokens (
                remember_token_user_id,
                remember_token_hash
            ) VALUES (
                ?,
                ?
            )',
            array(
                $user_id,
                $remember_token_hash
            )
        );

        /* Set remember cookie. Save plain token because we to be able to
         * invalidate existing tokens (cookies) by changing cookie hash key. */
        set_cookie(
            array(
                'name'   => 'remember',
                'value'  => $user_id.' '.$remember_token,
                'expire' => 8640000 // 100 days
            )
        );
    }

    /**
     * Check remember cookie.
     *
     * @param string $cookie Cookie data from remember cookie.
     * @return boolean remember cookie valid or not?
     */
    protected function check_cookie($cookie) {
        $cookie_array = explode(' ', $cookie);

        /* $cookie_array is expected to have two elements, user_id and
         * plain token */
        if(empty($cookie_array) || count($cookie_array) < 2)
            return false;



        $query = $this->CI->db->query(
            'SELECT
                user_id,
                user_email,
                user_password_hash
            FROM '.$this->CI->db->dbprefix.'remember_tokens
            JOIN '.$this->CI->db->dbprefix.'users
                ON remember_token_user_id = user_id
            WHERE remember_token_user_id = ? AND remember_token_hash = ?',
            array(
                $cookie_array[0],

                /* Use token hash to be able to invalidate existing
                 * tokens (cookies) by changing cookie hash key. */
                $this->get_sha256($cookie_array[1], 'cookie')
            )
        );

        // Is token valid?
        if($query->num_rows() > 0) {
            $row = $query->row();

            // If valid set session data...
            $this->set_session(
                $row->user_id,
                $row->user_email,
                $row->user_password_hash
            );

            // ... and regenerate token
            $this->set_cookie($row->user_id);

            return true;
        }

        // Token and cookie aren't valid
        return false;
    }

    /**
     * Generate sha256 hash for given data.
     *
     * @param mixed $to_hash Can be string or array of data
     * @param string $mode Hash key mode, accepted values are session, password and cookie
     * @return string 64 characters hash of has_key concat with the given data
     */
    protected function get_sha256($to_hash, $mode = 'password') {
        if(is_array($to_hash))
            $to_hash = implode('', $to_hash);

        return hash('sha256', $this->config['auth_'.$mode.'_hash_key'].$to_hash);
    }
}
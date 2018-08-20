<?php

require_once dirname(__FILE__) . '/class.dmin-notices.php';

class api_cf7 {

    var $default_columns = array('id', 'name');
    public $error_message;
    private $admin_notices;

    public function __construct() {

        $this->admin_notices = new cf7t_Admin_notices();
    }

    public function init() {
        $this->load_hooks();
    }

    public function load_hooks() {
        add_action('after_qs_cf7_api_send_lead', array($this, 'api_response_proces'), 2, 2);
        add_filter('query_vars', array($this, 'addnew_query_vars'), 10, 1);
        //load javascript footer functions
        add_action('wp_footer', array($this, 'form_footer_call'));
        //add_action('init', array($this,'display_api_error'));
        add_filter('wpcf7_form_response_output', array($this, 'cf_display_error'), 10, 1);
        add_action('admin_init', array($this, 'verify_dependencies'));
    }

    public function api_response_proces($result, $record) {

        if (gettype($result) == 'object' || !isset($result[response][code]) || $result[response][code]!==200){
			// got an error
			// quit
			// TODO: redirect somewhere helpful, like an error page "we ran into a problem trying to sign you up. Try again later."
			$this->redirect_to_appropriate_destination(2);
		}
		
        // Convert JSON string to Array
		$result_response = json_decode($result['body'], true);
        $TrafficManager_O = mvc_model("TrafficManager")->find(array(
				"conditions" => array(
                "error_id" => $result_response['response']['code']
        )));
		
		$TrafficManager_code_type = $TrafficManager_O[0]->code_type;
		
		if(isset($TrafficManager_code_type)){
			if ( $TrafficManager_code_type == 2) {
				$this->redirect_to_appropriate_destination();
			} else {
				$this->display_api_error($result, $record);
			}
		}
		else{
			$this->redirect_to_appropriate_destination();
		}
    }

    public function redirect_to_appropriate_destination($destination_type=1) {
        $redirect_url  = mvc_model("TrafficLink")->find_by_id($destination_type)->url;
		//$redirect_url = $redirect_api_O[0]->url;
        if (!isset($redirect_url)) {
            $redirect_url=get_site_url();
        }
		
		if(wp_redirect($redirect_url)) {
                exit;
          }
    }

    public function form_footer_call() {
       /* echo'<script type="text/javascript">

		function fx(){
			wpcf7form= document.getElementsByClassName("wpcf7-form");
			for (var i=0; i<wpcf7form.length; i++) {
				var e1_campaignid = document.createElement("input");
					e1_campaignid.type = "hidden";
					e1_campaignid.name = "campaignid";
				var e1_sourceid = document.createElement("input");
					e1_sourceid.type = "hidden";
					e1_sourceid.name = "sourceid";		
				wpcf7form[i].appendChild(e1_sourceid);
				wpcf7form[i].appendChild(e1_campaignid);
			}
		};
		fx();
		
		</script> '; */


        if (isset($_GET['source_id']))
            $source_id = $_GET['source_id'];

        if (isset($_GET['campaign_id'])) {
            $campaign_id = $_GET['campaign_id'];
        }
        if (isset($_POST['source_id'])) {
            $source_id = $_POST['source_id'];
        }
        if (isset($_POST['campaign_id'])) {
            $campaign_id = $_POST['campaign_id'];
        }

        echo '<script type="text/javascript">window.onload = function(){document.getElementsByName("source_id")[0].value = "' . $campaign_id . '";document.getElementsByName("campaign_id")[0].value = "' . $source_id . '";}</script>';
        echo '<script type="text/javascript">window.onload = function(){document.getElementsByName("source_id")[0].value = "' . $campaign_id . '";document.getElementsByName("campaign_id")[0].value = "' . $source_id . '";}</script>';
    }

    public function addnew_query_vars($vars) {
        $vars[] = 'source_id'; // var1 is the name of variable you want to add       
        $vars[] = 'campaign_id'; // var1 is the name of variable you want to add       

        return $vars;
    }

    public function add_integrations_tab($panels) {
        $AdminTrafficManagersController = new AdminTrafficManagersController();
        $integration_panel = array(
            'title' => 'Traffic to API',
            'callback' => array($AdminTrafficManagersController, 'index'),
        );

        $panels["qs-cf7-traffic-integration"] = $integration_panel;

        return $panels;
    }

    public function display_api_error($result, $record) {

        $result = $result;
        $result_response = json_decode($result['body'], true);

        // Convert JSON string to Array
        $error_codes = array($result_response['response']['code'],);
        //var_dump($error_codes );

        if (isset($error_codes)) { //if there is an error
            $error_message_display = array();

            foreach ($error_codes as $error_code) {
                mvc_model('TraficLog')->create(array(
                    "TraficLog" => array("error_id" => $error_code, "form_id" =>8),
                ));
            }

            if (count($error_message_display)) {
                foreach ($error_message_display as $message) {
                    //contact form 7 display
                    if (isset($message))
                        $content.=$message . '<br>';
                }
            }
        }
    }

    public function cf_display_error($content) {
        $error_message_display = '';

        //$WPCF7_Submission_d = WPCF7_Submission::get_instance()->get_contact_form();

        if (mvc_model('TraficLog')->count(array("conditions" => array("form_id" => 1 /* $WPCF7_Submission_d->id */))) > 0) {
            $TraficLog = mvc_model('TraficLog')->find(array("conditions" => array("form_id" => 8)));

            //var_dump($TraficLog);
            foreach ($TraficLog as $Log) {
                if (mvc_model('TrafficManager')->count(array("conditions" => array('error_id' => $Log->error_id))) > 0) {
                    $TrafficManagerI = mvc_model('TrafficManager');
                    $TrafficManager_data = $TrafficManagerI->find(array("conditions" => array('error_id' => $Log->error_id)));

                    $error_message_display.= $TrafficManager_data[0]->error_message . '<br>';
                    mvc_model('TraficLog')->delete($Log->id);
                }
            }
            $content = '<div class="wpcf7-response-output wpcf7-display-none wpcf7-mail-sent-ng" role="alert" style="display: block;">' . $error_message_display . '</div>'; //$this->error_message
        }

        return $content;
    }

    public function verify_dependencies() {
        if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
            $notice = array(
                'id' => 'cf7-not-active',
                'type' => 'warning',
                'notice' => 'Contact form 7 api redirect integrations requires CONTACT FORM 7 Plugin to be installed and active',
                'dismissable_forever' => false
            );

            $this->admin_notices->wp_add_notice($notice);
        }

        if (!is_plugin_active('cf7-to-api/contact-form-7-api.php')) {
            $notice = array(
                'id' => 'cf7-not-active',
                'type' => 'warning',
                'notice' => 'API redirect integrations requires Contact form 7 api Plugin to be installed and active',
                'dismissable_forever' => false
            );

            $this->admin_notices->wp_add_notice($notice);
        }
    }

}

?>
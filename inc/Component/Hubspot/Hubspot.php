<?php

namespace Ergopack\Component\Hubspot;

use Ergopack\Component\Hubspot\OAuth2Helper;
use GuzzleHttp\Exception\ClientException;
use HubSpot\Client\Crm\Deals\Model\SimplePublicObjectInput;
use HubSpot\Client\Crm\Contacts\ApiException;
use HubSpot\Discovery\Discovery;
use HubSpot\Utils\OAuth2;
use HubSpot\Factory;
use HubSpot\Client\Crm\Associations\Model\BatchInputPublicAssociation;
use HubSpot\Client\Crm\Associations\Model\PublicAssociation;
use HubSpot\Client\Crm\Associations\Model\PublicObjectId;


/**
 * Class Hubspot
 *
 * @author Effecticore
 * @since 0.1
 */
class Hubspot {

	/**
	 * Run
	 */
	public function run() {
		add_action( 'mu_plugin_loaded', [ &$this, 'start_session' ], 1);
		add_action( 'init', [ &$this, 'callback_check' ], 1 );
		add_action( 'ergo_hubspot', [ &$this, 'upload_file' ] );
		add_action( 'ergo_hubspot', [ &$this, 'deal_price_stage' ], 10, 1 );
		add_action( 'ergo_run_engagement', [ &$this, 'set_engagements' ], 0, 2 );
		add_action( 'rest_api_init', [ &$this, 'create_endpoint' ] );
	}

	/**
	 * Initializes Hubspot instance
	 */
	public static function createFactory(): Discovery {
        if (OAuth2Helper::isAuthenticated()) {
            $accessToken = OAuth2Helper::refreshAndGetAccessToken();

            return Factory::createWithAccessToken($accessToken);
        }

        throw new \Exception('Please authorize via OAuth');
    }
	
	/**
	 * Start a session and store refresh token
	 */
	public function start_session() {
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if(!isset($_SESSION['tokens'])) {
			$_SESSION['tokens'] = [
				'refresh_token' => OAuth2Helper::getRefreshToken(),
				'expires_at' => ''
			];
		}
	}

	/**
	 * Check for URL params
	 */
	public function callback_check() {
		$this->start_session();

        if ( isset( $_GET['code'] ) ) {
			$this->oauth_callback();
		}

		// for testing
		if ( isset( $_GET['contacts_test'] ) ) {
			$this->contacts_test();
		}
		
		// if ( isset( $_GET['var_test'] ) ) {
		// 	$this->var_test();
		// }
	}

	// for testing
	public function var_test() {
		echo '<pre>';
		var_dump($_SESSION);
		echo '</pre>';
		exit;
	}

	/**
	 * Store token response
	 */
	public function oauth_callback() {
		$tokens = Factory::create()->auth()->oAuth()->tokensApi()->createToken(
			'authorization_code',
			$_GET['code'],
			OAuth2Helper::getRedirectUri(),
			OAuth2Helper::getClientId(),
			OAuth2Helper::getClientSecret()
		);
		
		OAuth2Helper::saveTokenResponse($tokens);

		if(isset($_SESSION['tokens'])) {
			echo 'Access token successfully stored.';
			exit;
		}
	}

	/**
	 * @param $order_id
	 *
	 * Upload pdf file from the order to hubspot
	 */
	public function upload_file( $order_id ) {
		$hubspot = $this->createFactory();

        if (ICL_LANGUAGE_CODE == 'us') {
            $file_name = 'ErgoPack-your-personal-system-configuration_';
        } elseif (ICL_LANGUAGE_CODE == 'en') {
            $file_name = 'ErgoPack-your-personal-system-configuration_';
        } else {
            $file_name = 'ErgoPack-Ihre-persoenliche-Systemkonfiguration_';
        }

		$site_url     = get_home_url();
		$file         = "$site_url/wp-content/uploads/pdfs/".$file_name."" . $order_id . ".pdf";
		$options	  = json_encode([
			'access' => 'PRIVATE',
		]);
		$folderPath   = '/docs';
		$fileName     = $file_name . $order_id . ".pdf";

		try {

			$file = $hubspot->files()->filesApi()->upload( $file, null, $folderPath, $fileName, null, $options );
			$file_id = $file['id'];
			
			do_action( 'ergo_run_engagement', $file_id, $order_id );

		} catch ( ClientException $e ) {
			$resp = $e->getResponse();
			throw $resp;
		}
	}

	/**
	 * Update deal price and change deal stage on order completed in WooCommerce
	 */
	public function deal_price_stage( $order_id ) {
		$hubspot = $this->createFactory();
		
		$order        = wc_get_order( $order_id );
		$dealId       = (int) get_post_meta( $order->get_id(), '_epp_vorgangsnummer', true );
		$the_subtotal = $order->get_total();
		
		$properties = [
			'amount' => $the_subtotal,
			'dealstage' => 'presentationscheduled',
			'pipeline' => 'default'
		];
		
		$simplePublicObjectInput = new SimplePublicObjectInput([
			'properties' => $properties,
		]);

		try {
			$hubspot->crm()->deals()->basicApi()->update( $dealId, $simplePublicObjectInput, null );
		} catch ( ClientException $e ) {
			$resp = $e->getResponse();
			throw $resp;
		}
	}

	/**
	 * Associate uploaded file with deal, contact and company
	 * 
	 * 1. Get company ID and contact ID associated to the deal ID.
	 * 2. Create a note with attached file.
	 * 3. Associate note to the deal, contact, and company.
	 */
	public function set_engagements( $file_Id, $order_id ) {
		$hubspot = $this->createFactory();

		$order         = wc_get_order( $order_id );
		$dealId        = (int) get_post_meta( $order->get_id(), '_epp_vorgangsnummer', true );
		$lTimeStampNow = round( microtime( true ) * 1000 );
		$noteDate      = date( "d.m.Y" );

		// Get company and contact ID
		$as_company    = $hubspot->apiRequest([
			'method' => 'GET',
			'path' => "/crm/v4/objects/deals/$dealId/associations/company",
		]);
		$as_contact    = $hubspot->apiRequest([
			'method' => 'GET',
			'path' => "/crm/v4/objects/deals/$dealId/associations/contact",
		]);

		$as_company_id = json_decode($as_company->getBody(), true)['results'][0]['toObjectId'];
		$as_contact_id = json_decode($as_contact->getBody(), true)['results'][0]['toObjectId'];

		// Create note with file attachment
		$body = [
			'properties' => [
				'hs_timestamp' => $lTimeStampNow,
				'hs_note_body' => "Angebotsdokument aus der DSP vom $noteDate",
				'hs_attachment_ids' => $file_Id
			]
		];
		$note = $hubspot->apiRequest([
			'method' => 'POST',
			'path' => '/crm/v3/objects/notes',
			'body' => $body
		]);

		$note_id = json_decode($note->getBody(), true)['id'];

		// Associate note to deal
		$from1 = new PublicObjectId([
			'id' => $note_id
		]);
		$to1 = new PublicObjectId([
			'id' => $dealId
		]);
		$publicAssociation1 = new PublicAssociation([
			'from' => $from1,
			'to' => $to1,
			'type' => 'note_to_deal'
		]);

		// Associate note to company
		$from2 = new PublicObjectId([
			'id' => $note_id
		]);
		$to2 = new PublicObjectId([
			'id' => $as_company_id
		]);
		$publicAssociation2 = new PublicAssociation([
			'from' => $from2,
			'to' => $to2,
			'type' => 'note_to_company'
		]);

		// Associate note to contact
		$from3 = new PublicObjectId([
			'id' => $note_id
		]);
		$to3 = new PublicObjectId([
			'id' => $as_contact_id
		]);
		$publicAssociation3 = new PublicAssociation([
			'from' => $from3,
			'to' => $to3,
			'type' => 'note_to_contact'
		]);

		// create batch association
		$batchInputPublicAssociation1 = new BatchInputPublicAssociation([
			'inputs' => [$publicAssociation1],
		]);
		$batchInputPublicAssociation2 = new BatchInputPublicAssociation([
			'inputs' => [$publicAssociation2],
		]);
		$batchInputPublicAssociation3 = new BatchInputPublicAssociation([
			'inputs' => [$publicAssociation3],
		]);

		try {
			$hubspot->crm()->associations()->batchApi()->create('note','deal',$batchInputPublicAssociation1);
			$hubspot->crm()->associations()->batchApi()->create('note','company',$batchInputPublicAssociation2);
			$hubspot->crm()->associations()->batchApi()->create('note','contact',$batchInputPublicAssociation3);
		} catch ( ClientException $e ) {
			$resp = $e->getResponse();
			throw $resp;
		}

	}

	/**
	 * Register endpoint for app Webhook
	 */
	public function create_endpoint() {
		register_rest_route( 'ergopack/v2', '/hubspot', array(
				'methods'  => \WP_REST_Server::CREATABLE,
				'callback' => [ &$this, 'create_user' ],
			)
		);
	}

	/**
	 * Endpoint callback
	 * 
	 * Creates a user on Wordpress from Hubspot
	 */
	public function create_user( $request_data ) {

		$parameters = $request_data->get_params();

		foreach ( $parameters as $parameter ) {

			try {
				$hubspot = $this->createFactory();
				$data = $hubspot->crm()->contacts()->basicApi()->getById( $parameter['objectId'], [
					'property' => [
						'associatedcompanyid',
						'firstname',
						'lastname',
						'email',
						'website',
						'phone',
						'address'
					]
				], null, null, false );

				$username   = $data->getProperties()['email'];
				$email      = $username;
				$first_name = $data->getProperties()['firstname'];
				$last_name  = $data->getProperties()['lastname'];
				$web_domain = $data->getProperties()['website'];
				$customer_phone = $data->getProperties()['phone'];
				$associated_company = $data->getProperties()['associatedcompanyid'];

				if ( email_exists( $email ) == false ) {
					$user_id = wp_insert_user( array(
						'user_login'   => $username,
						'user_pass'    => 'password',
						'user_email'   => $email,
						'first_name'   => $first_name,
						'last_name'    => $last_name,
						'display_name' => $first_name,
						'user_url'     => $web_domain,
						'role'         => 'customer',
					) );

					update_user_meta( $user_id, "billing_first_name", $first_name );
					update_user_meta( $user_id, "billing_last_name", $last_name );
					update_user_meta( $user_id, "billing_email", $email );
					update_user_meta( $user_id, "billing_phone", $customer_phone );

					$hubspot_company    = $this->createFactory();
					$prop = array(
						'name',
						'city',
						'zip',
						'state',
						'address',
						'country',
						'phone',
					);
					$company_properties = $hubspot_company->crm()->companies()->basicApi()->getById( $associated_company, $prop );

					$company_name = $company_properties->getProperties()['name'];
					$city         = $company_properties->getProperties()['city'];
					$zip          = $company_properties->getProperties()['zip'];
					$state        = $company_properties->getProperties()['state'];
					$address      = $company_properties->getProperties()['address'];
					$country      = $company_properties->getProperties()['country'];
					$phone        = $company_properties->getProperties()['phone'];

					update_user_meta( $user_id, "billing_company", $company_name );
					update_user_meta( $user_id, "billing_city", $city );
					update_user_meta( $user_id, "billing_postcode", $zip );
					update_user_meta( $user_id, "billing_state", $state );
					update_user_meta( $user_id, "billing_address_1", $address );
					update_user_meta( $user_id, "billing_country", $country );
				}
				
			} catch ( ClientException $e ) {
				$resp = $e->getResponse();
				throw $resp;
			}

		}
	}

	// for testing
	public function contacts_test() {
		$hubSpot = $this->createFactory();

		$contactsPage = $hubSpot->crm()->contacts()->basicApi()->getPage(99, null, null, null, null, false);

		?>
		<table class="contacts-list">
			<thead>
				<tr>
					<th>ID</th>
					<th>Email</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contactsPage->getResults() as $contact) { ?>
					<tr>
					<td><?php echo $contact->getId(); ?></td>
						<td><?php echo htmlentities($contact->getProperties()['email']); ?></td>
					<td><?php echo htmlentities($contact->getProperties()['firstname'].' '.$contact->getProperties()['lastname']); ?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
		<?php
		exit;
	}


}



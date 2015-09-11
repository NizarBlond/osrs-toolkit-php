<?php

namespace OpenSRS\backwardcompatibility\dataconversion\domains\provisioning;

use OpenSRS\backwardcompatibility\dataconversion\DataConversion;
use OpenSRS\Exception;

class ProvisioningModify extends DataConversion {
	// New structure for API calls handled by
	// the toolkit.
	//
	// index: field name
	// value: location of data to map to this
	//		  field from the original structure
	//
	// example 1:
	//    "cookie" => 'data->cookie'
	//	this will map ->data->cookie in the
	//	original object to ->cookie in the
	//  new format
	//
	// example 2:
	//	  ['attributes']['domain'] = 'data->domain'
	//  this will map ->data->domain in the original
	//  to ->attributes->domain in the new format
	protected $newStructure = array(
		'cookie' => 'data->cookie',

		'attributes' => array(
			'affect_domains' => 'data->affect_domains',
			'data' => 'data->data',
			'domain' => 'data->domain',
			'tld_data' => 'data->tld_data',

			'display' => 'data->display',
			'change_tag_all' => 'data->change_tag_all',
			'gaining_registrar_tag' => 'data->gaining_registrar_tag',
			'rsp_override' => 'data->rsp_override',
			'address1' => 'data->address1',
			'address2' => 'data->address2',
			'address3' => 'data->address3',
			'city' => 'data->city',
			'country' => 'data->country',
			'email' => 'data->email',
			'fax' => 'data->fax',
			'first_name' => 'data->first_name',
			'lang' => 'data->lang',
			'last_name' => 'data->last_name',
			'legal_type' => 'data->legal_type',
			'org_name' => 'data->org_name',
			'phone' => 'data->phone',
			'postal_code' => 'data->postal_code',
			'state' => 'data->state',

			/**
			 * $contact_types = explode( ",", data->contact_type ),
			 * contact_set = assoc array using $contact_types as
			 * indexes. each contact_types contains data->personal
			 */
			// 'contact_set' => '',

			'domain_auth_info' => 'data->domain_auth_info',
			'auto_renew' => 'data->auto_renew',
			'let_expire' => 'data->let_expire',
			'forwarding_email' => 'data->forwarding_email',
			'consent_for_publishing' => 'data->consent_for_publishing',
			'all' => 'data->all',
			'flag' => 'data->flag',
			'lock_state' => 'data->lock_state',
			'reg_type' => 'data->reg_type',
			'uk_affect_domains' => 'data->uk_affect_domains',
			'report_email' => 'data->report_email',
			),
		);

	public function convertDataObject( $dataObject, $newStructure = null ) {
		$p = new parent();

		if(is_null($newStructure)){
			$newStructure = $this->newStructure;
		}

		$newDataObject = $p->convertDataObject( $dataObject, $newStructure );

		// run customizations required by this particular class 
		$newDataObject->contact_set = new \stdClass;
		$contact_types = explode( ",", $dataObject->data->contact_type );

		foreach( $contact_types as $contact_type ) {
			$newDataObject->contact_set->{$contact_type} = $dataObject->personal;
		}
		// end customizations

		return $newDataObject;
	}
}
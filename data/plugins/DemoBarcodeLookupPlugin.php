<?php

use Grocy\Helpers\BaseBarcodeLookupPlugin;

class DemoBarcodeLookupPlugin extends BaseBarcodeLookupPlugin
{
	protected function ExecuteLookup($barcode)
	{
		$client = new GuzzleHttp\Client();
		$res = $client->get('https://world.openfoodfacts.org/api/v3/product/' . $barcode);

		if ($res->getStatusCode() !== 200) {
			return null;
		}
		$response = json_decode($res->getBody()->getContents(), true);
		return [
			'barcode' => $barcode,
			'name' => $response['product']['product_name'],
			'image' => $response['product']['image_front_url'],
			'location_id' => $this->Locations[0]->id,
			'qu_id_purchase' => $this->QuantityUnits[0]->id,
			'qu_id_stock' => $this->QuantityUnits[0]->id,
			'qu_factor_purchase_to_stock' => 1,
		];
	}
}

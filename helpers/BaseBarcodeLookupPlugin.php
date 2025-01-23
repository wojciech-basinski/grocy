<?php

namespace Grocy\Helpers;

abstract class BaseBarcodeLookupPlugin
{
	final public function __construct($locations, $quantityUnits)
	{
		$this->Locations = $locations;
		$this->QuantityUnits = $quantityUnits;
	}

	protected $Locations;
	protected $QuantityUnits;

	final public function Lookup($barcode)
	{
		$pluginOutput = $this->ExecuteLookup($barcode);

		if ($pluginOutput === null)
		{
			return $pluginOutput;
		}

		// Plugin must return an associative array
		if (!is_array($pluginOutput))
		{
			throw new \Exception('Plugin output must be an associative array');
		}

		if (!IsAssociativeArray($pluginOutput))
		{
			// $pluginOutput is at least an indexed array here
			throw new \Exception('Plugin output must be an associative array');
		}

		// Check for minimum needed properties
		$minimunNeededProperties = [
			'name',
			'barcode',
		];

		foreach ($minimunNeededProperties as $prop)
		{
			if (!array_key_exists($prop, $pluginOutput))
			{
				throw new \Exception("Plugin output does not provide needed property $prop");
			}
		}

		return $pluginOutput;
	}

	abstract protected function ExecuteLookup($barcode);
}

<?php

namespace Geos\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GeosUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}

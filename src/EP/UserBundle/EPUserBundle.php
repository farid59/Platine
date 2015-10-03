<?php

namespace EP\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EPUserBundle extends Bundle
{
	public function getParent() {
		return 'FOSUserBundle';
	}
}

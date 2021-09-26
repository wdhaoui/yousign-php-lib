<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Bridge\Symfony;

use Wdhaoui\Yousign\Bridge\Symfony\DependencyInjection\WdhaouiYousignExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class WdhaouiYousignBundle extends Bundle
{
    /**
     * {@inheritdoc}
     *
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new WdhaouiYousignExtension();
        }

        return $this->extension;
    }
}

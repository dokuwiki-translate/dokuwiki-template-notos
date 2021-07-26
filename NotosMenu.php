<?php

namespace dokuwiki\template\notos;

use dokuwiki\Menu\AbstractMenu;
use dokuwiki\Menu\Item\AbstractItem;

/**
 * Class NotosMenu
 * @package dokuwiki\template\notos
 */
class NotosMenu extends AbstractMenu
{

    /** @inheritdoc */
    public function __construct($name = 'notos')
    {
        parent::__construct();
        $this->view = $name;
    }

}

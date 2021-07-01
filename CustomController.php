<?php

namespace dokuwiki\template\notos;

use dokuwiki\template\twigstarter\CustomControllerInterface;
use dokuwiki\template\twigstarter\TemplateController;

/**
 * Notos custom methods
 */
class CustomController implements CustomControllerInterface
{
    protected $tpl;

    /** @inheritDoc */
    public function __construct(TemplateController $tpl)
    {
        $this->tpl = $tpl;
    }

    /**
     * Renders the navigational list items
     *
     * We only support two levels. Deeper levels that might be returned from the navigation
     * control page will simply be ignored here
     *
     * @return string
     */
    public function renderNavigation()
    {
        $controlPage = 'wiki:navigation'; // FIXME load from config;

        $pages = $this->parseNavigation($controlPage);

        $html = '<ul class="navtabs">';
        foreach ($pages as $page) {
            // fixme check if active
            $html .= '<li class="primary">';
            $html .= $this->navItemHTML($page);
            $html .= '</li>';

            // second level is a second item, because we reorder with flex box later
            if (isset($page['sub'])) {
                $html .= '<li class="inactive-content">';
                $html .= '<ul class="secondary">';
                $html .= $this->navItemHTML($page);
                $html .= '</ul>';
                $html .= '</li>';
            }
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Print a single Navigation Item
     *
     * @param $item
     * @return string
     */
    protected function navItemHTML($item)
    {
        if ($item['type'] == 'internal') {
            return html_wikilink($item['page'], $item['title']);
        }
        $attr = buildAttributes([
            'href' => $item['page'],
            'title' => $item['page'],
            'class' => 'external',
        ]);
        return "<a $attr>" . hsc($item['title']) . '</a>';
    }

    /**
     * Parses the given page for a nested, unordered list
     *
     * Returns the list as nested array
     *
     * @param string $controlPage
     * @return array
     * @todo This should have some tests
     */
    protected function parseNavigation($controlPage)
    {
        $instructions = p_cached_instructions(wikiFN($controlPage), false, $controlPage);

        $result = [];
        $pointers = [&$result]; // point to current list
        $pidx = 0; // index of last pointer

        foreach ($instructions as $instruction) {
            switch ($instruction[0]) {
                case 'listu_open':
                    // find index of last item in current list
                    $eidx = count($pointers[$pidx]) - 1;
                    // open a new list in the last item of the current list
                    $pointers[$pidx][$eidx]['sub'] = [];
                    // store that new list in the pointer stack
                    $pointers[] = &$pointers[$pidx][$eidx]['sub'];
                    // increase pointer index
                    $pidx++;
                    break;
                case 'listu_close':
                    // close a list
                    array_pop($pointers);
                    $pidx--;
                    break;
                case 'internallink':
                    // resolve ID
                    $page = resolve_id('', $instruction[1][0]);
                    // append to current list
                    $pointers[$pidx][] = [
                        'type' => 'internal',
                        'page' => $page,
                        'title' => $instruction[1][1],
                    ];
                    break;
                case 'externallink':
                    // append to current list
                    $pointers[$pidx][] = [
                        'type' => 'external',
                        'page' => $instruction[1][0],
                        'title' => $instruction[1][1],
                    ];
                    break;
            }
        }

        // clean up by moving everything up into a root array
        if (isset($result[-1])) {
            $result = $result[-1]['sub'];
        }

        return $result;
    }
}

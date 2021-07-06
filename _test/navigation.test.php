<?php

/**
 * @group tpl_notos
 * @group plugins
 */
class navigation_tpl_notos_test extends DokuWikiTest
{

    /**
     * Test parsing control page into navigation structure
     */
    public function test_templateinfo()
    {
        $file = __DIR__ . '/navigation.txt';

        $templateController = new \dokuwiki\template\twigstarter\TemplateController('main');
        $customController = new \dokuwiki\template\notos\CustomController($templateController);

        $actual = $customController->parseNavigation($file);

        $expected = [
            0 =>
                [
                    'type' => 'internal',
                    'page' => 'briefs:start',
                    'title' => 'Briefs',
                ],
            1 =>
                [
                    'type' => 'internal',
                    'page' => 'qhsr:start',
                    'title' => 'QHSR',
                    'sub' =>
                        [
                            0 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:q',
                                    'title' => 'Quality',
                                ],
                            1 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:cert',
                                    'title' => 'Certification',
                                ],
                            2 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:hse:start',
                                    'title' => 'HSE',
                                ],
                            3 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:engsystems',
                                    'title' => 'Eng Systems',
                                ],
                            4 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:performance',
                                    'title' => 'Eng Performance',
                                ],
                            5 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:competence',
                                    'title' => 'Eng Competence',
                                ],
                            6 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:ashford',
                                    'title' => 'Ashford DFO',
                                ],
                            7 =>
                                [
                                    'type' => 'internal',
                                    'page' => 'qhsr:training',
                                    'title' => 'Technical Training',
                                ],
                        ],
                ],
            2 =>
                [
                    'type' => 'internal',
                    'page' => 'tech:start',
                    'title' => 'Tech Info',
                ],
            3 =>
                [
                    'type' => 'external',
                    'page' => 'https://homepage.company.com',
                    'title' => 'Company Homepage',
                ],
        ];

        $this->assertEquals($expected, $actual);
    }
}

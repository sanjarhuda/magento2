<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     performance_tests
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Test\Performance\Testsuite;

class OptimizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\TestFramework\Performance\Testsuite\Optimizer
     */
    protected $_optimizer;

    protected function setUp()
    {
        $this->_optimizer = new \Magento\TestFramework\Performance\Testsuite\Optimizer;
    }

    protected function tearDown()
    {
        unset($this->_optimizer);
    }

    /**
     * @param array $fixtureSets
     * @param array $expected
     * @dataProvider optimizeFixtureSetsDataProvider
     */
    public function testOptimizeFixtureSets($fixtureSets, $expected)
    {
        $optimized = $this->_optimizer->optimizeFixtureSets($fixtureSets);
        $this->assertEquals($optimized, $expected);
    }

    /**
     * @return array
     */
    public function optimizeFixtureSetsDataProvider()
    {
        return array(
            'empty_list' => array(
                'fixtureSets' => array(),
                'expected' => array(),
            ),
            'single_scenario' => array(
                'fixtureSets' => array(
                    'a' => array('f1', 'f2')
                ),
                'expected' => array('a'),
            ),
            'empty_fixtures' => array(
                'fixtureSets' => array(
                    'a' => array(),
                    'b' => array()
                ),
                'expected' => array('a', 'b'),
            ),
            'from_smaller_to_bigger' => array(
                'fixtureSets' => array(
                    'a' => array('f1', 'f2'),
                    'b' => array('f2'),
                    'c' => array('f3')
                ),
                'expected' => array('b', 'a', 'c'),
            ),
            'same_together' => array(
                'fixtureSets' => array(
                    'a' => array('f1', 'f2'),
                    'b' => array('f1'),
                    'c' => array('f1'),
                ),
                'expected' => array('b', 'c', 'a'),
            )
        );
    }
}

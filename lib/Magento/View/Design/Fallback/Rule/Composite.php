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
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Composite rule that represents sequence of child fallback rules
 */
namespace Magento\View\Design\Fallback\Rule;

/**
 * Composite Rules
 *
 * @package Magento\View
 */
class Composite implements RuleInterface
{
    /**
     * @var RuleInterface[]
     */
    protected $rules = array();

    /**
     * Constructor
     *
     * @param RuleInterface[] $rules
     * @throws \InvalidArgumentException
     */
    public function __construct(array $rules)
    {
        foreach ($rules as $rule) {
            if (!($rule instanceof RuleInterface)) {
                throw new \InvalidArgumentException('Each item should implement the fallback rule interface.');
            }
        }
        $this->rules = $rules;
    }

    /**
     * Retrieve sequentially combined directory patterns from child fallback rules
     *
     * {@inheritdoc}
     */
    public function getPatternDirs(array $params)
    {
        $result = array();
        foreach ($this->rules as $rule) {
            $result = array_merge($result, $rule->getPatternDirs($params));
        }
        return $result;
    }
}

<?php

namespace PhpSchool\BackToBasics\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * Class RequiredNodeVisitor
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class RequiredNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var string[]
     */
    private $requiredNodes = [];

    /**
     * @var string[]
     */
    private $usedRequiredNodes = [];

    /**
     * @param string[] $requiredNodes
     */
    public function __construct(array $requiredNodes)
    {
        $this->requiredNodes = $requiredNodes;
    }

    /**
     * @return bool
     */
    public function hasUsedRequiredNodes()
    {
        return count(array_diff($this->requiredNodes, $this->usedRequiredNodes)) === 0;
    }

    /**
     * @param Node $node
     * @return void
     */
    public function leaveNode(Node $node)
    {
        if (in_array(get_class($node), $this->requiredNodes)) {
            $this->usedRequiredNodes[] = get_class($node);
        }
    }
}

<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Twig\NodeVisitor\NodeVisitorInterface;
/**
 * A node traverser.
 *
 * It visits all nodes and their children and calls the given visitor for each.
 *
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class NodeTraverser
{
    protected $env;
    protected $visitors = [];
    /**
     * @param NodeVisitorInterface[] $visitors
     */
    public function __construct(\MailPoetVendor\Twig\Environment $env, array $visitors = [])
    {
        $this->env = $env;
        foreach ($visitors as $visitor) {
            $this->addVisitor($visitor);
        }
    }
    public function addVisitor(\MailPoetVendor\Twig\NodeVisitor\NodeVisitorInterface $visitor)
    {
        $this->visitors[$visitor->getPriority()][] = $visitor;
    }
    /**
     * Traverses a node and calls the registered visitors.
     *
     * @return \Twig_NodeInterface
     */
    public function traverse(\MailPoetVendor\Twig_NodeInterface $node)
    {
        \ksort($this->visitors);
        foreach ($this->visitors as $visitors) {
            foreach ($visitors as $visitor) {
                $node = $this->traverseForVisitor($visitor, $node);
            }
        }
        return $node;
    }
    protected function traverseForVisitor(\MailPoetVendor\Twig\NodeVisitor\NodeVisitorInterface $visitor, \MailPoetVendor\Twig_NodeInterface $node = null)
    {
        if (null === $node) {
            return;
        }
        $node = $visitor->enterNode($node, $this->env);
        foreach ($node as $k => $n) {
            if (null === $n) {
                continue;
            }
            if (\false !== ($m = $this->traverseForVisitor($visitor, $n)) && null !== $m) {
                if ($m !== $n) {
                    $node->setNode($k, $m);
                }
            } else {
                $node->removeNode($k);
            }
        }
        return $visitor->leaveNode($node, $this->env);
    }
}
\class_alias('MailPoetVendor\\Twig\\NodeTraverser', 'MailPoetVendor\\Twig_NodeTraverser');

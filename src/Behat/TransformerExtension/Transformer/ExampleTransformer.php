<?php
/**
 * User: Tom
 */

namespace Behat\TransformerExtension\Transformer;

use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer;
use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Class ExampleTransformer
 *
 * @package Behat\TransformerExtension\Transformer
 */
class ExampleTransformer implements ArgumentTransformer
{
    /**
     * Checks if transformer supports argument.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return Boolean
     */
    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        return !is_object($argumentValue) || $argumentValue instanceof ArgumentInterface;
    }

    /**
     * Transforms argument value using transformation and returns a new one.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return mixed
     */
    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        if ($argumentValue instanceof TableNode) {
            return $this->transformTableNode($argumentValue);
        }
        if ($argumentValue instanceof PyStringNode) {
            return $this->transformPyString($argumentValue);
        }
        if (is_array($argumentValue)) {
            return $this->transformArray($argumentValue);
        }

        return $this->transformString($argumentValue);
    }

    /**
     * @param TableNode $table
     * @return TableNode
     */
    protected function transformTableNode(TableNode $table)
    {
        $tempList = $table->getTable();
        foreach ($tempList as $key => $row) {
            foreach ($row as $columnKey => $column) {
                $tempList[$key][$columnKey] = 'transformation';
            }
        }
        return new TableNode($tempList);
    }

    /**
     * @param PyStringNode $pyString
     * @return PyStringNode
     */
    protected function transformPyString(PyStringNode $pyString)
    {
        return new PyStringNode('transformation', 1);
    }

    /**
     * @param array $array
     * @return array
     */
    protected function transformArray(array $array)
    {
        $temp = [];
        foreach ($array as $key => $value) {
            $temp[$key] = 'transformation';
        }

        return $temp;
    }

    /**
     * @param $sting
     * @return string
     */
    protected function transformString($sting)
    {
        return 'transformation';
    }

}

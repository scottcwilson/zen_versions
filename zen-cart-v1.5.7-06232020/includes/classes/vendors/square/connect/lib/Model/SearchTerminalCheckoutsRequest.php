<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * SearchTerminalCheckoutsRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 * Note: This endpoint is in beta.
 */
class SearchTerminalCheckoutsRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'query' => '\SquareConnect\Model\TerminalCheckoutQuery',
        'cursor' => 'string',
        'limit' => 'int'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'query' => 'query',
        'cursor' => 'cursor',
        'limit' => 'limit'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'query' => 'setQuery',
        'cursor' => 'setCursor',
        'limit' => 'setLimit'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'query' => 'getQuery',
        'cursor' => 'getCursor',
        'limit' => 'getLimit'
    );
  
    /**
      * $query Query the terminal checkouts based on given conditions and sort order. Calling SearchTerminalCheckouts without an explicitly query parameter will return all available checkouts with the default sort order.
      * @var \SquareConnect\Model\TerminalCheckoutQuery
      */
    protected $query;
    /**
      * $cursor A pagination cursor returned by a previous call to this endpoint. Provide this to retrieve the next set of results for the original query.
      * @var string
      */
    protected $cursor;
    /**
      * $limit Limit the number of results returned for a single request.
      * @var int
      */
    protected $limit;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["query"])) {
              $this->query = $data["query"];
            } else {
              $this->query = null;
            }
            if (isset($data["cursor"])) {
              $this->cursor = $data["cursor"];
            } else {
              $this->cursor = null;
            }
            if (isset($data["limit"])) {
              $this->limit = $data["limit"];
            } else {
              $this->limit = null;
            }
        }
    }
    /**
     * Gets query
     * @return \SquareConnect\Model\TerminalCheckoutQuery
     */
    public function getQuery()
    {
        return $this->query;
    }
  
    /**
     * Sets query
     * @param \SquareConnect\Model\TerminalCheckoutQuery $query Query the terminal checkouts based on given conditions and sort order. Calling SearchTerminalCheckouts without an explicitly query parameter will return all available checkouts with the default sort order.
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
    /**
     * Gets cursor
     * @return string
     */
    public function getCursor()
    {
        return $this->cursor;
    }
  
    /**
     * Sets cursor
     * @param string $cursor A pagination cursor returned by a previous call to this endpoint. Provide this to retrieve the next set of results for the original query.
     * @return $this
     */
    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
        return $this;
    }
    /**
     * Gets limit
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
  
    /**
     * Sets limit
     * @param int $limit Limit the number of results returned for a single request.
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}

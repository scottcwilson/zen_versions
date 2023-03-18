<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * CreateDisputeEvidenceTextRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 * Note: This endpoint is in beta.
 */
class CreateDisputeEvidenceTextRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'idempotency_key' => 'string',
        'evidence_type' => 'string',
        'evidence_text' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'idempotency_key' => 'idempotency_key',
        'evidence_type' => 'evidence_type',
        'evidence_text' => 'evidence_text'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'idempotency_key' => 'setIdempotencyKey',
        'evidence_type' => 'setEvidenceType',
        'evidence_text' => 'setEvidenceText'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'idempotency_key' => 'getIdempotencyKey',
        'evidence_type' => 'getEvidenceType',
        'evidence_text' => 'getEvidenceText'
    );
  
    /**
      * $idempotency_key Unique ID. For more information, see [Idempotency](https://developer.squareup.com/docs/docs/working-with-apis/idempotency).
      * @var string
      */
    protected $idempotency_key;
    /**
      * $evidence_type The type of evidence you are uploading. See [DisputeEvidenceType](#type-disputeevidencetype) for possible values
      * @var string
      */
    protected $evidence_type;
    /**
      * $evidence_text The evidence string.
      * @var string
      */
    protected $evidence_text;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["idempotency_key"])) {
              $this->idempotency_key = $data["idempotency_key"];
            } else {
              $this->idempotency_key = null;
            }
            if (isset($data["evidence_type"])) {
              $this->evidence_type = $data["evidence_type"];
            } else {
              $this->evidence_type = null;
            }
            if (isset($data["evidence_text"])) {
              $this->evidence_text = $data["evidence_text"];
            } else {
              $this->evidence_text = null;
            }
        }
    }
    /**
     * Gets idempotency_key
     * @return string
     */
    public function getIdempotencyKey()
    {
        return $this->idempotency_key;
    }
  
    /**
     * Sets idempotency_key
     * @param string $idempotency_key Unique ID. For more information, see [Idempotency](https://developer.squareup.com/docs/docs/working-with-apis/idempotency).
     * @return $this
     */
    public function setIdempotencyKey($idempotency_key)
    {
        $this->idempotency_key = $idempotency_key;
        return $this;
    }
    /**
     * Gets evidence_type
     * @return string
     */
    public function getEvidenceType()
    {
        return $this->evidence_type;
    }
  
    /**
     * Sets evidence_type
     * @param string $evidence_type The type of evidence you are uploading. See [DisputeEvidenceType](#type-disputeevidencetype) for possible values
     * @return $this
     */
    public function setEvidenceType($evidence_type)
    {
        $this->evidence_type = $evidence_type;
        return $this;
    }
    /**
     * Gets evidence_text
     * @return string
     */
    public function getEvidenceText()
    {
        return $this->evidence_text;
    }
  
    /**
     * Sets evidence_text
     * @param string $evidence_text The evidence string.
     * @return $this
     */
    public function setEvidenceText($evidence_text)
    {
        $this->evidence_text = $evidence_text;
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

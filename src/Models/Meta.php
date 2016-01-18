<?php

namespace Silk\Models;

use Illuminate\Support\Collection;

class Meta
{
    /**
     * Meta type
     * @var string
     */
    protected $type;

    /**
     * @param string     $type      Meta type
     * @param int|string $object_id ID of the object metadata is for
     * @param string     $key       [description]
     */
    public function __construct($type, $object_id, $key = '')
    {
        $this->type      = $type;
        $this->object_id = $object_id;
        $this->key       = $key;
    }

    /**
     * Get the meta data
     *
     * @return mixed
     */
    public function get()
    {
        if ( ! $this->key) {
            return $this->all();
        }

        return get_metadata($this->type, $this->object_id, $this->key, true);
    }

    /**
     * Get all meta data
     *
     * @return Collection
     */
    public function all()
    {
        return Collection::make(get_metadata($this->type, $this->object_id, $this->key, false));
    }

    /**
     * Set the meta value
     *
     * @param mixed  $value
     * @param string $prev_value [description]
     * @return bool              True on success, false on failure
     */
    public function set($value, $prev_value = '')
    {
        return update_metadata($this->type, $this->object_id, $this->key, $value, $prev_value);
    }

    /**
     * Add metadata for the specified object
     *
     * @param mixed  $value  The value to add
     * @param [type] $unique [description]
     *
     * @return int|false The meta ID on success, false on failure.
     */
    public function add($value, $unique = false)
    {
        return add_metadata($this->type, $this->object_id, $this->key, $value, $unique);
    }

    /**
     * Delete the meta data
     *
     * Deletes all meta data for the key, if provided, optionally filtered by
     * a previous value.
     * If no key was provided, all meta data for the object is deleted.
     *
     * @param  string $value The old value to delete.
     *                       This is only necessary when deleting a specific value
     *                       from an object which has multiple values for the key.
     *
     * @return bool              True on success, false on failure
     */
    public function delete($value = '')
    {
        return delete_metadata($this->type, $this->object_id, $this->key, $value);
    }

    /**
     * Determine if a meta key is set for a given object
     *
     * @return bool     True of the key is set, false if not.
     */
    public function exists()
    {
        return metadata_exists($this->type, $this->object_id, $this->key);
    }
}

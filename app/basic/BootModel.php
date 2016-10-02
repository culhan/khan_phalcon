<?php

class BootModel extends \Phalcon\Mvc\Model
{
	/**
	 * [list of all fillable column]
	 * @var array
	 */
    protected $fillable = [];

    public function getFillable()
    {
    	return $this->fillable;
    }

    public function initialize()
    {
		$this->addBehavior(new \Phalcon\Mvc\Model\Behavior\SoftDelete(
			array(
				'field' => 'deleted_at',
				'value' => date('Y-m-d H:i:s')
			)
		));
    }

    public function validation()
    {
    	// Example if custom validation
        // if ($this->email != 'amal') {        
        //     $this->appendMessage(
        //         new Message("The year cannot be less than zero")
        //     );
        // }
        
    	if( !$this->validate($this->validator) || $this->validationHasFailed())
        {
            return false;
        }

        return true;
    }

    /**
     * [add param before]
     */
    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = date("Y-m-d H:i:s");
    }

    /**
     * [add param before]
     */
    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = date("Y-m-d H:i:s");
    }

    /**
     * [add param before]
     */
    public function beforeDelete()
    {
    	// Set the deletion date
        
    }

    /**
     * [getDeleted column]
     * @return [type] [description]
     */
    public static function getDeleted()
    {
        return 'deleted_at';
    }

    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function find($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);

        return parent::find($parameters);
    }

    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return Phalcon\Mvc\Model
     */
    public static function findFirst($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);

        return parent::findFirst($parameters);
    }

    /**
     * @inheritdoc
     *
     * @access public
     * @static
     * @param array|string $parameters Query parameters
     * @return mixed
     */
    public static function count($parameters = null)
    {
        $parameters = self::softDeleteFetch($parameters);

        return parent::count($parameters);
    }

    /**
     * @access protected
     * @static
     * @param array|string $parameters Query parameters
     * @return mixed
     */
    public static function softDeleteFetch($parameters = null)
    {
        if (method_exists(get_called_class(), 'getDeleted') === false) {
            return $parameters;
        }

        $deletedField = call_user_func([get_called_class(), 'getDeleted']);

        if ($parameters === null) {
            $parameters = $deletedField . ' IS NULL ';
        } elseif (
            is_array($parameters) === false &&
            strpos($parameters, $deletedField) === false
        ) {
            $parameters .= ' AND ' . $deletedField . ' IS NULL ';
        } elseif (is_array($parameters) === true) {
            if (
                isset($parameters[0]) === true &&
                strpos($parameters[0], $deletedField) === false
            ) {
                $parameters[0] .= ' AND ' . $deletedField . ' IS NULL ';
            } elseif (
                isset($parameters['conditions']) === true &&
                strpos($parameters['conditions'], $deletedField) === false
            ) {
                $parameters['conditions'] .= ' AND ' . $deletedField . ' IS NULL ';
            }
        }

        return $parameters;
    }
}

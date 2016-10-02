<?php

class BootModel extends \Phalcon\Mvc\Model
{
    protected $fillable = [];

    public function getFillable()
    {
    	return $this->fillable;
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

    public function beforeCreate()
    {
        // Set the creation date
        $this->created_at = date("Y-m-d H:i:s");
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function beforeDelete()
    {
    	// Set the modification date
        $this->deleted_at = date("Y-m-d H:i:s");
    }
}

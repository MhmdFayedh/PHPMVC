<?php 

namespace app\core\Form;

use app\core\Model;

class Field 
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_EMAIL = 'email';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';
    public const TYPE_TIME = 'time';

    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct($model, $attribute )
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }


    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="form-control%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ', 
        $this->model->getLables($this->attribute),
        $this->type,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute)? " is-invalid": '' ,
        $this->model->getFirstError($this->attribute)

    );
    }

    public function passwordFiled(){
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
    

    
    public function emailFiled(){
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    
    public function dateFiled(){
        $this->type = self::TYPE_DATE;
        return $this;
    }

    
    public function timeFiled(){
        $this->type = self::TYPE_TIME;
        return $this;
    }

}
<?php 

namespace app\core;



abstract class Model 
{
    public array $errors = [];
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';


    ## This method will load data for any model in the system
    public function loadData($data)
    {
        foreach ($data as $key => $value)
        {
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }

    }
    

    ## The models must declaer rules method [That corresponding with RULES CONST ABOVE]
    public abstract function rules():array;
    
    ## Lables mothed to change labels from attribute to user friendly lables [By default will retrun empty array]

    public function labels(): array
    {
        return [];
    }

    public function getLables($attrbuite)
    {
        return $this->labels()[$attrbuite] ?? $attrbuite;
    }

    /**
     * 
     * ## This method will validate each rule that declaer in the main model
     * 
     * RULE_REQUIRED => if there is no value on the filed will add error in the errors array
     * RULE_EMAIL => This rule will check if it's an email or not
     * RULE_MIN & RULE_MAX => These rules will check for its min value or max value
     * RULE_UNIQUE  => This rule will check if it's a unique filed or not 
     */
    public function validate()
    {
        foreach($this->rules() as $attribute => $rules)
        {
            $value = $this->{$attribute};
            foreach($rules as $rule)
            {
                $ruleName = $rule;
                if(!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }
                ##  
                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $rule['match'] = $this->getLables($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $stmt =Application::$app->DB->prapare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();
                    $record = $stmt->fetchObject();

                    if($record){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ["filed" => $this->getLables($attribute)]);
                    }


                }
            }
        }
        
        return empty($this->errors);
    }
    

    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $msg = $this->errorMesages()[$rule] ?? '';
        foreach($params as $key => $value)
        {
            $msg = str_replace("{{$key}}", $value, $msg);
        }
        $this->errors[$attribute][] = $msg;
    }


    public function addError(string $attribute, string $msg)
    {
        $this->errors[$attribute][] = $msg;
    }


    public function errorMesages()
    {
        return [
            self::RULE_REQUIRED => 'Sorry, this field is required',
            self::RULE_EMAIL => 'Sorry, this field is not valid email address',
            self::RULE_MIN => 'Sorry, minimum length of this field must be {min}',
            self::RULE_MAX => 'Sorry, maximum length of this field must be {max}',
            self::RULE_MATCH => 'Sorry, this field must be the same as {match}',
            self::RULE_UNIQUE => 'Sorry, this {filed} is already exists',

        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

}
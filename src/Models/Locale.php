<?php

namespace Neondigital\LaravelLocale\Models;

class Locale
{
    protected $prefix;
    protected $name;
    protected $language_code;
    protected $country_code;
    protected $flag;
    protected $alternatives = [];
    protected $group;

    public function __construct($prefix, $data)
    {
        $this->setPrefix($prefix);
        $this->setName($data['name']);
        $this->setLanguageCode($data['language_code']);
        $this->setCountryCode($data['country_code']);
        $this->setFlag($data['flag']);

        if (isset($data['alternatives'])) {
            $this->setAlternatives($data['alternatives']);
        }

        if (isset($data['group'])) {
            $this->setGroup($data['group']);
        }
    }

    /**
    * Gets the value of prefix.
    *
    * @return mixed
    */
    public function getPrefix()
    {
        return $this->prefix;
    }
     
    /**
    * Sets the value of prefix.
    *
    * @param mixed $prefix the prefix
    *
    * @return self
    */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
     
    /**
    * Gets the value of name.
    *
    * @return mixed
    */
    public function getName()
    {
        return $this->name;
    }
     
    /**
    * Sets the value of name.
    *
    * @param mixed $name the name
    *
    * @return self
    */
    public function setName($name)
    {
        $this->name = $name;
    }
     
    /**
    * Gets the value of language_code.
    *
    * @return mixed
    */
    public function getLanguageCode()
    {
        return $this->language_code;
    }
     
    /**
    * Sets the value of language_code.
    *
    * @param mixed $language_code the language code
    *
    * @return self
    */
    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;
    }
     
    /**
    * Gets the value of country_code.
    *
    * @return mixed
    */
    public function getCountryCode()
    {
        return $this->country_code;
    }
     
    /**
    * Sets the value of country_code.
    *
    * @param mixed $country_code the country code
    *
    * @return self
    */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }
     
    /**
    * Gets the value of flag.
    *
    * @return mixed
    */
    public function getFlag()
    {
        return $this->flag;
    }
     
    /**
    * Sets the value of flag.
    *
    * @param mixed $flag the flag
    *
    * @return self
    */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }
     
    /**
    * Gets the value of alternatives.
    *
    * @return mixed
    */
    public function getAlternatives()
    {
        return $this->alternatives;
    }
     
    /**
    * Sets the value of alternatives.
    *
    * @param mixed $alternatives the alternatives
    *
    * @return self
    */
    public function setAlternatives($alternatives)
    {
        $this->alternatives = $alternatives;
    }
     
    /**
    * Gets the value of group.
    *
    * @return mixed
    */
    public function getGroup()
    {
        return $this->group;
    }
     
    /**
    * Sets the value of group.
    *
    * @param mixed $group the group
    *
    * @return self
    */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    public function getLocaleCode($separator = "-")
    {
        $localeCode = $this->getLanguageCode();

        if ($this->getCountryCode()) {
            $localeCode .= $separator . $this->getCountryCode();
        }
    
        return $localeCode;
    }
}

<?php
 \Patchwork\Interceptor\applyScheduledPatches();
/**
 * Ruckusing
 *
 * @category  Ruckusing
 * @package   Ruckusing_Adapter
 * @author    Cody Caughlan <codycaughlan % gmail . com>
 * @link      https://github.com/ruckus/ruckusing-migrations
 */

/**
 * Ruckusing_Adapter_ColumnDefinition
 *
 * @category Ruckusing
 * @package  Ruckusing_Adapter
 * @author   Cody Caughlan <codycaughlan % gmail . com>
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
class Ruckusing_Adapter_ColumnDefinition
{
    /**
     * adapter
     *
     * @var Ruckusing_Adapter_Base
     */

    private $_adapter;

    /**
     * name
     *
     * @var string
     */
    public $name;

    /**
     * type
     *
     * @var mixed
     */
    public $type;

    /**
     * properties
     *
     * @var mixed
     */
    public $properties;

    /**
     * options
     *
     * @var array
     */
    private $_options = array();

    /**
     * Creates an instance of Ruckusing_Adapter_ColumnDefinition
     *
     * @param Ruckusing_Adapter_Base $adapter The current adapter
     * @param string                 $name    the name of the column
     * @param string                 $type    the type of the column
     * @param array                  $options the column options
     *
     * @return Ruckusing_Adapter_ColumnDefinition
     */
    public function __construct($adapter, $name, $type, $options = array())
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if (!($adapter instanceof Ruckusing_Adapter_Base)) {
            throw new Ruckusing_Exception(
                    'Invalid Adapter instance.',
                    Ruckusing_Exception::INVALID_ADAPTER
            );
        }
        if (empty($name) || !is_string($name)) {
            throw new Ruckusing_Exception(
                    "Invalid 'name' parameter",
                    Ruckusing_Exception::INVALID_ARGUMENT
            );
        }
        if (empty($type) || !is_string($type)) {
            throw new Ruckusing_Exception(
                    "Invalid 'type' parameter",
                    Ruckusing_Exception::INVALID_ARGUMENT
            );
        }

        $this->_adapter = $adapter;
        $this->name = $name;
        $this->type = $type;
        $this->_options = $options;
    }

    /**
     * sql version
     *
     * @return string
     */
    public function to_sql()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $column_sql = sprintf("%s %s", $this->_adapter->identifier($this->name), $this->sql_type());
        $column_sql .= $this->_adapter->add_column_options($this->type, $this->_options);

        return $column_sql;
    }

    /**
     * sql string version
     *
     * @return string
     */
    public function __toString()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        return $this->to_sql();
    }

    /**
     * sql version
     *
     * @return string
     */
    private function sql_type()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        return $this->_adapter->type_to_sql($this->type, $this->_options);
    }
}\Patchwork\Interceptor\applyScheduledPatches();

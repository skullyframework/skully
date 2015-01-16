<?php
 \Patchwork\Interceptor\applyScheduledPatches();/**
 * Smarty Internal Plugin Compile Nocache
 *
 * Compiles the {nocache} {/nocache} tags.
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
 */

/**
 * Smarty Internal Plugin Compile Nocache Classv
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Nocache extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {nocache} tag
     *
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     * @return bool
     */
    public function compile($args, $compiler)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $_attr = $this->getAttributes($compiler, $args);
        if ($_attr['nocache'] === true) {
            $compiler->trigger_template_error('nocache option not allowed', $compiler->lex->taglineno);
        }
        // enter nocache mode
        $compiler->nocache = true;
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }

}\Patchwork\Interceptor\applyScheduledPatches();

/**
 * Smarty Internal Plugin Compile Nocacheclose Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Nocacheclose extends Smarty_Internal_CompileBase
{
    /**
     * Compiles code for the {/nocache} tag
     *
     * This tag does not generate compiled output. It only sets a compiler flag.
     *
     * @param  array  $args     array with attributes from parser
     * @param  object $compiler compiler object
     * @return bool
     */
    public function compile($args, $compiler)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $_attr = $this->getAttributes($compiler, $args);
        // leave nocache mode
        $compiler->nocache = false;
        // this tag does not return compiled code
        $compiler->has_code = false;

        return true;
    }

}\Patchwork\Interceptor\applyScheduledPatches();

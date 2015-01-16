<?php  \Patchwork\Interceptor\applyScheduledPatches();/*%%SmartyHeaderCode:855654b7b5372644a0-81065951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0731c0942e840d7e13cf9883b9fe3b527ac9e7ec' => 
    array (
      0 => 'D:\\apache\\skully\\Skully\\Tests\\App\\public\\default\\App\\views\\test\\testNoCache.tpl',
      1 => 1421325623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '855654b7b5372644a0-81065951',
  'variables' => 
  array (
    'test' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54b7b537297b90_37563468',
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b7b537297b90_37563468')) {function content_54b7b537297b90_37563468($_smarty_tpl) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);?><?php echo $_smarty_tpl->tpl_vars['test']->value;?>
<?php }} ?>

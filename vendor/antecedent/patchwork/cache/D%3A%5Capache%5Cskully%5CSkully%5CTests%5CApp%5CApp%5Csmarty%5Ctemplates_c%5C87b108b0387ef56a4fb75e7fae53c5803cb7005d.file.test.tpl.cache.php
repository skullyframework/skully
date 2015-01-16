<?php  \Patchwork\Interceptor\applyScheduledPatches();/* Smarty version Smarty-3.1.18, created on 2015-01-15 19:40:23
         compiled from "D:\apache\skully\Skully\Tests\App\public\default\App\views\test\test.tpl" */ ?>
<?php /*%%SmartyHeaderCode:783354b7b4d63ab416-23256620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87b108b0387ef56a4fb75e7fae53c5803cb7005d' => 
    array (
      0 => 'D:\\apache\\skully\\Skully\\Tests\\App\\public\\default\\App\\views\\test\\test.tpl',
      1 => 1421325623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '783354b7b4d63ab416-23256620',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54b7b5370f18e1_51086756',
  'variables' => 
  array (
    'test' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b7b5370f18e1_51086756')) {function content_54b7b5370f18e1_51086756($_smarty_tpl) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);?><?php echo $_smarty_tpl->tpl_vars['test']->value;?>
<?php }} ?>

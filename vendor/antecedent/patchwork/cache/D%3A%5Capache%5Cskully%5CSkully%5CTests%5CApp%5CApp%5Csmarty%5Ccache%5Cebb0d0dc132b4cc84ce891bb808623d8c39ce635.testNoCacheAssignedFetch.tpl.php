<?php  \Patchwork\Interceptor\applyScheduledPatches();/*%%SmartyHeaderCode:2114254b7b53759bf20-59966215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebb0d0dc132b4cc84ce891bb808623d8c39ce635' => 
    array (
      0 => 'D:\\apache\\skully\\Skully\\Tests\\App\\public\\default\\App\\views\\test\\testNoCacheAssignedFetch.tpl',
      1 => 1421325623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2114254b7b53759bf20-59966215',
  'variables' => 
  array (
    'content' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54b7b53764a715_82119677',
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b7b53764a715_82119677')) {function content_54b7b53764a715_82119677($_smarty_tpl) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);?><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
<?php }} ?>

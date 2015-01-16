<?php  \Patchwork\Interceptor\applyScheduledPatches();/*%%SmartyHeaderCode:988954b7b537448935-45414899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bb22639cef010ca9fdf9d1f52ff0f37c468e2c6' => 
    array (
      0 => 'D:\\apache\\skully\\Skully\\Tests\\App\\public\\default\\App\\views\\home\\index.tpl',
      1 => 1421325623,
      2 => 'file',
    ),
    '8011c0647ff1b4474351d2acd7ed6644149c2c38' => 
    array (
      0 => 'D:\\apache\\skully\\Skully\\Tests\\App\\public\\default\\App\\views\\test\\_mainWrapper.tpl',
      1 => 1421325623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '988954b7b537448935-45414899',
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54b7b5374838b4_26822113',
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b7b5374838b4_26822113')) {function content_54b7b5374838b4_26822113($_smarty_tpl) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);?>Content is <?php echo $_smarty_tpl->tpl_vars['test']->value;?>
<?php }} ?>

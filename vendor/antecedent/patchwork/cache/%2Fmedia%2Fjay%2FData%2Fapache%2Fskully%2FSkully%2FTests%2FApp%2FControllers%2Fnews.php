<?php
/*-------------------------------------------------\
 * Created by TrioDesign Team (jay@tgitriodesign.com).
 * Date: 1/28/14
 * Time: 1:48 PM
 * 
 \------------------------------------------------*/

namespace App\Controllers; \Patchwork\Interceptor\applyScheduledPatches();


class NewsController extends \App\Controllers\BaseController {
    public function index()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);}
}\Patchwork\Interceptor\applyScheduledPatches();
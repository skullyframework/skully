<?php
namespace Skully\Tests; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\App\Helpers\FileHelper;
use \Skully\Application;
use Skully\Core\Config;

require_once('App/include.php');

class TemplateTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Application
     */
    protected $app;

    protected function getApp()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config = new Config();
        $config->setProtectedFromArray(array(
            'publicDir' => 'public/',
            'caching' => 1,
            'theme' => 'test',
            'basePath' => realpath(__DIR__.DIRECTORY_SEPARATOR.'App').DIRECTORY_SEPARATOR,
            'baseUrl' => 'http://localhost/skully/',
            'languages' => array('en' => array('value' => 'english', 'code' => 'en')),
            'urlRules' => array(
                '' => 'home/index',
                'admin' => 'admin/home/index'
            ),
            'namespace' => 'App'
        ));
        return new \App\Application($config);
    }

    public function testDeleteCache()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        $additionalTestDir = __DIR__.'/App/anotherpublic/App/views/test';
        if (!file_exists($additionalTestDir)) {
            mkdir($additionalTestDir, 0777, true);
        }

        file_put_contents($appTestDir.'/test.tpl', '{$test}');
        file_put_contents($additionalTestDir.'/test.tpl', '{$test}');
        $app->getTheme()->setDir(realpath(__DIR__.'/App/anotherpublic'), 'plugin');
        $app->getTemplateEngine()->assign('test', 'halo');
        ob_start();

        $app->runControllerFromRawUrl('test/test');
        $output = ob_get_clean();
        echo $output . "\n";
        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        ob_start();
        $app->runControllerFromRawUrl('test/test');
        $output = ob_get_clean();
        echo "output 1: " . $output . "\n";

        // Cache not deleted, so it should still display the first value.
        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');

        // Deleting the cache here.
        $dir = __DIR__.'/App/App/smarty';
        FileHelper::removeFolder($dir);

        // looks like removing folder is not enough to invalidate cache, we also need to clearCache.
        ob_start();
        $app->runControllerFromRawUrl('test/test');
        $output = ob_get_clean();
        echo "output 2: " . $output . "\n";
        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->clearCache('test/test.tpl');

        ob_start();
        $app->runControllerFromRawUrl('test/test');
        $output = ob_get_clean();
        echo "output 3: " . $output . "\n";

        $this->assertEquals('halo2', $output);
    }

    /**
     * This proves nocache tag works.
     */
    public function testNoCache()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/testNoCache.tpl', '{nocache}{$test}{/nocache}');
        $app->getTemplateEngine()->assign('test', 'halo');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCache');
        $output = ob_get_clean();
        echo "output 1: $output";
        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCache');
        $output = ob_get_clean();
        echo "output 2: $output";

        $this->assertEquals('halo2', $output);
    }

    /**
     * This proves nocache affects included files.
     */
    public function testNoCacheInclude()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/_included.tpl', '{$test}');
        file_put_contents($appTestDir.'/testNoCacheInclude.tpl', '{nocache}{include file="test/_included.tpl"}{/nocache}');
        $app->getTemplateEngine()->assign('test', 'halo');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheInclude');
        $output = ob_get_clean();
        echo "output 1: $output";

        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheInclude');
        $output = ob_get_clean();
        echo "output 2: $output";
        $this->assertEquals('halo2', $output);
    }

    /**
     * This proves nocache within a file that has extends would still work.
     */
    public function testNoCacheExtends()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/_mainWrapper.tpl', 'Content is {block name=content}{/block}');
        file_put_contents($appTestDir.'/testNoCacheExtends.tpl', '{extends file="test/_mainWrapper.tpl"}{block name=content}{nocache}{$test}{/nocache}{/block}');
        $app->getTemplateEngine()->assign('test', 'halo');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheExtends');
        $output = ob_get_clean();
//        echo "output 1: $output";

        $this->assertEquals('Content is halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheExtends');
        $output = ob_get_clean();
        $this->assertEquals('Content is halo2', $output);
    }

    /**
     * nocache tag test, this time with a controller.
     */
    public function testNoCacheWithActiveController()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/home';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/_mainWrapper.tpl', 'Content is {block name=content}{/block}');
        file_put_contents($appTestDir.'/index.tpl', '{extends file="test/_mainWrapper.tpl"}{block name=content}{nocache}{$test}{/nocache}{/block}');
        $app->getTemplateEngine()->assign('test', 'halo');
        ob_start();
        $app->runControllerFromRawUrl('home/index');
        $output = ob_get_clean();
//        echo "output 1: $output";

        $this->assertEquals('Content is halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        ob_start();
        $app->runControllerFromRawUrl('home/index');
//        $app->getTemplateEngine()->display($appTestDir.'/index.tpl');
        $output = ob_get_clean();
        $this->assertEquals('Content is halo2', $output);
    }

    /**
     * This proves nocache also works with fetch.
     */
    public function testNoCacheFetch()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/testNoCacheFetch.tpl', '{nocache}{$test}{/nocache}');
        $app->getTemplateEngine()->assign('test', 'halo');
        $output = $app->getTemplateEngine()->fetch('test/testNoCacheFetch.tpl');
        echo "output 1: $output";
        $this->assertEquals('halo', $output);

        $app->getTemplateEngine()->assign('test', 'halo2');
        $output = $app->getTemplateEngine()->fetch('test/testNoCacheFetch.tpl');
        echo "output 2: $output";

        $this->assertEquals('halo2', $output);
    }

    /**
     * This proves nocache also works with fetched text that is assigned to a template.
     */
    public function testNoCacheAssignedFetch()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/testNoCacheAssignedFetch.tpl', '{nocache}{$content}{/nocache}');
        file_put_contents($appTestDir.'/_assignedFetch.tpl', '{nocache}{$test}{/nocache}');
        $content = $app->getTemplateEngine()->fetch('test/_assignedFetch.tpl', array('test' => 'halo'));
        $app->getTemplateEngine()->assign('content', $content);
        ob_start();
        $app->getTemplateEngine()->display('test/testNoCacheAssignedFetch.tpl');
        $output = ob_get_clean();
        echo "output 1: $output";
        $this->assertEquals('halo', $output);

        $content = $app->getTemplateEngine()->fetch('test/_assignedFetch.tpl', array('test' => 'halo2'));
        $app->getTemplateEngine()->assign('content', $content);
        ob_start();
        $app->getTemplateEngine()->display('test/testNoCacheAssignedFetch.tpl');
        $output = ob_get_clean();
        echo "output 2: $output";

        $this->assertEquals('halo2', $output);
    }

    /**
     * This proves nocache also works with fetch that is assigned into an extended template, WITH a rule written below.
     */
    public function testNoCacheExtendsAssignedFetch()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/test';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }

        file_put_contents($appTestDir.'/_assignedFetchWrapper.tpl', 'Content is {block name=content}{/block}');
        // NoCache Rules:
        // 1. NoCache MUST be inside Block
        // 2. NoCache MUST be used in both fetched and parent templates.
        file_put_contents($appTestDir.'/testNoCacheExtendsAssignedFetch.tpl', '{extends file="test/_assignedFetchWrapper.tpl"}{block name=content}{nocache}{$content}{/nocache}{/block}');
        file_put_contents($appTestDir.'/_assignedFetch.tpl', '{nocache}{$test}{/nocache}');
        $content = $app->getTemplateEngine()->fetch('test/_assignedFetch.tpl', array('test' => 'halo'));
        $app->getTemplateEngine()->assign('content', $content);
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheExtendsAssignedFetch');
        $output = ob_get_clean();
        echo "output 1: $output";
        $this->assertEquals('Content is halo', $output);

        $content = $app->getTemplateEngine()->fetch('test/_assignedFetch.tpl', array('test' => 'halo2'));
        $app->getTemplateEngine()->assign('content', $content);
        ob_start();
        $app->runControllerFromRawUrl('test/testNoCacheExtendsAssignedFetch');
        $output = ob_get_clean();
        echo "output 2: $output";

        $this->assertEquals('Content is halo2', $output);
    }

    public function testNoCacheExtendsAssignedFetchWithActiveController()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = __DIR__.'/App/public/default/App/views/home';
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }
        file_put_contents($appTestDir.'/_mainWrapper.tpl', 'Content is {block name=content}{/block}');
        file_put_contents($appTestDir.'/_content.tpl', '{nocache}{$test}{/nocache}');
        file_put_contents($appTestDir.'/testNoCacheFetch.tpl', '{extends file="test/_mainWrapper.tpl"}{block name=content}{nocache}{$content}{/nocache}{/block}');
        ob_start();
        $app->runControllerFromRawUrl('home/testNoCacheFetch', array('test' => 'halo'));
        $output = ob_get_clean();
//        echo "output 1: $output";

        $this->assertEquals('Content is halo', $output);

        ob_start();
        $app->runControllerFromRawUrl('home/testNoCacheFetch', array('test' => 'halo2'));
        $output = ob_get_clean();
        $this->assertEquals('Content is halo2', $output);
    }

    public function testThemeUrlPlugin()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $appTestDir = FileHelper::replaceSeparators(__DIR__.'/App/public/default/App/views/test');
        if (!file_exists($appTestDir)) {
            mkdir($appTestDir);
        }

        file_put_contents(FileHelper::replaceSeparators($appTestDir.'/themeUrl.tpl'), '{theme_url value="test"}');

        print_r($app->getTemplateEngine()->getPluginsDir());
        $output = $app->getTemplateEngine()->fetch('test/themeUrl.tpl');

        $this->assertEquals('http://localhost/skully/public/default/?value=test', $output);
    }
}\Patchwork\Interceptor\applyScheduledPatches();
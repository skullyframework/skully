<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/19/14
 * Time: 3:17 AM
 */

namespace Skully;

use RedBean_IModelFormatter;

class ModelFormatter implements RedBean_IModelFormatter {
    public function formatModel($model) {
        $model = ucfirst($model);
        return "App\\Models\\$model";
    }
}
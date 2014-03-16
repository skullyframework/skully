<?php


namespace Skully;

use RedBean_IModelFormatter;

class ModelFormatter implements RedBean_IModelFormatter {
    public function formatModel($model) {
        $model = ucfirst($model);
        return "App\\Models\\$model";
    }
}
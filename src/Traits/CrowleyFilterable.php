<?php

namespace Crowley\Traits;

use Illuminate\Support\Str;

trait CrowleyFilterable
{
    public function scopeFilter($query, $param)
    {
        foreach ($param as $field => $value) {
            $method = 'filter' . Str::studly($field);

            if ($value == '') {
                continue;
            }

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if (empty($this->fillable) || !is_array($this->fillable)) {
                continue;
            }

            if (in_array($field, $this->fillable)) {
                $query->where($this->table . '.' . $field, $value);
                continue;
            }

            if (key_exists($field, $this->fillable)) {
                $query->where($this->table . '.' . $this->fillable[$field], $value);
                continue;
            }
        }

        return $query;
    }
}

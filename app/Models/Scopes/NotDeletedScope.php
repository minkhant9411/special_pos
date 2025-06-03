<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Schema;

class NotDeletedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();

        // Only apply if the table has 'is_deleted' column
        if (Schema::hasColumn($table, 'is_deleted')) {
            $builder->where($table . '.is_deleted', false);
        }
    }
}

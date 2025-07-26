<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $activeCompany = $user->activeCompany;

        if ($activeCompany) {
            $builder->where($model->getTable() . '.company_id', $activeCompany->company_id);
        } else {
            $builder->whereRaw('1 = 0');
        }
    }
}

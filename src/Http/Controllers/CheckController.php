<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Jacofda\Klaxon\Models\Erp\{Assembly, Shipping, Purchase, Check, Work};
use Jacofda\Klaxon\Models\Company;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function destroy(Request $request)
    {
        Check::find($request->id)->delete();
        return 'done';
    }

    public function toggle(Request $request)
    {
        \DB::table('erp_order_checklist')
            ->where('erp_order_id', $request->order)
            ->where('check_id', $request->id)
            ->update(['status' => $request->status]);
        return $request->status ? 1 : 0;;
    }

    public function manage($checkable_id, $checkable_type)
    {
        $model = $this->getModel($checkable_id, $checkable_type);
        return view('jacofda::core.erp.checks.manage', compact('model'));
    }

    public function managePost(Request $request, $checkable_id, $checkable_type)
    {
        $model = $this->getModel($checkable_id, $checkable_type);
        Check::UpdateChecks($request->checks, $model, $request->check_ids);
        return back()->with('message', 'Qualities Controls Updated');
    }

    public function getModel($checkable_id, $checkable_type)
    {
        $class = '\Jacofda\Klaxon\Models\Erp\\'.$checkable_type;
        if (class_exists($class))
        {
            $model = $class::find($checkable_id);
        }
        else
        {
            $class = '\Jacofda\Klaxon\Models\\'.$checkable_type;
            if (class_exists($class))
            {
                $model = $class::find($checkable_id);
            }

        }
        return $model;
    }



}

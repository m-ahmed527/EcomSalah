<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Throwable;

class PlansController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Plans' => route('admin.plans.index'),
        ];
        return view('screens.admin.stripe-plans.index', get_defined_vars());
    }

    public function getPlansData()
    {
        $plans = Plan::select('id', 'name', 'amount', 'interval', 'trial_days', 'status', 'uses');

        return datatables()->of($plans)
            ->addIndexColumn()
            ->addColumn('amount', function ($row) {
                return number_format($row->amount / 100, 2);
            })
            ->make(true);
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|min:0',
            'interval' => 'required|string|in:day,week,month,year',
            'trial_days' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);
        try {
            DB::beginTransaction();
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $response = $stripe->prices->create([
                'currency' => 'usd',
                'unit_amount' => (int)$request->amount * 100,
                'recurring' => ['interval' => $request->interval, 'trial_period_days' => $request->trial_days ?? null],
                'product_data' => ['name' => $request->name],
                'active' => $request->status ? true : false,

            ]);
            $plan = Plan::create([
                'sripe_price_id' => $response->id,
                'sripe_product_id' => $response->product,
                'name' => $request->name,
                'amount' => (int)$request->amount * 100,
                'interval' => $request->interval,
                'trial_days' => $request->trial_days ?? 0,
                'status' => $request->status ? true : false,
            ]);

            DB::commit();
            return successResponse("Plan created successfully");
        } catch (Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            create_error_log('Creating Plan', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function update(Request $request, Plan $plan)
    {
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            
        ]);
        try {
            DB::beginTransaction();
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $product = $stripe->products->update(
                $plan->sripe_product_id,
                ['name' => $request->has('name') ? $request->name : $plan->name]
            );
            $plan->name = $request->has('name') ? $request->name : $plan->name;
            $plan->save();

            DB::commit();
            return successResponse("Plan updated successfully");
        } catch (Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            create_error_log('Updating Plan', $e);
            return errorResponse("Something went wrong.");
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            DB::beginTransaction();
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            // Deactivate the price in Stripe
            $stripe->products->update(
                $plan->sripe_product_id,
                ['active' => false]
            );
            $plan->delete();
            DB::commit();
            return successResponse("Plan deleted successfully");
        } catch (Throwable $e) {
            dd($e->getMessage());
            DB::rollBack();
            create_error_log('Deleting Plan', $e);
            return errorResponse("Something went wrong.");
        }
    }
}

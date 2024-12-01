<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{

    public function index()
    {
        $datas = country::latest()->get();
        return view('admin.country.index', compact('datas'));
    }

    private function validation(Request $request, $id =null)
    {
        $validator = Validator::make($request->all(), [
            'en_country_name' => 'required|string',
            'country_code' => 'required|string|alpha_num|unique:countries,country_code,'.$id,
            'en_nationality' => 'required|string',
            'alpha_2_code' => 'required|string|size:2|alpha',
            'alpha_3_code' => 'required|string|size:3|alpha',
        ]);

        return $validator;
    }

    public function store(Request $request)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validate = $validator->validated();
        $done = country::create($validate);

        if (!$done) return redirect()->back()->with('error', 'Something Error!!! Try Again.');
        return redirect()->route('countries.index')->with('success', 'Created successfully.');

    }

    public function update(Request $request, country $country)
    {
        $validator = $this->validation($request, $country->id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validate = $validator->validated();
        $done = $country->update($validate);

        if (!$done) return redirect()->back()->with('error', 'Something Error!!! Try Again.');
        return redirect()->route('countries.index')->with('success', 'Update successfully.');
    }
}

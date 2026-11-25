<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = get_active_lang();
        $languages = Language::selection()->get();
        return view('admin.languages.index', compact('lang', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Language::class);
        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.languages.create', compact('lang', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request)
    {
        $this->authorize('create', Language::class);

        $validated = $request->validated();
        try {
            Language::create($validated);
            return redirect()->route('admin.languages.index')->with('success', 'تمت إضافة اللغة بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.languages.index')->with('error', 'هناك خطأ ما');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        $this->authorize('update', $language);
        $lang = get_active_lang();
        $languages = get_active_languages();
        return view('admin.languages.edit', compact('lang', 'languages', 'language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLanguageRequest $request, Language $language)
    {
        $this->authorize('update', $language);

        $validated = $request->validated();
        try {
            $language->update($validated);
            return redirect()->route('admin.languages.index')->with('success', 'تمت تعديل اللغة بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.languages.index')->with('error', 'هناك خطأ ما');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        $this->authorize('delete', $language);

        try {
            $language->delete();
            return redirect()->route('admin.languages.index')->with('success', 'تمت حذف اللغة بنجاح');
        } catch (\Exception $ex){
            return redirect()->route('admin.languages.index')->with('error', 'هناك خطأ ما');
        }
    }






    public function switch($lang)
    {
        // 1. Check if the language is supported (optional but recommended)
        $supportedLocales = ['en', 'ar', 'fr'];

        if (in_array($lang, $supportedLocales)) {
            // 2. Save the language choice in the session
            Session::put('locale', $lang);
            App::setLocale($lang);
        }

        // 3. Send them back to the page they were on
        return redirect()->back();
    }






}

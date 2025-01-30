<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Setting;
use App\Models\Menu;

class FooterComposer
{
    protected $footerData;
    protected $menusData;

    public function __construct()
    {
        // Load footer data once when the composer is initialized
        $this->footerData = Setting::orWhereIn('id', [25, 7, 8, 6, 9, 32, 27, 26, 29, 12])->get();
         // Load menus data
         $this->menusData = Menu::where('status', 1)
         ->with(['menuItems' => function ($query) {
             $query->where('status', 1)->orderBy('sort', 'asc');
         }])
         ->orderBy('sort', 'asc')
         ->get();
    }

    public function compose(View $view)
    {
        // Share the footer data with the view
        $view->with('footer', $this->footerData)
        ->with('menus', $this->menusData);
    }
}

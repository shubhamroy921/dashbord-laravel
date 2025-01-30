# [Soft UI Dashboard Laravel](https://soft-ui-dashboard-laravel.creative-tim.com/login)



*Frontend version*: Soft UI Dashboard v1.0.0. More info at https://www.creative-tim.com/product/soft-ui-dashboard


  



Soft UI Dashboard Laravel comes with dozens of handcrafted UI elements tailored for Bootstrap 5 and an out of the box Laravel backend.

## What am I getting?
You're getting a multi-purpose tool for building complex apps.

Soft UI Dashboard PRO Laravel at a glance:
* 70 handcrafted UI components. From buttons and inputs to navbars and cards, everything is designed to create visually cohesive interfaces.  
* 7 example pages to get you started
* fully-functional authentication system, register and user profile editing features built with Laravel
* Documentation for each component so you can get started fast

## Free for personal and commercial projects
Whether you're working on a side project or delivering to a client, we've got you covered. Soft UI Dashboard Laravel is released under MIT license, so you can use it both for personal and commercial projects for free. All you need to do is start coding. 


## Detailed documentation and example pages
We also included detailed documentation for every component and feature so you can follow along. The pre-built example pages give you a quick glimpse of what Soft UI Dashboard Laravel has to offer so you can get started in no time. 



## Table of Contents

* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Usage](#usage)
* [Versions](#versions)
* [Demo](#demo)
* [Documentation](#documentation)
* [Login](#login)
* [Register](#register)
* [Forgot Password](#forgot-password)
* [Reset Password](#reset-password)
* [User Profile](#user-profile)
* [Dashboard](#dashboard)
* [File Structure](#file-structure)
* [Browser Support](#browser-support)
* [Reporting Issues](#reporting-issues)
* [Licensing](#licensing)
* [Useful Links](#useful-links)
* [Social Media](#social-media)
* [Credits](#credits)

## Prerequisites

If you don't already have an Apache local environment with PHP and MySQL, use one of the following links:



## Installation

1. Unzip the downloaded archive
2. Copy and paste **dashbord** folder in your **projects** folder. Rename the folder to your project's name
3. In your terminal run `composer install`
4. Copy `.env.example` to `.env` and updated the configurations (mainly the database configuration)
5. In your terminal run `php artisan key:generate`
6. Run `php artisan migrate --seed` to create the database tables and seed the roles and users tables
7. Run `php artisan storage:link` to create the storage symlink (if you are using **Vagrant** with **Homestead** for development, remember to ssh into your virtual machine and run the command from there).

## Usage
Register a user or login with default user **admin@softui.com** and password **secret** from your database and start testing (make sure to run the migrations and seeders for these credentials to be available).

Besides the dashboard, the auth pages, the billing and table pages, there is also has an edit profile page. All the necessary files are installed out of the box and all the needed routes are added to `routes/web.php`. Keep in mind that all of the features can be viewed once you login using the credentials provided or by registering your own user. 



| HTML | Laravel |
| --- | --- |
| 

## Demo
| Register | Login | Dashboard |
| --- | --- | ---  |
| 

| Forgot Password Page | Reset Password Page | Profile Page  |
| --- | --- | ---  |
|

### Login

The `App\Http\Controllers\Auth\SessionController` handles the logging in of an existing user.

```
       public function store()
    {
        $attributes = request()->validate([
            'email'=>'required|email',
            'password'=>'required' 
        ]);

        if(Auth::attempt($attributes))
        {
            session()->regenerate();
            return redirect('dashboard');
        }
        else{

            return back();
        }
    }
```

### Register


The `App\Http\Controllers\Auth\RegisterController` handles the registration of a new user.

```
    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'agreement' => ['accepted']
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );

        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        Auth::login($user); 
        return redirect('/dashboard');
    }
```

### Forgot Password
If a user forgets the account's password it is possible to reset the password. For this the user should click on the "**here**" under the login form or add **/login/forgot-password** in the url.

The `App\Http\Controllers\Auth\ResetController` takes care of sending an email to the user where he can reset the password afterwards.

```
    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
```

### Reset Password
The user who forgot the password gets an email on the account's email address. The user can access the reset password page by clicking the button found in the email. The link for resetting the password is available for 12 hours. The user must add the new password and confirm the password for his password to be updated. The user is redirected to the login page.

The `App\Http\Controllers\Auth\ChangePasswordController` helps the user reset the password.

```
    public function changePassword(Request $request)
    {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect('/login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
```

### My Profile
The profile can be accessed by a logged in user by clicking "**User Profile**" from the sidebar or adding **/user-profile** in the url. The user can add information like birthday, gender, phone number, location, language  or skills.

The `App\Http\Controllers\Auth\InfoUserController` handles the user's profile information.

```
    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone'     => ['max:50'],
            'location' => ['max:70'],
            'about_me'    => ['max:150'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
        ]);
        
        User::where('id',Auth::user()->id)
        ->update([
            'name'    => $attributes['name'],
            'email' => $attribute['email'],
            'phone'     => $attributes['phone'],
            'location' => $attributes['location'],
            'about_me'    => $attributes["about_me"],
        ]);

        return redirect('/user-profile');
    }
```

### Dashboard
You can access the dashboard either by using the "**Dashboard**" link in the left sidebar or by adding **/dashboard** in the url after logging in. 

## File Structure
```
app
├── Console
│   └── Kernel.php
├── Exceptions
│   └── Handler.php
├── Http
│   ├── Controllers
│   │   ├── Auth
│   │   │   ├── ChangePasswordController.php
│   │   │   ├── InfoUserController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ResetController.php
│   │   │   ├── SessionController.php
│   │   │   └── Controller.php
│   │   │
│   │   ├── Admin
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── RoleController.php
│   │   │   ├── SettingsController.php
│   │   │   ├── OrderController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── NewsletterController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ProductCategoryController.php
│   │   │   ├── SubCategoryController.php
│   │   │   ├── ProductImageController.php
│   │   │   ├── MenuController.php
│   │   │   ├── MenuItemController.php
│   │   │   └── PageController.php
│   │   │
│   │   ├── Frontend
│   │   │   ├── HomeController.php
│   │   │   ├── ShopController.php
│   │   │   ├── CartController.php
│   │   │   ├── WishlistController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── OrderController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ContactController.php
│   │   │   ├── BlogController.php
│   │   │   ├── NewsletterController.php
│   │   │   └── PageController.php
│   │   │
│   │   ├── Controller.php
│   │
│   ├── Kernel.php
│   └── Middleware
│       ├── Authenticate.php
│       ├── EncryptCookies.php
│       ├── PreventRequestsDuringMaintenance.php
│       ├── RedirectIfAuthenticated.php
│       ├── TrimStrings.php
│       ├── TrustHosts.php
│       ├── TrustProxies.php
│       └── VerifyCsrfToken.php
│
├── Models
│   ├── Cart.php
│   ├── Wishlist.php
│   ├── Product.php
│   ├── ProductCategory.php
│   ├── SubCategory.php
│   ├── Settings.php
│   ├── ProductImage.php
│   ├── Payment.php
│   ├── Page.php
│   ├── Order.php
│   ├── OrderItems.php
│   ├── Menu.php
│   ├── MenuItem.php
│   ├── Newsletter.php
│   ├── User.php
│
├── Policies
│   ├── UsersPolicy.php
│
├── Providers
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── BroadcastServiceProvider.php
│   ├── EventServiceProvider.php
│   └── RouteServiceProvider.php
│
config
├── app.php
├── auth.php
├── broadcasting.php
├── cache.php
├── cors.php
├── database.php
├── filesystems.php
├── hashing.php
├── logging.php
├── mail.php
├── queue.php
├── sanctum.php
├── services.php
├── session.php
├── view.php
│
database
├── factories
│   ├── CartFactory.php
│   ├── WishlistFactory.php
│   ├── ProductFactory.php
│   ├── ProductCategoryFactory.php
│   ├── SubCategoryFactory.php
│   ├── SettingsFactory.php
│   ├── ProductImageFactory.php
│   ├── PaymentFactory.php
│   ├── PageFactory.php
│   ├── OrderFactory.php
│   ├── OrderItemsFactory.php
│   ├── MenuFactory.php
│   ├── MenuItemFactory.php
│   ├── NewsletterFactory.php
│   ├── UserFactory.php
│
├── migrations
│   ├── 2014_10_12_000000_create_users_table.php
│   ├── 2014_10_12_100000_create_password_resets_table.php
│   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│   ├── 2024_01_30_000001_create_carts_table.php
│   ├── 2024_01_30_000002_create_wishlists_table.php
│   ├── 2024_01_30_000003_create_products_table.php
│   ├── 2024_01_30_000004_create_product_categories_table.php
│   ├── 2024_01_30_000005_create_sub_categories_table.php
│   ├── 2024_01_30_000006_create_product_images_table.php
│   ├── 2024_01_30_000007_create_orders_table.php
│   ├── 2024_01_30_000008_create_order_items_table.php
│   ├── 2024_01_30_000009_create_menus_table.php
│   ├── 2024_01_30_000010_create_menu_items_table.php
│   ├── 2024_01_30_000011_create_pages_table.php
│   ├── 2024_01_30_000012_create_payments_table.php
│   ├── 2024_01_30_000013_create_newsletters_table.php
│
├── seeds
│   ├── DatabaseSeeder.php
│   ├── UserSeeder.php
│   ├── ProductSeeder.php
│   ├── OrderSeeder.php
│
public
├── .htaccess
├── favicon.ico
├── index.php
│
routes
├── api.php
├── admin.php
├── channels.php
├── console.php
├── web.php

## Browser Support
At present, we officially aim to support the last two versions of the following browsers:


## Reporting Issues

1. Providing us reproducible steps for the issue will shorten the time it takes for it to be fixed.
2. Some issues may be browser specific, so specifying in what browser you encountered the issue might help.


### Social Media


Instagram: 



Linkedin: [<https://www.linkedin.com/company/updivision?ref=sudl-readme>](https://www.linkedin.com/in/shubham-kumar-16b0b7287/)


## Credits

- [Shubham Kumar]

